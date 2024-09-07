@extends('layout.app')
@section('content')
    <div id="admin-content">
        <div class="contaienr">
            <div class="row">
                <div class="offset-md-7 col-md-2"><h2 class="admin-heading">Update Category</h2></div>                
            </div>
            <div class="row">
                <div class="offset-md-3 col-md-6">
                    <form class="libraryForm" action="{{ route('category.upate', $category->id ) }}" method="post" autocomplete="off">
                        <div class="form-group">
                            <label for="CategoryName">Category Name</label>
                            <input type="text" class="form-control @error('categoryname')" name="categoryname" 
                                  value="{{ $category->name }}" required> 
                            @error('categoryname')
                                <div class="btn btn-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <input type="submit" name="submit" class="btn btn-danger" value="Update" required>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection