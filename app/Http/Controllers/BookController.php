<?php

namespance App\Http\Controllers;

use App\Model\book;
use App\Http\Requests\StorebookRequest;
use App\Http\Requests\UpdatebookRequest;
use App\Models\auther;
use App\Models\category;
use App\Models\publisher;

class BookController extends Controllers
{
    /* Display a listing of the resource
       @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('book.index', [
            'books' => book::Paginate(5)
        ]);
    }
    /* Show the form creating a new resource 
        @return \Illuminate\Http\Response
    */
    public function create()
    {
        return view('book.create', [
            'authors' => auther::latest()->get(),
            'publishers' => publisher::latest()->get(),
            'categories' => category::latest()->get(),
        ]);
    }
    /* Store a newly created resource in storage
       @param \App\Http\Requests\StorebookRequest $request
       @return \Illuminate\Http\Response
     */
    public function store(StorebookRequest $request)
    {
        book::create($request->validated() + [
            'status' => 'Y'
        ]);
        return redirect()->route('books');
    }
    /* Show the form for editing the specified resource
       @param \App\Models\book $book
       @return \Illuminate\Http\Reponse 
     */
    public function update(UpdatebookRequest $request, $id)
    {
        $book = book::find($id);
        $book->name = $request->name;
        $book->auther_id = $request->auther_id;
        $book->category_id = $request->category_id;
        $book->publisher_id = $request->publisher_id;
        $book->save();

        return redirect()->route('books');
    }
    /* Remove the specified resource form storage.
       @param \App\Models\book $book
       @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        book::find($id)->delete();
        return redirect()->route('books');
    }
}