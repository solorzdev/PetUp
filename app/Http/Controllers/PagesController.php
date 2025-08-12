<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function about()    { return view('pages.about'); }
    public function faq()      { return view('pages.faq'); }
    public function map()      { return view('pages.map'); }
    public function reunions() { return view('pages.reunions'); }
    public function pricing()  { return view('pages.pricing'); }
}
