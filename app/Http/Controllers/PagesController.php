<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index(){
        $title = 'Grateful';
        return view('pages.index')->with('title', $title);
    }

    public function map(){
        return view('pages.karte');
    }

    public function purchases(){
        return view('pages.pirkumi');
    }

    public function profile(){
        return view('pages.profils');
    }
}
