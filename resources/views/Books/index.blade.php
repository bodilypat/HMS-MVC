<!DOCTYPPE html>
<html>
    <head>
        <title>Books List</title>
    </head>
<body>
    <h1>Books List</h1>
    <a href="{{ route('books.create') }}">Add New Book</a>

    @if(session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <table>
        <thead>
            <tr>
                 <th>Title</th>
                 <th>Author</th>
                 <th>Year</th>
                 <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($books as $book)
            <tr>
                 <td>{{ $book->title }}</td>
                 <td>{{ $book->author }}</td>
                 <td>{{ $book->year }}</td>
                 <td>
                     <a href="{{ route('books.show', $book->id )}}">View</a>
                     <a href="{{ route('books.edit', $book->id )}}">Edit</a>
                     <form action="{{ route('books.destroy', $book->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Delete</button>
                     </form>
                 </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
