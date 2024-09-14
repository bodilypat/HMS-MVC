<!DOCTYPE html>
<html>
    <head>
        <title>View Book</title>
    </head>
<body>
    <h1>Book Details</h1>
    <p>Title : {{ $book->title }}</p>
    <p>Author : {{ $book->author->name }}</p>
    <p>Publishered Year : {{ $book->publishered_year }}</p>
    <p>copies : {{ $book->copies }}</p>

    <a href="{{ route('books.edit', $book->id) }}">Edit</a>
    <a href="{{ route('books.index') }}">Back to list</a>

</body>
</html>