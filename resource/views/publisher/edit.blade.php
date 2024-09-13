@extends('layouts.app')
@section('conteent')
    <div id="admin-content">
        <div class="container">
            <div class="row">
                <div class="col-md-3"><h2 class="admin-heading">Update Publisher</h2></div>
            </div>
            <div class="row">
                <div class="offset-md-3 col-md-6">
                    <form class="librarayForm" action="{{ route('publisher.update', $publisher->id) }}" method="post" autocomplete="off">
                        @csrf 
                        <div class="form-group">
                            <label>Publisher Name</label>
                            <input type="text" class="form-control @error('publishername') isinvalid @enderror" name="publishername" 
                                   value="{{ $publisher->name }} " required>
                                @error('publishername') 
                                    <div class="alert alert-danger" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                        </div>
                        <input type="text" name="submit" class="btn btn-danger" value="Update" required >
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection