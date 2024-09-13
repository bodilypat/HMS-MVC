<?php

namespace  App\Http\Controllers;

use  App\Models\student;
use  App\Http\Requests\StorestudentRequest;
use  App\Http\Requests\UpdatestudentRequest;

class UserController extends Controller
{
    public function index()
    {
        return view('users.index', [
            'users' => student::Paginate(5)
        ]);
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(StorestudentRequest $request)
    {
        student::create($request->validated());
        return redirect()->route('users');
    }

    public function show($id)
    {
        $student = student::find($id)->first();
        return $student;
    }
    public function edit(student $student)
    {
        return view('users.edit', [
            'user' => $student
        ]);
    }

    public function update(UpdatestudentRequest $request, $id)
    {
        $user = student::find($id);
        $user->name = $request->name;;
        $user->address = $request->address;
        $user->gender = $request->gender;
        $user->class = $request->class;
        $user->age = $request->age;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->save();

        return redirect()->route('users');
    }

    public function destroy($id)
    {
        student::find($id)->delete();
        return redirect()->route('users');
    }
}