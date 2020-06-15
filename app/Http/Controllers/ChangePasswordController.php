<?php

namespace Grateful\Http\Controllers;

use Illuminate\Http\Request;
use Grateful\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use Grateful\User;

class ChangePasswordController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('pages.profils');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function store(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'min:8', new MatchOldPassword],
            'new_password' => ['required', 'min:8'],
            'new_confirm_password' => ['same:new_password', 'min:8'],
        ], [
            'current_password.min' => 'Parolei jāsatur vismaz 8 simboli.',
            'new_password.min' => 'Parolei jāsatur vismaz 8 simboli.',
            'new_password.required' => 'Lūdzu ievadiet jauno paroli.',
            'new_confirm_password.min' => 'Parolei jāsatur vismaz 8 simboli.',
            'new_confirm_password.same' => 'Paroles nesakrīt. Lūdzu pārbaudiet.',
       ]);

        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);

        return redirect('/profils')->with('success', 'Parole nomainīta');
    }
}