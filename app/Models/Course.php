<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'credits',
        'major_id',
        'code',
        'hasLectures',
        'hasSeminars',
        'hasLabs',
        'hasExam',
        'hasOa',
        'hasPw',
        'hasCw',
        'elective_course_group_id',
        'is_elective_group',
    ];

    protected $casts = [
        'is_elective_group' => 'boolean',
        'hasLectures' => 'boolean',
        'hasSeminar' => 'boolean',
        'hasLabs' => 'boolean',
        'hasExam' => 'boolean',
        'hasOa' => 'boolean',
        'hasPw' => 'boolean',
        'hasCw' => 'boolean',
    ];

    public function major() {
        return $this->belongsTo(Major::class);
    }

    public function study_plans() {
        return $this->belongsToMany(StudyPlan::class, 'study_plan_courses', 'course_id', 'study_plan_id')->withPivot('semester');
    }

    /**
     * Get the elective group that this course belongs to.
     */
    public function electiveGroup()
    {
        return $this->belongsTo(Course::class, 'elective_course_group_id');
    }

    /**
     * Get all courses that are part of this elective group.
     */
    public function electiveCourses()
    {
        return $this->hasMany(Course::class, 'elective_course_group_id');
    }


    // Relationship with students through marks
    public function students() {
        return $this->belongsToMany(Student::class, 'marks')->withPivot('mark', 'type');
    }

    // Relationship with marks directly 
    public function marks() {
        return $this->hasMany(Mark::class);
    }

    public function attestations() {
        return $this->hasMany(Attestation::class);
    }

    public function lecturers() {
        return $this->belongsToMany(Lecturer::class, 'course_lecturer_assignments')->withPivot('study_plan_id', 'stream_id');
    }

    public function preferredLecturers() {
        return $this->belongsToMany(Lecturer::class, 'course_lecturer');
    }
}
