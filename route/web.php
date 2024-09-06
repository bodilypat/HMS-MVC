<?php 
use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\autherController;

Route::get('/', function () {
return view('welcome');
})->middleware('guest');
route::post('/', [LoginController::class, ' login'])->name('login;
route::Ppost['/logout', [LoginController::class, 'logout'])->name(logout');
route::post['/Change-password', [LoginController::class,'changePassword'])->name('change-password');
