<!DOCTYPE html>
<html>
    <head>
        <title>Edit Borrow Record</title>
    </head>
    <body>
        <form action="{{ route('borrows.update', $borrow->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="book_id">Book : </label>
                <select name="book_id" id="book_id">
                    @foreach ($books as $book)
                        <option value="{{ $book->id }}" {{ $book->id == $borrow->book_id ? 'selected' : ''}}>
                            {{ $book->title }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="borrower_id">Borrower : </label>
                <select name="borrower-id" id="borrower_id" >
                    @foreach ($borrowers as $borrow) 
                        <option value="{{ $borrower->id }} " {{ borrower->id == $borrow->borrow_id ? 'selected':''}}>
                            {{ $borrower->name }}
                        </option>
                    @endforeach
                </section>
            </div>
            <div class="form-group">
                <label for="borrowed_at">Borrowed At: </label>
                <input type="date" name="borrowed_at" id="borrowed_at" value="{{ $borrowed_at }}" required>
            </div>
            <div class="form-group">
                <label for="returned_at">Return At: </label>
                <input type="date" name="returned_at" id="returned_at" value="{{ $returned_at }}" >
            </div>
            <button type="submit">Update Borrow Record</button>
        </form>
    </body>
</html>