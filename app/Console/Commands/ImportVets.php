<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ImportVets extends Command
{
    protected $signature = 'petup:import-vets
        {--file=data/veterinarias.csv : Ruta dentro de storage/app}
        {--format=csv : csv|geojson}
        {--truncate : Vaciar tabla antes de importar}
        {--chunk=2000 : Tamaño de lote para upsert}
        {--dry : Dry-run, no escribe en BD}';

    protected $description = 'Importa veterinarias (Jalisco) desde CSV o GeoJSON del IIEG';

    /** Encabezados canónicos esperados en la tabla */
    private array $expected = [
        'source_id','source',
        'name','activity_code','activity_name',
        'municipality','locality','neighborhood','postal_code',
        'tipo_vial','nom_vial','numero_ext','letra_ext',
        'phone','email','website',
        'lat','lng','date_registered',
    ];

    /** Sinónimos -> canónico (encabezados del IIEG o variantes) */
    private array $synonyms = [
        'clee' => 'source_id',
        'nom_estab' => 'name',
        'nom_establecimiento' => 'name',

        'codigo_act' => 'activity_code',
        'nombre_act' => 'activity_name',
        'descripcion' => 'activity_name',

        'municipio' => 'municipality',
        'localidad' => 'locality',
        'nomb_asent' => 'neighborhood',
        'cod_postal' => 'postal_code',

        'tipo_vial' => 'tipo_vial',
        'nom_vial'  => 'nom_vial',
        'numero_ext' => 'numero_ext',
        'letra_ext'  => 'letra_ext',

        'telefono' => 'phone',
        'correoelec' => 'email',
        'www' => 'website',

        'latitud' => 'lat',
        'longitud' => 'lng',
        'fecha_alta' => 'date_registered',
    ];

    public function handle(): int
    {
        // Opciones
        $file     = (string) $this->option('file');
        $format   = strtolower((string) $this->option('format'));
        $truncate = (bool) $this->option('truncate');
        $chunk    = (int) $this->option('chunk');
        $dry      = (bool) $this->option('dry');

        // Normalizar ruta relativa y construir ruta absoluta dentro de storage/app
        $rel = ltrim($file, "/\\");
        // Si el usuario puso "storage/app/..." o "app/..." lo limpiamos:
        $rel = preg_replace('#^(storage/app/|app/)+#', '', $rel);
        $abs = storage_path('app' . DIRECTORY_SEPARATOR . $rel);

        if (!is_file($abs)) {
            $this->error("No existe: {$abs}");
            $this->line('Ejemplos válidos:');
            $this->line('  php artisan petup:import-vets --file=Veterinarias.csv --format=csv');
            $this->line('  php artisan petup:import-vets --file=public/Veterinarias.csv --format=csv');
            $this->line('  php artisan petup:import-vets --file=private/Veterinarias.csv --format=csv');
            return self::FAILURE;
        }

        if (!in_array($format, ['csv','geojson'], true)) {
            $this->error("Formato no soportado: {$format}. Usa --format=csv|geojson");
            return self::FAILURE;
        }

        if ($truncate && !$dry) {
            \DB::table('veterinaries')->truncate();
            $this->warn('Tabla veterinaries TRUNCADA.');
        }

        try {
            $this->info(($dry ? '[DRY] ' : '') . "Importando desde: {$abs}");
            $count = $format === 'geojson'
                ? $this->importGeojson($abs, $chunk, $dry)
                : $this->importCsv($abs, $chunk, $dry);

            $this->info(($dry ? '[DRY] ' : '') . "Importadas/actualizadas: {$count}");
            return self::SUCCESS;
        } catch (\Throwable $e) {
            $this->error($e->getMessage());
            return self::FAILURE;
        }
    }

    /** -------- CSV -------- */
    private function importCsv(string $absPath, int $chunk, bool $dry): int
    {
        $fh = fopen($absPath, 'r');
        if (!$fh) throw new \RuntimeException("No se pudo abrir el CSV");

        // 1) Leer primera línea cruda y limpiar BOM
        $first = fgets($fh);
        if ($first === false) throw new \RuntimeException("CSV vacío");
        $first = preg_replace('/^\xEF\xBB\xBF/', '', $first);

        // 2) Si el CSV trae "sep=;" o "sep=,", detectarlo y saltarlo
        $sepLine = null;
        if (preg_match('/^sep\s*=\s*([,;|\t])\s*$/i', trim($first), $m)) {
            $sepLine = $m[1];
        }

        // 3) Detectar separador probando candidatos y validando encabezados
        $candidates = $sepLine ? [$sepLine] : [',',';',"\t",'|'];
        $delimiter = null; $headers = null;

        foreach ($candidates as $cand) {
            rewind($fh);
            if ($sepLine) { fgets($fh); } // saltar la línea "sep=…"
            $try = fgetcsv($fh, 0, $cand);
            if (!$try) continue;

            // Normalizar encabezados
            $try = array_map(fn($h) => trim($h, " \t\n\r\0\x0B\"'"), $try);

            [$map, $present] = $this->buildHeaderMap($try);
            if ($present['name'] && $present['lat'] && $present['lng']) {
                $delimiter = $cand;
                $headers   = $try;
                break;
            }
        }

        if (!$delimiter) {
            // Debug útil
            $this->warn('No pude validar encabezados con ningún separador.');
            $this->warn('Probados: ' . implode(' ', $candidates));
            $this->warn('Primera línea (sanitizada): ' . mb_strimwidth($first, 0, 200, '…'));
            throw new \RuntimeException("Faltan columnas mínimas: name, lat, lng");
        }

        // Mapa final con el separador correcto
        rewind($fh);
        if ($sepLine) { fgets($fh); } // saltar "sep=…"
        $headers = fgetcsv($fh, 0, $delimiter);
        $headers = array_map(fn($h) => trim($h, " \t\n\r\0\x0B\"'"), $headers);
        [$map, $present] = $this->buildHeaderMap($headers);

        $batch = []; $written = 0; $rowN = 0;
        while (($row = fgetcsv($fh, 0, $delimiter)) !== false) {
            $rowN++;
            $rec = $this->rowToAssoc($row, $map);

            if (empty($rec['name'])) continue;

            $lat = $this->toFloat($rec['lat'] ?? null);
            $lng = $this->toFloat($rec['lng'] ?? null);
            if ($lat === null || $lng === null) continue;

            $rec['lat'] = $lat;
            $rec['lng'] = $lng;
            $rec['activity_code']   = $this->toIntOrNull($rec['activity_code'] ?? null);
            $rec['date_registered'] = $this->normalizeDate($rec['date_registered'] ?? null);
            if (empty($rec['source'])) $rec['source'] = 'IIEG';
            if (empty($rec['source_id'])) $rec['source_id'] = $this->tempSourceId($rec);

            $rowForDb = $this->filterExpected($rec);
            $rowForDb['created_at'] = now();
            $rowForDb['updated_at'] = now();

            $batch[] = $rowForDb;

            if (!$dry && count($batch) >= $chunk) {
                $this->flush($batch);
                $written += count($batch);
                $batch = [];
            }
        }
        fclose($fh);

        if (!$dry && $batch) {
            $this->flush($batch);
            $written += count($batch);
        }

        return $dry ? $rowN : $written;
    }

    private function guessDelimiter(string $line): string
    {
        // candidatos comunes: coma, punto y coma, tab, barra
        $candidates = [',',';',"\t",'|'];
        $counts = [];
        foreach ($candidates as $d) {
            $counts[$d] = substr_count($line, $d);
        }
        arsort($counts);
        $delim = array_key_first($counts);
        return ($counts[$delim] ?? 0) > 0 ? $delim : ',';
    }


    /** -------- GeoJSON -------- */
    private function importGeojson(string $absPath, int $chunk, bool $dry): int
    {
        $json = file_get_contents($absPath);
        $data = json_decode($json, true);
        if (!$data || !isset($data['features'])) throw new \RuntimeException("GeoJSON inválido");

        $batch = []; $written = 0; $rowN = 0;
        foreach ($data['features'] as $f) {
            $rowN++;
            $p = $f['properties'] ?? [];
            $g = $f['geometry']['coordinates'] ?? null; // [lng, lat]

            $rec = [
                // ids y básicos
                'source_id'     => $this->clean($p['clee'] ?? null),
                'source'        => 'IIEG',
                'name'          => $this->clean($p['nom_estab'] ?? $p['nom_establecimiento'] ?? null),
                'activity_code' => $this->toIntOrNull($p['codigo_act'] ?? null),
                'activity_name' => $this->clean($p['nombre_act'] ?? $p['descripcion'] ?? null),

                // ubicación postal
                'municipality'  => $this->clean($p['municipio'] ?? null),
                'locality'      => $this->clean($p['localidad'] ?? null),
                'neighborhood'  => $this->clean($p['nomb_asent'] ?? null),
                'postal_code'   => $this->clean($p['cod_postal'] ?? null),

                // dirección
                'tipo_vial'     => $this->clean($p['tipo_vial'] ?? null),
                'nom_vial'      => $this->clean($p['nom_vial'] ?? null),
                'numero_ext'    => $this->clean($p['numero_ext'] ?? null),
                'letra_ext'     => $this->clean($p['letra_ext'] ?? null),

                // contacto
                'phone'         => $this->clean($p['telefono'] ?? null),
                'email'         => $this->clean($p['correoelec'] ?? null),
                'website'       => $this->clean($p['www'] ?? null),

                // geo y fecha
                'lat'           => isset($g[1]) ? $this->toFloat($g[1]) : $this->toFloat($p['latitud'] ?? null),
                'lng'           => isset($g[0]) ? $this->toFloat($g[0]) : $this->toFloat($p['longitud'] ?? null),
                'date_registered' => $this->normalizeDate($p['fecha_alta'] ?? null),
            ];

            if (empty($rec['name']) || $rec['lat'] === null || $rec['lng'] === null) continue;
            if (empty($rec['source_id'])) $rec['source_id'] = $this->tempSourceId($rec);

            $rowForDb = $this->filterExpected($rec);
            $rowForDb['created_at'] = now();
            $rowForDb['updated_at'] = now();

            $batch[] = $rowForDb;

            if (!$dry && count($batch) >= $chunk) { $this->flush($batch); $written += count($batch); $batch = []; }
        }

        if (!$dry && $batch) { $this->flush($batch); $written += count($batch); }

        return $dry ? $rowN : $written;
    }

    /** ---------------- helpers ---------------- */

    private function buildHeaderMap(array $headers): array
    {
        $norm = fn($s) => trim(mb_strtolower($s ?? ''));
        $map = []; $present = array_fill_keys($this->expected, false);

        foreach ($headers as $i => $h) {
            $h = $norm($h);
            $canon = $this->synonyms[$h] ?? $h;
            $map[$i] = $canon;
            if (isset($present[$canon])) $present[$canon] = true;
            if ($canon === 'name') $present['name'] = true;
            if ($canon === 'lat')  $present['lat']  = true;
            if ($canon === 'lng')  $present['lng']  = true;
        }
        return [$map, $present];
    }

    private function rowToAssoc(array $row, array $map): array
    {
        $out = [];
        foreach ($row as $i => $val) {
            $key = $map[$i] ?? null;
            if ($key === null) continue;
            $out[$key] = $this->clean($val);
        }
        return $out;
    }

    private function clean(?string $v): ?string
    {
        if ($v === null) return null;
        $v = trim($v);
        if ($v === '' || strtolower($v) === 'null' || strtolower($v) === 'nan') return null;
        if (!mb_check_encoding($v, 'UTF-8')) {
            $v = mb_convert_encoding($v, 'UTF-8', 'ISO-8859-1');
        }
        return $v;
    }

    private function toFloat($v): ?float
    {
        if ($v === null || $v === '') return null;
        if (is_string($v)) $v = str_replace(',', '.', trim($v));
        return is_numeric($v) ? (float)$v : null;
    }

    private function toIntOrNull($v): ?int
    {
        if ($v === null || $v === '') return null;
        return is_numeric($v) ? (int)$v : null;
    }

    private function normalizeDate(?string $v): ?string
    {
        if (!$v) return null;
        $v = trim($v);
        if (preg_match('/^\d{4}-\d{2}$/', $v)) return $v.'-01';
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $v)) return $v;
        return null;
    }

    private function tempSourceId(array $r): string
    {
        $key = implode('|', [
            $r['name'] ?? '',
            $r['municipality'] ?? '',
            $r['locality'] ?? '',
            $r['nom_vial'] ?? '',
            $r['lat'] ?? '',
            $r['lng'] ?? '',
        ]);
        return 'TMP-'.substr(sha1($key), 0, 24);
    }

    private function filterExpected(array $rec): array
    {
        $row = [];
        foreach ($this->expected as $col) {
            if (array_key_exists($col, $rec)) $row[$col] = $rec[$col];
        }
        // aseguramos opcionales que están en la tabla
        foreach (['tipo_vial','nom_vial','numero_ext','letra_ext','email'] as $opt) {
            if (array_key_exists($opt, $rec)) $row[$opt] = $rec[$opt];
        }
        return $row;
    }

    private function flush(array $rows): void
    {
        DB::table('veterinaries')->upsert(
            $rows,
            ['source_id'], // clave única
            [
                'source','name','activity_code','activity_name',
                'municipality','locality','neighborhood','postal_code',
                'tipo_vial','nom_vial','numero_ext','letra_ext',
                'phone','email','website','lat','lng','date_registered',
                'updated_at'
            ]
        );
    }
}
