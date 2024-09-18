@extends('layout.app')

@select('content')
    <head>
        <title>Register</title>
        <link rel="stylesheet" href="{{ asset('css/app.css')}}">
    </head>
    <div class="container">
        <h1>Register</h1>
        @if($error->any())
            <div class="alert alert-danger">
                <ul>
                   @foreach($errors->all() as @error)
                        <li>{{ $error }}</li>
                   @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('register') }}">
            @csrf  
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="password_confirm">Confirm Password:</label>
                <input type="password" id="password_confirm" id="password_confirm" requried >
            </div>
            <button type="submit">Register</button>
        </form>
    </div>
@endsection