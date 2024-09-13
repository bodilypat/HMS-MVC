@extends('layouts.app')
@section('content')
    <div class="admin-content">
        <div class="container">
            <div class="row">
                <div class="col-md-3"><h2 class="admin-heading">Add author</h2></div>
                <div class="offset-md-7 col-md-2"><a class="add-new" href="{{ route('authors') }}">All Authors</a></div>
            </div>
            <div class="row">
                <div class="offset-md-7 col-md-2">
                    <form class="yourForm" action="{{ route('authors.') }}" method="post" autocomplete="off">
                        @csrf <!--  protect  application form CSRF attacks -->
                        <div class="form-group">
                            <label for="AuthorName">Author Name</label>
                            <input type="text" class="form-control @error('name') isinvalid @enderror" placeholder="Author Name" 
                                   name="autherName" value="{{ old('name') }}" required>
                            @error('authorName') <!-- display message error -->
                            <div class="alert alert-danger" role="alert">
                                {{ $message }}                            
                            </div>
                            @enderror
                        </div>
                        <input type="submit" name="save" class="btn btn-danger" value="save" require>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection