<?php

namespace Grateful\Http\Controllers;

use Illuminate\Http\Request;
use Grateful\User;
use Grateful\Like;
use Grateful\Shop;

class LikesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($id)
    {
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        $liked_shop = Shop::find($id);
        $like = new Like;
        $like->liked_shop = $liked_shop->id;
        $like->liked_from = $user->id;
        $like->save();

        $liked_shop->likes = $liked_shop->likes + 1;
        $liked_shop->save();
        return redirect()->back();
    }

    public function unlike($id, $liker_id)
    {
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        $liked_shop = Shop::find($id);
        $liker = Like::where('liked_from', $liker_id);
        $liker->delete();

        $liked_shop->likes = $liked_shop->likes - 1;
        $liked_shop->save();
        return redirect()->back();
    }
}
