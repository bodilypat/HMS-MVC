<!DOCTYPE html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>{{ config('app.name', 'Lbrary Management System') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-compatible" conten=ie=edge">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div id="header">
        <!-- header -->
        <div class="container">
            <div class="row">
                <div class="offset-md-4 col-md-4" >
                    <div class="logo">
                        <a href="#"><img src="{{ asset('images/library.png') }}"></a>
                    </div>                
                </div>
                <div class="offset-md-2 col-md-2">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Hi {{ auth()->user()->name }}
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="{{ route('change_password') }}">Change Password</a>
                            <a class="dropdown" href="#" onClick="document.getElementById('logoutForm').submit()">Log Out</a>
                        </div>
                        <form method="post" id="logoutForm" action="{{ route('logout') }}">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END HEADER -->
    <diiv id="menubar">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul class="menu">
                        <li><a href="{{ route('dashbord') }}">Dashboard</a></li>
                        <li><a href="{{ route('author') }}">Author</a></li>
                        <li><a href="{{ route('publisher') }}">Publisher</a></li>
                        <li><a href="{{ route('categories') }} ">Categories</a></li>
                        <li><a href="{{ route('students') }}">Student</a></li>
                        <li><a href="{{ route('book_issue') }}">Book Issue</li>
                        <li><a href="{{ route('reports') }}">Report</a></li>
                        <li><a href="{{ route('setting') }}">Setting</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @yield('content')
    <!-- FOOTER -->
     <div id="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <span>Library Management System</span>
                </div>
            </div>
        </div>
     </div>
    <!-- javascript -->
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('js/poper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>