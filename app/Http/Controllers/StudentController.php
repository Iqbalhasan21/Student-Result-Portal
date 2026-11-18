<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Models\Student;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class StudentController extends Controller implements HasMiddleware
{
    // Create, edit and delete are protected; list and show are public
    public static function middleware(): array
    {
        return [new Middleware('auth', except: ['index', 'show'])];
    }

    public function index()
    {
        $students = Student::withCount('results')->latest()->paginate(8);
        return view('students.index', compact('students'));
    }

    public function create()
    {
        return view('students.create');
    }

    public function store(StudentRequest $request)
    {
        Student::create($request->validated());
        return redirect()->route('students.index')->with('success', 'Student added successfully.');
    }

    // Page that displays a student's results
    public function show(Student $student)
    {
        $student->load('results');
        $average = $student->results->avg('marks');
        return view('students.show', compact('student', 'average'));
    }

    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    public function update(StudentRequest $request, Student $student)
    {
        $student->update($request->validated());
        return redirect()->route('students.show', $student)->with('success', 'Student updated.');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Student deleted.');
    }
}
