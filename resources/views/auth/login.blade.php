@extends('layout.app')

@section('content')
    <div class="content">
        <title>Login</title>
        <link rel="stylesheet" href="{{ asset('css/app.css')}}">
    </div>
    <div class="container">
        <h1>Login</h1>
        @if($error->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as @error)
                        <li>{{ @error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('login') }}">
            @csrf 
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password: </label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
    </div>
@endsection
