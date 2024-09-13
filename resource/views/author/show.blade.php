<!DOCTYPE html>
<html>
    <head>Author Details</head>
    <body>
        <h1>Author Details</h1>
        <p><strong>ID: </strong> {{ $author->id }}</p>
        <a href="{{ route('authors.edit', $author->id ) }}">Edit</a>
        <a href="{{ route('authors.index') }}">Back to List</a>
    </body>
</html>