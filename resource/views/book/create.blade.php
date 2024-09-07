@extends('layouts.app)
@section('content)
    <div id="admin-content">
        <div class="container">
            <div class="row">
                <div class="col-md-3"><h2 class="admin-heading">Add Book</h2></div>
                <div class="offset-md-7 col-md-2"><a class="add-new" href="{{ route('books') }}">All Books</a></div>
            </div>
            <div class="row">
                <div class="offset-md-3 col-md-6">
                    <form class="yourForm" action="{{ route('book.store') }}" method="post" autocomplete="off">
                        @csrf <!-- protect application form CSRF attacks -->
                        <div class="form-group">
                            <label for="BookName">Book Name</label>
                            <input type="text" class="form-control @error('bookName') isivalid @enderror" placeholder="Book Name" name="bookname"
                                   value="{{ old('bookname') }}" required>
                            @error('bookName') <!-- display validation error message -->
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="Category">Category</label>
                            <select class="form-control @error('category_id') isinvalid @enderror" name="category_id" required>
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category_id }}">{{ $category->name }}</option>
                                @endforeach
                            </section>
                            @error('category_id')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="Author">Author</label>
                            <select class="form-control @error('auther_id') isinvalid @enderror " name="auther_id" required>
                                <option value="">Select Author</option>
                                @foreach ($authors as $author)
                                    <option value='{{ $author->id }}'>{{ author->name }}</option>;
                                @endforeach
                            </section>
                            @error('author_id')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="Publisher">Publisher</label>
                            <select class="form-control @error('publisher_id') @enderror" name="publisher_id" required>
                                <option value="">Select Publisher</option>
                                @foreach ($publishers as $publisher)
                                    <option value='{{ $publisher->id }}'>{{ $publisher->name }}</option>;
                                @endforeach
                            </select>
                            @error('publisher_id')
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