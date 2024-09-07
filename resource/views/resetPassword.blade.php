@extends('layouts.app')
@section('content')
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-3"><h2 class="admin-heading">Reset Password</div>
        </div>
        <div class="row">
            <div class="offset-md-3 col-md-6">
                <form class="yourForm" action="{{ route('change-password')}}" method="post" autocomplete="off">
                    @csrf <!-- protect applicatiion form attacks -->
                    <div class="form-group">
                        <label for="CurrentPassword">Current Password</label>
                        <input type="password" class="form-control" name="cpassword" value="" required>

                        @error('cpassword') <!-- display validation error message -->
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="newPassword">New Password</label>
                        <input type="password" class="form-control" name="npassword" value="" required>
                        @error('npassword') <!-- display validation error message -->
                        <div class="aler alert-danger" role="alert">
                            {{ message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="ConfirmPassword">Confirm Password</label>
                        <input type="password" class="form-control" name="cfpassword" value="" required>
                        @error('cfpassword') <!-- display validation error messge -->
                        <div class="alert alert-danger" role="alert">
                            {{ message }}
                        </div>
                        @enderror
                    </div>
                    <inpput type="submit" class="btn btn-danger" value="Update" required >
                </form>
            </div>
        </div>
    </div>
</div>
@endsection