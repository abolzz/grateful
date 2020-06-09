<?php

namespace Grateful\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Grateful\Listing;
use Grateful\Purchase;
use DB;

class ListingsController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $listings = Listing::orderBy('id', 'desc')->paginate(6);
        return view('piedavajumi.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'listing_name' => 'required',
            'description' => 'required',
            'quantity' => 'required|integer|between:1,10',
            'price' => 'required|integer|min:1',
            'pickup_time' => 'required|date_format:Y-m-d|after:today'
        ],
        ['listing_name.required' => 'Lūdzu ievadiet piedāvājuma nosaukumu',
         'description.required' => 'Lūdzu ievadiet aprakstu',
         'quantity.required' => 'Lūdzu ievadiet daudzumu',
         'quantity.between' => 'Daudzumam jābūt no 1 līdz 10',
         'price.required' => 'Lūdzu ievadiet cenu',
         'price.min' => 'Cena nevar būt mazāka par 1€',
         'pickup_time.required' => 'Lūdzu ievadiet saņemšanas laiku',
         'pickup_time.after' => 'Nepareizs datums']);

        // Handle file upload
        // if($request->hasFile('cover_image')) {
        //     // Get filename with extension
        //     $filenameWithExt = $request->file('cover_image')->getClientOriginalName();

        //     // Get just filename
        //     $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        //     // Get just the extension
        //     $extension = $request->file('cover_image')->getClientOriginalExtension();
        //     // Filename to store
        //     $filenameToStore = $filename.'_'.time().'.'.$extension;
        //     // Upload image
        //     $path = $request->file('cover_image')->storeAs('public/cover_images', $filenameToStore);
        // }

        // Create a listing
        $listing = new Listing;
        $listing->listing_name = $request->input('listing_name');
        $listing->description = $request->input('description');
        $listing->price = $request->input('price');
        $listing->quantity = $request->input('quantity');
        $listing->pickup_time = $request->input('pickup_time');
        $listing->lister_name = $request->input('lister_name');
        // $shop->cover_image = $filenameToStore;
        $listing->user_id = auth()->user()->id;
        $listing->save();

        return redirect('/dashboard')->with('success', 'Piedāvājums izveidots');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $listing = Listing::find($id);

        // check for correct user
        if(auth()->user()->email !== $listing->lister_name) {
            return redirect('/piedavajumi')->with('error', 'Nav pieejas');
        }

        return view('piedavajumi.edit')->with('listing', $listing);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'listing_name' => 'required',
            'description' => 'required',
            'quantity' => 'required|integer|between:1,10',
            'price' => 'required|integer|min:1',
            'pickup_time' => 'required|date_format:Y-m-d|after:today'
        ],
        ['listing_name.required' => 'Lūdzu ievadiet piedāvājuma nosaukumu',
         'description.required' => 'Lūdzu ievadiet aprakstu',
         'quantity.required' => 'Lūdzu ievadiet daudzumu',
         'quantity.between' => 'Daudzumam jābūt no 1 līdz 10',
         'price.required' => 'Lūdzu ievadiet cenu',
         'price.min' => 'Cena nevar būt mazāka par 1€',
         'pickup_time.required' => 'Lūdzu ievadiet saņemšanas laiku',
         'pickup_time.after' => 'Nepareizs datums']);

        // Handle file upload
        // if($request->hasFile('cover_image')) {
        //     // Get filename with extension
        //     $filenameWithExt = $request->file('cover_image')->getClientOriginalName();

        //     // Get just filename
        //     $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        //     // Get just the extension
        //     $extension = $request->file('cover_image')->getClientOriginalExtension();
        //     // Filename to store
        //     $filenameToStore = $filename.'_'.time().'.'.$extension;
        //     // Upload image
        //     $path = $request->file('cover_image')->storeAs('public/cover_images', $filenameToStore);
        // }

        // Edit a listing
        $listing = Listing::find($id);
        $listing->listing_name = $request->input('listing_name');
        $listing->description = $request->input('description');
        $listing->price = $request->input('price');
        $listing->quantity = $request->input('quantity');
        $listing->pickup_time = $request->input('pickup_time');
        $listing->lister_name = $request->input('lister_name');
        // if($request->hasFile('cover_image')) {
        //     $shop->cover_image = $filenameToStore;
        // }
        $listing->save();

        return redirect('/dashboard')->with('success', 'Piedāvājums labots');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $listing = Listing::find($id);

        // check for correct user
        if(auth()->user()->id !== $listing->user_id) {
            return redirect('/piedavajumi')->with('error', 'Nav pieejas');
        }

        // Delete the image
        // Storage::delete('public/cover_images/'.$shop->cover_image);

        $listing->delete();

        return redirect('/piedavajumi')->with('success', 'Piedāvājums dzēsts');
    }

        public function buy(Request $request)
    {   

        if($request->has('boughtListing')) {

            // Create a purchase
            $purchase = new Purchase;

            $bought_listing = $request->get('boughtListing');
            $bought_quantity = $request->get('boughtQuantity');
            $listerName = $request->get('lister_name');

            $listings = Listing::where('listing_name', $request->get('boughtListing'))->first();
            $price = $bought_quantity * $listings->price;

        }

        $gateway = new Braintree_Gateway([
            'environment' => 'sandbox',
            'merchantId' => 'mz5fgmzpfsvs3fr7',
            'publicKey' => 'd86b5qmcg38np4mh',
            'privateKey' => 'fa4ed398b8e52b26665c9e2201d868af'
        ]);
    
        $clientToken = $gateway->clientToken()->generate();



        // check for correct user
        // if(auth()->user()->email !== $listing->lister_name) {
        //     return redirect('/piedavajumi')->with('error', 'Nav pieejas');
        // }

        return view('piedavajumi')->with('success', 'Pirkums izdarīts');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
}
