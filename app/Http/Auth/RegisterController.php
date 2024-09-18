<?php

namespace App\Http\Controller\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\user;
use Illuminate\Support\facades\Hash;
use Illuminage\Support\facades\Validator;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        $this->validate($request->all())->validate();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
    
        /* optionally, log the user in after registration */
        /* Auth::login($user); */
        return redirect()->route('login')->with('success','Registration successfully! you can now login.');
    }

    protected function validator(array $data)
    {
        return Validator::make($data,[
            'name' => ['required','string','max:255'],
            'email' => ['required','string','email','max:255','unique:users'],
            'password' => ['required','string','min:8','confirmed'],
        ]);
    }
}
