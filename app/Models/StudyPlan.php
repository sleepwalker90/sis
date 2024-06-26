<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'major_id',
        'academic_year_id',
        'status',
    ];

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'study_plan_courses', 'study_plan_id', 'course_id')
                    ->withPivot('semester')
                    ->orderBy('semester', 'asc')
                    ->orderBy('id', 'asc');
    }

    public function major()
    {
        return $this->belongsTo(Major::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function streams()
    {
        return $this->hasMany(Stream::class);
    }

}
