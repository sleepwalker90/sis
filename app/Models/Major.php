<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'faculty_id',
        'degree_type_id',
        'education_type_id',
        'semesters'
    ];

    public function faculty() {
        return $this->belongsTo(Faculty::class);
    }

    public function students() {
        return $this->hasMany(Student::class);
    }

    public function educationType() {
        return $this->belongsTo(EducationType::class);
    }

    public function degreeType() {
        return $this->belongsTo(DegreeType::class);
    }

    public function courses() {
        return $this->hasMany(Course::class);
    }

    public function studyPlans() {
        return $this->hasMany(StudyPlan::class);
    }

    public function streams() {
        return $this->hasMany(Stream::class);
    }
    
}
