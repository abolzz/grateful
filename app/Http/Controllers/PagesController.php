<?php

namespace Grateful\Http\Controllers;

use Illuminate\Http\Request;
use Grateful\Purchase;
use Grateful\Shop;
use DB;

class PagesController extends Controller
{

    public function index(){
        $title = 'Grateful';
        return view('pages.index')->with('title', $title);
    }

    public function map(){
        $shops = Shop::all();
        return view('pages.karte')->with('shops', $shops);
    }

    public function purchases(){
        $purchases = Purchase::all();
        return view('pages.pirkumi')->with('purchases', $purchases);
    }

    public function profile(){
        return view('pages.profils');
    }
}
