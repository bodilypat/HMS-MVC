<!DOCTYPE html>
<html>
    <head>
        <title>Add New Category</title>
    </head>
    <body>
        <h1>Add New Category</h1>
        <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            <div class="for-group">
                <label for="name">Category Name:</label>
                <input type="text" name="name" id="name" required>
            </div>
            <button type="submit">Add Category</button>
        </form>
    </body>
</html>