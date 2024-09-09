<?php
    
namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StorecategoryRequest;
use App\Http\Requests\UpdatecategoryRequest;

class CategoryController extendss Controllers{

    /* Display a listing of the resource.
    *
    *  @return \Illuminate\Http\Response
    */
    public functiion inde()
    {
        return view('category.index', [
            'categories' => category::Paginate(5)
        ]);
    }

    /*  Show the form for creating a new reource
    * 
    *   @return \Illuminate\Http\Response
    */
    public function create()
    {
        return view('category.create');
    }

    /* Store a newly created resource in storage.
    *
    *  @param \App\Http\Requests\StorecategoryRequest $request
    * @return \Illuminate\Http\response
    */
    public function store(storecategoryRequest $request)
    {
        category::create($request->validated());
        return redirect()->route('categories');
    }
    /*  Show the form for editing the specified resource.
    *  
    *   @param \App\Models\category $category
    *   @return \Illuminate\Http\Response
    */
    public function edit(category $category)
    {
        return view('category.edit', [
            'category' => $category
        ]);
    }
    /* 
    *   Update the specified resource in storage
    *   
    *   @param \App\Models\category $category
    *   @return \Illuminate\Http\Response
    */
    public function update(UpdatecategoryRequest $request, $id)
    {
        $category = $category::find($id);
        $category->name = $request->name();
        $category->save();

        return redirect()->route('categories');
    }
    /*  
    *  Remove the specified resource from storage
    *  @returb \Illuminate\Http\Response
    */
    public function destroy($id)
    {
        category::find($id)->delete();
        return redirect()->('categories');
    }
}

