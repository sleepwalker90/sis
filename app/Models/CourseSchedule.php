<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseSchedule extends Model
{
    use HasFactory;

    protected $fillable = ['course_lecturer_assignment_id', 'group_id', 'class_type', 'day_of_week', 'start_time', 'end_time'];

    public function courseLecturerAssignment()
    {
        return $this->belongsTo(CourseLecturerAssignment::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
