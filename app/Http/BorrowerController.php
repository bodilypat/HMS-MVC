<?php

namespace App\Http\Controllers;

use App\Models\Borrower;
use Illuminate\Http\Request;

class BorrowerController extends Controller
{

    /* Display a listing of the borrowers */
    public function index()
    {
        $borrowers = Borrower::all();
        return view('borrowers.index', compact('borrowers'));
    }

    /* Show the form for creating a new author */
    public function create()
    {
        return view('borrowers.create');
    }

    /* Store a  newly created borrower in storage */
    public function (Request Request)
    {
        $request->validate([
            'name' => 'required:string|max:255',
            'email' => 'required:email|unique:borrowers, email',
            'phone' => 'nullable|string|max:15',
        ]);

        Borrower::create($request->all);
        return redirect->route('borrowers.index')->with('success','borrowers created successfully.');
    }

    /* Show the form for editing the specified borrowes */
    public function edit($id)
    {
        $borrowers = Borrower::findOFail('id');
        return view('borrowers.edit', compact('borrowers'));
    }

    /* Update the specified Borrows in storage. */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:borrowers,email,' . $borrower->id,
        ]);

        $borrowers = Borrower::findOrFail($id);
        $borrowers->update($request->all());
        return redirect->route('borrowers.index')->with('success','Borrowers updated successfully.');
    }

    /* Remove the specified borrows from storage */
    public function destroy($id)
    {
        $borrowers = Borrower::findOrFail($id);
        $borrowers->delete();
        return redirect()->route('borrowers.index')->with('success','borrowers deleted successfully.');
    }

}