<?php
namespace App\Http\Controllers;

class PageController extends Controller
{
    public function homepage(){ return view('pages.homepage');}
    public function archives(){ return view('pages.archives');}
    public function apply(){ return view('pages.apply');}
    public function contact(){ return view('pages.contact');}
}

