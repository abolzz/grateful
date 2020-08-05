<?php

namespace Grateful\Http\Controllers;

use Illuminate\Http\Request;
use Grateful\User;
Use Grateful\Mail\PurchaseMail;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show']]);
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
        if ($user->hasVerifiedEmail() != 1) {
           return redirect('/veikali')->with('error', 'Lai veiktu pirkumus, apstipriniet savu e-pasta adresi.');
        }
        return view('payment');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show()
    {
        return redirect('/veikali');
    }
}
