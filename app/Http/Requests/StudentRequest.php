<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $student = $this->route('student'); // null on create, model on update

        return [
            'name'       => ['required', 'string', 'min:3', 'max:100'],
            'roll'       => ['required', 'string', 'max:30', Rule::unique('students', 'roll')->ignore($student)],
            'department' => ['required', 'string', 'max:50'],
            'email'      => ['required', 'email', Rule::unique('students', 'email')->ignore($student)],
        ];
    }
}
