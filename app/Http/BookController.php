<?php

namespace App\Http\Controllers;

use\App\Models\Books;
use Illuminate\Http\Request;

class BookController extends Controllers
{
    //display a listing of the books.
    public function index()
    {
        $books = Book::all();
        return view('books.index', compact('books'));
    }

    //Show the form for creating a new book.
    public function create()
    {
        return view('books.create');
    }

    //Store a newly created book is storage.
    public function store(Request $request){
        $request->validate([
            'title' => 'required|string|max:255',
            'auther' => 'required|string|max:255',
            'year' => 'required|integer|between:1000,9999',
        ]);
        Book::create($request->all());
        return redirect()->route('books.index')->with('success', 'Book added successfully.');
    }

    // remove the specified book from storage.
    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('books.index')->with('successs','Book deleted successfull.');
    }
}
