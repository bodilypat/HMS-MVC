<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller 
{
    /* Display a listing of the authors */
    public function index()
    {
        $authors = Author::all();
        return view('auther.index', compact('authors'));
    }

    /* Show the form for creating a new author. */
    public function create()
    {
        return view('authors.create');
    }

    /* Store a newly created author in storage. */
    public function store(Request $request)
    {
        $request ->validate([
            'mame' => 'request|string|max:255',
        ]);

        Author::create($request->all());
        return redirect()->route('authors.index')->with('success','Author created successfully. ');
    }

    /* Show the form for editing the specified author. */
    public function show(id)
    {
        $auther = Auther::findOrFail($id);
        return view('authors.show', compact('author'));
    }

    /* Show the form for editing the specified author */
    public function edit($id)
    {
        $author = Author::findOrFail($id);
        return view('authors.edit', compact('author'));
    }

    /* Update the specified author in storage. */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $author = Author::findOrFail($id);
        $author->update($request->all());
        return redirect()->route('authors.index')->with('success','Auther updated successfully.');
    }

    /* Remove the specified author from storage */
    public function destroy($id)
    {
        $author = Author::findOrFail($id);
        $author->delete();
        return redirect()->route('authors.index')->with('success','Author deleted successfully.');
    }
}