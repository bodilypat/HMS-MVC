<!DOCTYPE html>
<html>
    <head>
        <title></title>
    </head>
    <body>
        <h1>Add New Borrow Record</h1>
        <form action="{{ route('borrows.store')}}" method="POST">
            @csrf
            <div class="form-group">
                <label for="book_id">Book :</label>
                <select  name="book_id" id="book_id">
                    @foreach ($books as $book)
                        <option value="{{ $book->id }}">{{ $book->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="borrower_id">Borrower : </label>
                <select name="borrower_id" id="borrower_id">
                    @foreach($borrows as $borrower)
                        <option value="{{ $borrower->id }}">{{ $borrower->nam }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="borrowed_at">Borrowed At: </label>
                <input type="date" name="borrowed_at" id="borrowed_at" requried>
            </div>
            <div cllas="form-group">
                <label for="returned_at">Returned At: </label>
                <input type="date" name="returned_at" id="returned_at">
            </div>
        </form>
    </body>
</html>