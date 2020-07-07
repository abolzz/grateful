<?php

namespace Grateful\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Grateful\Shop;
use Grateful\Listing;
use DB;
use JD\Cloudder\Facades\Cloudder;

class ShopsController extends Controller
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $shops = Shop::all();

        $shops = Shop::orderBy('id', 'desc')->paginate(6);
        return view('veikali.index')->with('shops', $shops);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('veikali.create');
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
            'name' => 'required|unique:shops,name,',
            'address' => 'required',
            'email' => 'required|email|unique:shops,email,'
        ], [
            'email.unique' => 'Šī e-pasta adrese jau reģistrēta.',
            'name.unique' => 'Šis nosaukums jau reģistrēts.',
       ]);

        // Handle file upload
        if($request->hasFile('cover_image')) {
            // Get filename with extension
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();

            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just the extension
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            // Filename to store
            $filenameToStore = $filename.'_'.time().'.'.$extension;
            // Upload image
            $path = $request->file('cover_image')->storeAs('public/cover_images', $filenameToStore);

            $image_name = $request->file('cover_image')->getRealPath();
            Cloudder::upload($image_name, null);
            $cover_image_id = Cloudder::getPublicId();
            // Cloudder::upload($image_name, array("public_id" => $filename));
        }

        // Create a shop
        $shop = new Shop;
        $shop->name = $request->input('name');
        $shop->address = $request->input('address');
        $shop->email = $request->input('email');
        $shop->phone = $request->input('phone');
        $shop->type = $request->input('type');
        if ($request->hasFile('cover_image')) {
            $shop->cover_image = $cover_image_id;
        } else {
            $shop->cover_image = "image-placeholder_rrc5fk.jpg";
        }
        $shop->user_id = auth()->user()->id;
        $shop->save();

        return redirect('/veikali')->with('success', 'Veikals izveidots');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $shop = Shop::find($id);
        $listings = Listing::all()->where('lister_name', $shop->email);
        return view('veikali.show')->with(['shop'=>$shop,'listings'=>$listings]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $shop = Shop::find($id);

        // check for correct user
        if(auth()->user()->id !== $shop->user_id) {
            return redirect('/veikali')->with('error', 'Nav pieejas');
        }

        return view('veikali.edit')->with('shop', $shop);
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
            'name' => 'required',
            'address' => 'required',
            'email' => 'required',
            'cover_image' => 'image|max:1999'
        ]);

        // Handle file upload
        if($request->hasFile('cover_image')) {
            // Get filename with extension
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();

            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just the extension
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            // Filename to store
            $filenameToStore = $filename.'_'.time().'.'.$extension;
            // Upload image
            $path = $request->file('cover_image')->storeAs('public/cover_images', $filenameToStore);
        }

        // Edit a shop
        $shop = Shop::find($id);
        $shop->name = $request->input('name');
        $shop->address = $request->input('address');
        $shop->email = $request->input('email');
        $shop->phone = $request->input('phone');
        $shop->type = $request->input('type');
        if($request->hasFile('cover_image')) {
            $shop->cover_image = $filenameToStore;
        }
        $shop->save();

        return redirect('/veikali')->with('success', 'Veikals labots');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $shop = Shop::find($id);

        // check for correct user
        if(auth()->user()->id !== $shop->user_id) {
            return redirect('/veikali')->with('error', 'Nav pieejas');
        }

        // Delete the image
        Storage::delete('public/cover_images/'.$shop->cover_image);

        $shop->delete();

        return redirect('/veikali')->with('success', 'Veikals dzēsts');
    }
}
