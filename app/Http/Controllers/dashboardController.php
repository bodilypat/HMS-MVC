<?php

namespace  App\Http\Controllers;

use  App\Http\Requests\ChangePasswordRequest;
use  App\Models\auther;
use  App\Models\book;
use  App\Models\Book_issue;
use  App\Models\category;
use  App\Models\publisher;
use  App\Models\student;
use  App\Http\Request;
use  Illuminate\Http\Request;
use  Illuminate\Support\Facades\Auth;

class dashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'authors' => auther::count(),
            'publisher' => publisher::count(),
            'categories' => category::count(),
            'books' => book::count(),
            'students' => student::count(),
            'issued_books' => book_issue::count(),
        ]);
    }

    public function change_password_view()
    {
        return view('reset_password');
    }

    public function change_password(changePasswordRequest $request)
    {
        if(Auth::check(["username" => auth()->user()->username, "password" => $request->cPassword])) {
            auth()->user()->password = bcrypt($request->password);
            return redirect()->back()->with(['message'] => "Password Changed Successfully! .");
        } else {
            return "";
        }
    }
}