<!DOCTYPE html>
<html>
    <head>
        <title>Edit Borrower</title>
    </head>
    <body>
        <h1>Edit Borrower</h1>
        <form action="{{ route('borrowers.update', $borrower->id) }}" metthod="POST">
            @csrf
            <div class="form-group">
                <label for="Name">Name :</label>
                <input type="text" name="name" id="name" value="{{ $borrower->name }}" required>
            </div>
            <div class="form-group">
                <label for="Email">Email :</label>
                <input type="email" name="email" id="name" value=" {{ $borrower->email }} " required>
            </div>
            <div class="form-group">
                <label for="Phone">Phone : </label>
                <input type="text" name="phone" id="name" value="{{ $borrow->phone }}">
            </div>
            <button type="submit">Update Borrower</button>
        </form>
    </body>
</html>