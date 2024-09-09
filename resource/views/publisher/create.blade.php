@extends('layouts.app')
@section('content')
    <div id="admin-content">
        <div class="container">
            <div class="row">
                <div class="col-md-3"><h2 class="admin-heading">Add Publisher</h2></div>
                <div class="offse-md-7 col-md-2">
                    <a class="add-new" herf="{{ route('publishers') }}">All Publisher</a>
                </div>
            </div>
            <div class="row">
                <div class="offset-md-3 col-md-6">
                    <form class="libraryForm" action="{{ route('publisher.store') }}" method="post" autocomplete="off">
                        @csrf
                        <div class="form-group">
                            <label for="PublisherName">Publisher Name</label>
                            <input type="texy" class="form-control @error('publishername') isinvalid @enderror" name="publishername"
                                  placeholder="Publisher Name" value="{{ old('publishername') }} " required>
                            @error('publishername')
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