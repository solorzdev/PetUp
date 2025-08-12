<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function about()    { return view('pages.about'); }
    public function faq()      { return view('pages.faq'); }

    public function map()
    {
        // DEMO: casos con lat/lng (GDL aprox). Sustituiremos por BD.
        $cases = [
            ['id'=>1,'nombre'=>'Max','tipo'=>'perro','estado'=>'perdido','lat'=>20.674, 'lng'=>-103.387, 'zona'=>'Americana','fecha'=>'2025-02-01'],
            ['id'=>2,'nombre'=>'Luna','tipo'=>'gato','estado'=>'avistado','lat'=>20.680, 'lng'=>-103.373, 'zona'=>'Zona Centro','fecha'=>'2025-02-04'],
            ['id'=>3,'nombre'=>'Toby','tipo'=>'perro','estado'=>'reunido','lat'=>20.661, 'lng'=>-103.394, 'zona'=>'Moderna','fecha'=>'2025-02-06'],
            ['id'=>4,'nombre'=>'Michi','tipo'=>'gato','estado'=>'perdido','lat'=>20.695, 'lng'=>-103.358, 'zona'=>'Oblatos','fecha'=>'2025-02-03'],
            ['id'=>5,'nombre'=>'Coco','tipo'=>'perro','estado'=>'avistado','lat'=>20.668, 'lng'=>-103.353, 'zona'=>'Analco','fecha'=>'2025-02-05'],
        ];

        return view('pages.map', compact('cases'));
    }

    public function reunions() { return view('pages.reunions'); }
    public function pricing()  { return view('pages.pricing'); }
}
