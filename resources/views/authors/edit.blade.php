<!DOCTYPE html>
<html>
    <head>
        <title>Edit Author</title>
    </head>
    <body>
        <h1>Edit Author</h1>
        <form action="{{ route('authors.update', $author->id) }}" method="POST">
            @csrf 
            @method('PUT')
            <label for="AuthorName">Name: </label>
            <input type="text" id="name" name="name" value="{{ $author->name }}" required>
            <button type="submit">Update</button>
        </form>
        <a href="{{ route('authors.index') }}">Back to List</a>
    </body>
</html>