<?php

namespace Grateful\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Grateful\Shop;
use Grateful\Listing;
use Grateful\Like;
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

        $shops = Shop::orderBy('likes', 'desc')->paginate(6);
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
        ], [
            'name.unique' => 'Šis nosaukums jau reģistrēts.',
       ]);

        // Handle file upload
        if($request->hasFile('cover_image')) {
            $image_name = $request->file('cover_image')->getRealPath();
            Cloudder::upload($image_name, null);
            $cover_image_id = Cloudder::getPublicId();
        }

        if($request->hasFile('logo_image')) {
            $logo_image_name = $request->file('logo_image')->getRealPath();
            Cloudder::upload($logo_image_name, null, ["folder" => "logos"]);
            $logo_image_id = Cloudder::getPublicId();
        }

        // Create a shop
        $shop = new Shop;
        $shop->name = $request->input('name');
        $shop->address = $request->input('address');
        $shop->email = auth()->user()->email;
        $shop->phone = $request->input('phone');
        $shop->type = implode(',', $request->input('type'));

        if ($request->hasFile('cover_image')) {
            $shop->cover_image = $cover_image_id;
        } else {
            $shop->cover_image = "image-placeholder_rrc5fk.jpg";
        }
        if ($request->hasFile('logo_image')) {
            $shop->logo_image = $logo_image_id;
        } else {
            $shop->logo_image = "image-placeholder_rrc5fk.jpg";
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
        $likes = Like::all()->where('liked_shop', $shop->id);
        return view('veikali.show')->with(['shop'=>$shop,'listings'=>$listings,'likes'=>$likes]);
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
            'cover_image' => 'image|max:1999'
        ]);

        // Handle file upload
        if($request->hasFile('cover_image')) {
            $image_name = $request->file('cover_image')->getRealPath();
            Cloudder::upload($image_name, null);
            $cover_image_id = Cloudder::getPublicId();
        }

        if($request->hasFile('logo_image')) {
            $logo_image_name = $request->file('logo_image')->getRealPath();
            Cloudder::upload($logo_image_name, null, ["folder" => "logos"]);
            $logo_image_id = Cloudder::getPublicId();
        }

        // Edit a shop
        $shop = Shop::find($id);
        $shop->name = $request->input('name');
        $shop->address = $request->input('address');
        $shop->phone = $request->input('phone');
        $shop->type = implode(',', $request->input('type'));

        if($request->hasFile('cover_image')) {
            // Delete the old image
            Cloudder::destroy($shop->cover_image);
            // and upload the new one
            $shop->cover_image = $cover_image_id;
        } else {
            $shop->cover_image = $shop->cover_image;
        }
        if($request->hasFile('logo_image')) {
            // Delete the old image
            Cloudder::destroy($shop->logo_image);
            // and upload the new one
            $shop->logo_image = $logo_image_id;
        } else {
            $shop->logo_image = $shop->logo_image;
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

        // Delete the cover image if not placeholder
        if($shop->cover_image != "image-placeholder_rrc5fk.jpg") {
            Cloudder::destroy($shop->cover_image);
        }

        $shop->delete();

        return redirect('/veikali')->with('success', 'Veikals dzēsts');
    }
}
