<?php

namespace App\Http\Controllers;

use App\Models\auther;
use App\Http\Requests\StoreautherRequest;
use App\Http\Requests\UpdateautheRequest;

class AutherController extends Controller 
{
    /* Display a listing of the resource */
    public function index()
    {
        return view('auther.index', [ 
            'authors' => auther::Paginate(5);
        ]);
    }

    /* Show the form for creating a new resource. */
    public function create()
    {
        return view('authors.create');
    }

    /* Store a newly created resource in storage. */
    public function store(StoreautherRequest $request)
    {
        auther::create($request->validated());
        return  redirect()->route('authors')
    }

    /* Show the form for editing the specified resource. */
    public function edit(auther $auther)
    {
        return view('auther.edit',[
            'auther' => $auther
        ]);
    }

    /* Update the specified resource in storage. */
    public function update(UpdateautherRequest $request, $id)
    {
        $auther = auther::find($id);
        $auther->name = $request->name;
        $auther->save();
        
        return redirect()->route('authers');
    }

    /* Remove the specified resource from storage */
    public function destroy($id)
    {
        auther::findorfail($id)->delete();
        return redirect()->route('authers');
    }
}