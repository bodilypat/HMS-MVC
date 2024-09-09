<?php

namespace  App\Http\Controllers;

use  App\Models\student;
use  App\Http\Requests\StorestudentRequest;
use  App\Http\Requests\UpdatestudentRequest;

class studentController extends Controller
{
    public function index()
    {
        return view('student.index', [
            'students' => student::Paginate(5)
        ]);
    }

    public function create()
    {
        return view('student.create');
    }

    public function store(StorestudentRequest $request)
    {
        student::create($request->validated());
        return redirect()->route('students');
    }

    public function show($id)
    {
        $student = student::find($id)->first();
        return $student;
    }
    public function edit(student $student)
    {
        return view('student.edit', [
            'student' => $student
        ]);
    }

    public function update(UpdatestudentRequest $request, $id)
    {
        $student = student::find($id);
        $student->name = $request->name;;
        $student->address = $request->address;
        $student->gender = $request->gender;
        $student->class = $request->class;
        $student->age = $request->age;
        $student->phone = $request->phone;
        $student->email = $request->email;
        $student->save();

        return redirect()->route('students');
    }

    public function destroy($id)
    {
        student::find($id)->delete();
        return redirect()->route('students');
    }
}