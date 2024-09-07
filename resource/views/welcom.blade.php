@extends('layouts.app')    
@section()
    <div class="wrap-admin">
        <div class="container">
            <div class="row">
                <div class="offset-md-4 col-md-4">
                    <div class="logo border bordor-danger"><img src="{{ asset('images/library.png') }}" alt=""></div>
                    <form class="imageForm" action="{{ route('login') }}" method="post">
                        @csrf
                        <h3 class="heading">Admin Login</h3>
                        <div class="form-group">
                            <label for="Username">Username</label>
                            <input type="text" class="form-control" value="{{ old('username') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="Password">Password</label>
                            <input type="password" name="password" class="form-control" value="" required>
                        </div>
                    </form>
                    @error('username') <!-- display validation error message -->
                        <div class="alert alert-danger">{{ $message }}</div>
                    $enderror
                </div>
            </div>
        </div>
    </div>
@section