<?php

namespace App\Http\Controllers;

use App\Models\Veterinary;
use Illuminate\Http\Request;

class VeterinaryController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'municipality' => 'sometimes|string|max:100',
            'q'            => 'sometimes|string|max:120',
            'clinics'      => 'sometimes|boolean',
            'bbox'         => 'sometimes|string', // "minLng,minLat,maxLng,maxLat"
            'limit'        => 'sometimes|integer|min:1|max:5000',
        ]);

        $limit = (int) $request->input('limit', 2000);

        $q = Veterinary::query()->select([
            'id','name',
            'municipality','locality','neighborhood','postal_code',
            'tipo_vial','nom_vial','numero_ext','letra_ext',
            'phone','email','website','lat','lng',
            'activity_code','activity_name',
        ]);

        if ($request->boolean('clinics')) {
            $q->where('activity_code', 'like', '54194%');
        }
        if ($m = $request->input('municipality')) {
            $q->where('municipality', $m);
        }
        if ($text = $request->input('q')) {
            $q->where(function ($qq) use ($text) {
                $qq->where('name', 'like', "%{$text}%")
                   ->orWhere('activity_name', 'like', "%{$text}%");
            });
        }
        if ($bbox = $request->input('bbox')) {
            $p = array_map('floatval', explode(',', $bbox));
            if (count($p) === 4) {
                [$minLng,$minLat,$maxLng,$maxLat] = $p;
                $q->whereBetween('lat', [$minLat, $maxLat])
                  ->whereBetween('lng', [$minLng, $maxLng]);
            }
        }

        $rows = $q->limit($limit)->get()->map(function (Veterinary $v) {
            return [
                'id'           => $v->id,
                'name'         => $v->name,
                'municipality' => $v->municipality,
                'locality'     => $v->locality,
                'neighborhood' => $v->neighborhood,
                'postal_code'  => $v->postal_code,
                'address'      => $v->full_address, // accessor del modelo
                'phone'        => $v->phone,
                'email'        => $v->email,
                'website'      => $v->website,
                'lat'          => $v->lat,
                'lng'          => $v->lng,
                'activity'     => $v->activity_name,
            ];
        });

        $flags = JSON_UNESCAPED_UNICODE;                 // no \u00f3 etc.
        if ($request->boolean('pretty')) $flags |= JSON_PRETTY_PRINT; // opcional

        return response()->json(
            ['count' => $rows->count(), 'data' => $rows],
            200,
            [],
            $flags
        );
    }
}
