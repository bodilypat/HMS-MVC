@extends('layout')
@section('content')
    <div id="admin-content">
        <div class="container">
            <div class="row">
                <div class="col-md-3"><h2 class="admin-heading">Add Category<h2></div>
                <div class="offset-md-7 col-md-2">
                    <a class="add-new" href="{{ route('categories' ) }}">All Categories</a>
                </div>
            </div>
            <div class="row">
                <div class="offset-md-3 col-md-6">
                    <from class="libraryForm" action="{{ route('category.store') }}" method="post" autocomplete="off">
                        @csrf
                        <div class="form-group">
                            <label for="CategoryName">Category Name</label>
                            <input type="text" class="form-control @error('name') isinvalid @enderror" name="categoryname" 
                                   placehoder="Category Name" value="{{ old('categoryname') }}" required>
                            @error('categoryname')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <input type="submit" name="save" class="btn btn-danger" value="save" required>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
