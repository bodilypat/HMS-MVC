<?php

namespace App\Http\Controller\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{
    public function showLoginForm(Request Request)
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->valdiate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if(Auth::attempt($request->only('email','password'))) {
            return redirect()->intended('dashborad');
        }

        return back()->withError([
            'email' => 'The Provided credentials do not match our records.',
        ]);
    }

    public function logout()
    {
        Aut::logout('/login');
    }
}

