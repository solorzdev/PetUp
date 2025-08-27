<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Veterinary extends Model
{
    protected $fillable = [
        // Origen
        'source_id','source',
        // Básicos
        'name','activity_code','activity_name',
        // Ubicación postal
        'municipality','locality','neighborhood','postal_code',
        // Dirección en partes
        'tipo_vial','nom_vial','numero_ext','letra_ext',
        // Contacto
        'phone','email','website',
        // Geo/fecha
        'lat','lng','date_registered',
    ];

    protected $casts = [
        'lat' => 'float',
        'lng' => 'float',
        'activity_code' => 'integer',
        'date_registered' => 'date',
    ];

    // Dirección completa calculada (para JSON/Blade)
    protected $appends = ['full_address'];
    public function getFullAddressAttribute(): ?string
    {
        $parts = array_filter([$this->tipo_vial, $this->nom_vial, $this->numero_ext, $this->letra_ext]);
        return $parts ? trim(preg_replace('/\s+/', ' ', implode(' ', $parts))) : null;
    }

    // Útil si luego quieres mostrar solo clínicas
    public function scopeClinics($q)
    {
        return $q->where('activity_code', 'like', '54194%');
    }
}
