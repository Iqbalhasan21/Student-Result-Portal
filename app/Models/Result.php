<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Result extends Model
{
    protected $fillable = ['student_id', 'course_code', 'marks', 'grade'];

    // Each result belongs to one student
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    // Grade is calculated automatically from marks every time a result is saved
    protected static function booted(): void
    {
        static::saving(function (Result $result) {
            $result->grade = self::gradeFor($result->marks);
        });
    }

    public static function gradeFor(int $marks): string
    {
        return match (true) {
            $marks >= 80 => 'A+',
            $marks >= 70 => 'A',
            $marks >= 60 => 'A-',
            $marks >= 50 => 'B',
            $marks >= 40 => 'C',
            $marks >= 33 => 'D',
            default      => 'F',
        };
    }
}
