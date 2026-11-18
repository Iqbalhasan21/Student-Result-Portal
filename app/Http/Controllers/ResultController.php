<?php

namespace App\Http\Controllers;

use App\Models\Result;
use App\Models\Student;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function store(Request $request, Student $student)
    {
        $data = $request->validate([
            'course_code' => ['required', 'string', 'max:20'],
            'marks'       => ['required', 'integer', 'between:0,100'],
        ]);

        // grade is filled automatically by the Result model
        $student->results()->create($data);

        return back()->with('success', 'Result added.');
    }

    public function destroy(Result $result)
    {
        $result->delete();
        return back()->with('success', 'Result removed.');
    }
}
