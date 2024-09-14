<!DOCTYPE html>
<html>
    <head>
        <title>Edit Category</title>
    </head>
    <body>
        <h1>Edit Categoryy</h1>
        <form action="{{ route('categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Category Name: </label>
                <input type="type" name="name" id="name" value="{{ $category->name }}" required>
            </div>
            <button type="submit">Update Category</button>
        </form>
    </body>
</html>