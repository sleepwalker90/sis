<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stream extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'study_plan_id',
        'academic_year_id',
    ];

    public function studyPlan()
    {
        return $this->belongsTo(StudyPlan::class);
    }

    public function groups()
    {
        return $this->hasMany(Group::class);
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function courseLecturerAssignments()
    {
        return $this->hasMany(CourseLecturerAssignment::class);
    }
}
