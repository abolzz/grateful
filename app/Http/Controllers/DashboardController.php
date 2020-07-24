<?php

namespace Grateful\Http\Controllers;

use Illuminate\Http\Request;
use Grateful\User;
use Grateful\Purchase;

class DashboardController extends Controller
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
    public function index()
    {
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        abort_if($user->is_admin !== 1, 404);
        return view('dashboard')->with(['shops'=>$user->shops,'listings'=>$user->listings, 'purchases'=>$user->purchases]);
    }
}
