<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseLecturerAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'study_plan_id',
        'lecturer_id',
        'stream_id',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function studyPlan()
    {
        return $this->belongsTo(StudyPlan::class);
    }

    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class);
    }

    public function stream()
    {
        return $this->belongsTo(Stream::class);
    }
}
