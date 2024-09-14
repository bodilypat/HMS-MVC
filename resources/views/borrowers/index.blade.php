<!DOCTYPE html>
<html>
    <head>
        <title>Borrowers</title>
    </head>
    <body>
        <h1>Borrowers</h1>
        <a href="{{ route('borrowers.create') }}">Add New Borrow</a>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($borrowers as $borrower)
                <tr>
                    <td>{{ $borrower->name }}</td>
                    <td>{{ $borrower->email }}</td>
                    <td>{{ $borrower->phone }}</td>
                    <td>
                        <a href="{{ route('borrowers.edit', $borrower->id )}}">Edit</a>
                        <form action="{{ route('borrowers.destroy', $borrower->id) }}" method="POST" style="display:inline;">
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
