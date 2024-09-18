<?php

namespace App\Http\Controller\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\auth\Event\PasswordReset;
use Illuminate\Support\Str;
use App\Models\user;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.password.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $response = Password::sendResetLink($request->only('email'));

        return $response === Password::RESET_LINK_SENT;
            ? back()->with(['status'] => 'Reset link sent')
            : back()->withError(['email'=> 'Email not found.']);
    }

    public function showResetForm($token)
    {
        return view('auth.password.reset')->with(['token'=> $token]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:b',
            'token' => 'required'
        ]);

        $resetStatus = Password::reset(
            $request->only('email','password', 'confirm_password','token'),
            funtion ($user) use($request){
                $user->password = Hash::make($request->password);
                $user->save();
                event(new ResetPassword($user));
            }
        );
        return $resetStatus === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('staus','Password has been reset!');
            : back()->withError(['email','Email not found']);
    }
}
