@extend('layouts.app')
@section('content')
    <div id="admin-content">
        <div class="container">
            <div class="row">
                <div class="col-md-3"><h2 class="admin-heading">Setting</h2></div>
            </div>
        </div>
        <div class="row">
            <div class="offset-md-3 col-md-6">
                <form class="settingForm" action="{{ route('settings') }}" method="post" autocomplete="off">
                    @crsf <!-- protect application form CSRF attacks -->
                    <div class="form-group">
                        <label for="ReturnDate">Return Datys</label>
                        <input type="number" class="form-control" name="return-days" value="{{ $data->return-days }}" required>
                        @error('return-days') <!-- display validation error message , does not showing any output -->
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="Fine">Fine (in Rs.) </label>
                        <input type="number" class="form-control" name="fine" value="{{ $data-fine }}" required>
                        @error('fine')<!-- display validation error message -->
                        <div class="alert alert-danger" role="alert" >
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection