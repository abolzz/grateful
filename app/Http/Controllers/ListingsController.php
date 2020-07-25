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
        $min_time = \Carbon\Carbon::now()->addMinutes(30)->timezone('Europe/Riga')->format('H:i');

        $this->validate($request, [
            'listing_name' => 'required',
            'description' => 'required',
            'quantity' => 'required|integer|between:1,10',
            'price' => 'required|integer|min:1',
            'pickup_time' => 'required' 
        ],
        ['listing_name.required' => 'Lūdzu ievadiet piedāvājuma nosaukumu',
         'description.required' => 'Lūdzu ievadiet aprakstu',
         'quantity.required' => 'Lūdzu ievadiet daudzumu',
         'quantity.between' => 'Daudzumam jābūt no 1 līdz 10',
         'price.required' => 'Lūdzu ievadiet cenu',
         'price.min' => 'Cena nevar būt mazāka par 1€',
         'pickup_time.required' => 'Lūdzu ievadiet saņemšanas laiku']);

        // Create a listing
        $listing = new Listing;
        $listing->listing_name = $request->input('listing_name');
        $listing->description = $request->input('description');
        $listing->price = $request->input('price');
        $listing->quantity = $request->input('quantity');
        $date = \Carbon\Carbon::today()->toDateString();
        $time = $request->input('pickup_time');
        $listing->pickup_time = $date . ' ' . $time . ':00';
        $listing->lister_name = $request->input('lister_name');
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
            'pickup_time' => 'required'
        ],
        ['listing_name.required' => 'Lūdzu ievadiet piedāvājuma nosaukumu',
         'description.required' => 'Lūdzu ievadiet aprakstu',
         'quantity.required' => 'Lūdzu ievadiet daudzumu',
         'quantity.between' => 'Daudzumam jābūt no 1 līdz 10',
         'price.required' => 'Lūdzu ievadiet cenu',
         'price.min' => 'Cena nevar būt mazāka par 1€',
         'pickup_time.required' => 'Lūdzu ievadiet saņemšanas laiku']);

        // Edit a listing
        $listing = Listing::find($id);
        $listing->listing_name = $request->input('listing_name');
        $listing->description = $request->input('description');
        $listing->price = $request->input('price');
        $listing->quantity = $request->input('quantity');
        $date = \Carbon\Carbon::today()->toDateString();
        $time = $request->input('pickup_time');
        $listing->pickup_time = $date . ' ' . $time . ':00';
        $listing->lister_name = $request->input('lister_name');
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

        $listing->delete();

        return redirect('/piedavajumi')->with('success', 'Piedāvājums dzēsts');
    }
}
