<?php

namespace  App\Http\Controllers;

use  App\Models\Publisher;
use  App\Models\StorepublisherRequest;
use  App\Models\UpdatepublisherRequest;

class PublisherController extends Controller
{
    /*  Display a listing of the resource
    *   @return  \Illuminate\Http\Response
    */
    public function index()
    {
        return view('publisher.index', [
            'publisher' => publisher::Paginate(5)
        ]);
    }
    /* Show the form for creating a new resource
    *  
    *  @return  \Illuminate\Http\Response
    */
    public function create()
    {
        return view('publisher.create');
    }
    public function store(StorepublisherRequest $request)
    {
        publisher::create($request->validate());
        return redirect()->route('publisher');
    }
    public function update(UpdatepublisherRequest $request, $id)
    {
        $publisher = publisher::find($id);
        $publisher->name = $request->name;
        $publisher->save();

        return redirect()->route('publisher');
    }
    public function destroy($id)
    {
        publisher::find($id)->delete();
        return redirect()->route('publisher');
    }
}