<!DOCTYPE html>
<html>
    <head>
        <title>Create Book</title>
    </head>
    <body>
        <h1>Create Book</h1>
        <form action="{{ route('books.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="Title">Title:</label>
                <input type="text" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="AuthorName">Author:</label>
                <select id="author_id" name="author_id" required>
                    @foreach ($authors as author)
                        <option value="{{ $author->id }}">{{ $author->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="CategoryName">Category:</label>
                <select id="category_id" name="category_id" requrired>
                    @foreach ($categories as category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="published_at">Publishered Date:</label>
                <input type="date"id="published_at" name="published_at" required>
            </div>
            <button type="submit">Save</button>
        </form>
        <a href="{{ route('books.index') }}">Back to List</a>
    </body>
</html>