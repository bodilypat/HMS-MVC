@extends('layouts.app')
@section('content')
    <head>
        <title>Reset Password</title>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    </head>
    <div class="container">
        <h1>Reset Password</h1>
        @if (@errors->any())
            <div class="alert alert-danger">
                <ul>
                     @foreach ($errors->all() as error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('password.update') }}">
            @csrf 
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required> 
            </div>
            <button type="submit">Reset Password</button>
        </form>
    </div>
@endsection