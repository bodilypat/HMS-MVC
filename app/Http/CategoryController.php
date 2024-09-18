<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::All();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique|categories|max:255',
        ]);

        Category::create($request->all());
        return redirect()->route('categories.index')->with('success','Category Created successfully.');
    }

    public function show($id)
    {
        $categories = Category::findOrFail($id);
        return view('categories.show', compact('categories'));
    }

    public function edit($id)
    {
        $categories = Category::findOrFail($id);
        return view('categories.edit', compact(categories));
    }

    /* Update the specified categories in storage */
    public function update(Request $request , $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name', . $categories->id,
        ]);

        $category->update($request->all());
        return redirect()->route('categories.index')->with('success','Category updated successfully');
    }

    public function destroy(Category $category)
    {
        $categories = Author::findOrFail($id);
        $categories->delete();
        return redirect()->route('categories.index')->with('success','Category deleted successfully.');
    }
}