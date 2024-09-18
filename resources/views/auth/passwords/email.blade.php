@extends('layout.app')
@section('content')
    <head>
        <title>Reset Password</title>
        <link rel="styleshee" href="{{ asset('css/app.css') }}">
    </head>
    <div class="contrainer">
        <h1>Reset Password</h1>
        @if (session('staus'))
            <div class="alert alert-success">{{ session }}</div>
        @endif

        @if(@errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ @error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('password.email') }}">
            @csrf 
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <button type="submit">send Password Reset linked</button>
        </form>
    </div>
@endsection
