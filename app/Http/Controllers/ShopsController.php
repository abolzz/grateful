<?php

namespace Grateful\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Grateful\Shop;
use Grateful\Listing;
use DB;

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
        }

        // Create a shop
        $shop = new Shop;
        $shop->name = $request->input('name');
        $shop->address = $request->input('address');
        $shop->email = $request->input('email');
        $shop->phone = $request->input('phone');
        $shop->type = $request->input('type');
        if ($request->hasFile('cover_image')) {
            $shop->cover_image = $filenameToStore;
        } else {
            $shop->cover_image = "placeholder.jpg";
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
     * Search for shops by name
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    // public function search(Request $request) {
    //     if($request->ajax()){
    //         $query = $request->get('query');
    //         if($query != ''){
    //             $data = DB::table('shops')->where('name', 'like', '%'.$query.'%')->get();
    //         } else {
    //           $data = DB::table('shops')->get(); 
    //         }

    //         // check if there are results
    //         $total_row = $data->count();
    //         if($total_row > 0){
    //             foreach($data as $row){
    //                 $output .= '<li>
    //                                 <a href="/veikali/{{$row->id}}">
                                    
    //                                     <div class="well">
    //                                         <div class="row">
    //                                             <div class="col-md-4 col-sm-4">
    //                                                 <img style="width:100%" src="/storage/cover_images/{{$row->cover_image}}">
    //                                             </div>
    //                                             <div class="col-md-8 col-sm-8">
    //                                                 <h3>{{$row->name}}</h3>
    //                                                 <p>{{$row->address}}</p>
    //                                                 <small>{{$row->type}}</small>
    //                                             </div>
    //                                         </div>
    //                                     </div>

    //                                 </a>
    //                             </li>';
    //             }
    //         } else {
    //             $output = '<span>Hmmm.. Nevarējām atrast. Pamēģini vēlreiz!</span>';
    //         }

    //         $data = array('table_data' => $output);

    //         echo json_encode($data);
    //     }
    // }

    // public function search(Request $request){
    //     $search = $request->input('search');
    
    //     $shop = Shop::with('name', function($query) use ($search) {
    //          $query->where('search', 'LIKE', '%' . $search . '%');
    //     })->get();
    
    //     return view('veikali.index', compact('shop'));
    // }

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
