<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller 
{
    /* display a list of Book */
    public function index() 
    {
        $books = Book::with('author', 'category')->get();
        return view('books.index', compact());
    }

    /* Show the form for creating a new look */
    public function create()
    {
        $authors = Author::all();
        $categories = Category::all();
        return view('books.create', compact('authors','categories'));
    }

    /* Store a newly created book in storage */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'category_id' => 'required:exists:categories,id',
            'published_at' => 'required|data',
        ]);

        Book::Create($request->all());
        return redirect()->route('books.index')->with('success','Book created successfully.')
    }

    /* Display the specified book */
    public function show($id) 
    {
        $books = Book::with(('auther', 'category'))->findOrFail($id);
        return view('books.show', compact('books'));
    }

    /* Display the form editing the specified book */
    public function edit($id)
    {
        $books = Book::findOrFail();
        $authors = Author::all();
        $categories = Category::all();
    }

    /* Update the specified book in storage */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:autor,id',
            'category_id' => 'required|exists:categories,id',
            'publisher_at' => 'required|date',
        ]);

        $books = Book:: findOrFail($id);
        $books->update($request->all());
        return redirect()->route('books.index')->with('success','Book updated successfully.');
    }

    /* Remove the specified book form storage */
    public function destroy($id)
    {
        $books = Book::findOrFail($id);
        $books->delete();
        return redirect()->route('books.index')->with('success','Book deleted sucessfully.');
    }
}