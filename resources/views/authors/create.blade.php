<!DOCTYPE html>
<html>
    <head>
        <title>Create Author</title>
    </head>
    <body>
        <h1>Create Author</h1>
        <form action="{{ route('auther.store') }}" method="POST">
            @csrf
            <label for="AuthorName">Name:</label>
            <input type="text" id="name" name="name" required>
            <button type="submit">Save</button>
        </form>
        <a href="{{ route('authors.index') }}">Back  to List</a>
    </body>
</html>