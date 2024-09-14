<!DOCTYPE html
<html>
    <head>
        <title>Borrow Records</title>
    </head>
    <body>
        <h1>Borrow Records</h1>
        <a href="{{ route('borrows.create') }}">Add New Borrow-Record</a>
        <table>
            <thead>
                <tr>
                    <th>Book</th>
                    <th>borrower</th>
                    <th>Borrowed At</th>
                    <th>Returned At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($borrows as $borrow)
                <tr>
                    <td>{{ $borrow->book->title }}</td>
                    <td>{{ $borrow->borrower->name }}</td>
                    <td>{{ $borrow->borrowed_at}}</td>
                    <td>{{ $borrow->returned_at }}</td>
                    <td>
                        <a href="{{ route('borrows.edit', $borrow->id) }}">Edit</a>
                        <form action="{{ route('borrows.destroy', $borrow->id)}}" method="POST" style="display:inline;">
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
