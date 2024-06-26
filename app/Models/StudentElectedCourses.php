<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentElectedCourses extends Model
{
    use HasFactory;

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function electiveGroup()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function electedCourse()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
