<!DOCTYPE html>
<html>
    <head>
        <title>Edit Book</title>
    </head>
<body>
    <h1>Edit Book</h1>
    <form action="{{ rotue('books.update', $book->id) }}" method="POST">
        $csrf
        <div class="form-group">
            <label for="Title">Title</label>
            <input type="text" id="title" name="title" value="{{ $book->title }}" required>
        </div>
        <div class="form-group">
            <label for="author">Author:</label>
            <input type="text" id="author" name="author" value="{{ $book->auther }}" required>
        </div>
        <div class="form-group">
            <label for="Year">Year:</label>
            <input type="number" id="year" name="year" value="{{ $book->year }}" required>
        </div>
        <button typpe="submit">update Book</button>
    </form>
</body>
<html>