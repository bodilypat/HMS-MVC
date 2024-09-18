<?php

namespace App\Http\Controllers;

use App\Models\Borrow;
use App\Models\Book;
use App\Models\Borrows;
use Illuminate\Http\Request;

class BorrowController extends Controllers
{
    
    /* Display a listing of borrow */
    public function index()
    {
        $borrows = Borrow::with([
            'book',
            'borrower',
        ])->get();
        return view('borrows.index', compact('borrows'));
    }

    /* Show form crating new borrows */
    public function create()
    {
        $books = Book::all();
        $borrowers = Borrower::all();
        return view('borrows.create', compact('books','borrows'));
    }

    /* Store a new created author in storage */
    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'borrower_id' => 'required:exists:borrowers,id',
            'borrower_at' => 'required|date',
        ]);

        Borrow::create(request->all());
        return redirect()->route('borrows.index');
    }

    /* Show the form fro editing the specified author */
    public function edit(Borrow $borrow)
    {
        $books = Book::all();
        $borrowers = Borrower::all();
        return view('borrows.edit', compact('borrows','books','borrowers'));
    }

    /* Update the specified borrow in storage */
    public function update(Request $request, $id)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'borrower_id' => 'required|exists:borrowers,id',
            'borrower_at' => 'required|date',
            'returned_at' => 'unllable|date',
        ]);

        $borrows ->update($request->all());
        return redirect()->route('borrow.index');
    }

    /* Remove the specified borrow from storage */
    public function destroy($id)
    {
        $borrows = Borrow::findOrFail($id);
        $borrows->delete();
        return redirect()->route('author.index')->with('success','Borrow delete successfully.');
    }
}