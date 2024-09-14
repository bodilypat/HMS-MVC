<!DOCTYPE html>
<html>
    <head>
        <title>Add new Borrower</title>
    </head>
    <body>
        <h1>Add New Borrow</h1>
        <form action="{{ route('borrowers.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Name :</label>
                <input type="text" name="name" id="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email : </label>
                <input type="email" name="email" id="email" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone: </label>
                <input type="text" name="phone" id="phone">
            </div>
            <button type="submit">Add Borrower</button>
        </form>
    </body>
</html>