<!DOCTYPE thml>
<html>
    <head>
        <title>Authors List</title>
    </head>
    <body>
        <h1>Authors</h1>
        <a href="{{ route('authors.create') }}">Add New Author</a>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($authors as $author)
                    <tr>
                        <td>{{ $auther->id }}</td>
                        <td>{{ $author->name }}</td>
                        <td>
                            <a href="{{ route('authors.show', $author->id) }}">view</a>
                            <a href="{{ route('authors.edit', $author->id) }}">Edit</a>
                            <form action="{{ route('authers.destroy', $author->id) }}" method="POST" style="display:inline;">
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
