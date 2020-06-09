<?php

namespace Grateful\Http\Controllers;

use Illuminate\Http\Request;
use Grateful\Purchase;
use Grateful\Shop;
use DB;

class PagesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index']]);
    }

    public function index(){
        $title = 'Grateful';
        return view('pages.index')->with('title', $title);
    }

    public function map(){
        $shops = Shop::all();
        // $data = [
        //     'shop_lat'   => $shops->address_latitude,
        //     'shop_lng' => $shops->address_longtitude
        // ];
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
