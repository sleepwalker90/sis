<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function faculty() {
        return $this->belongsTo(Faculty::class);
    }

    public function major() {
        return $this->belongsTo(Major::class);
    }

    public function studentStatus() {
        return $this->belongsTo(StudentStatus::class);
    }

    public function tuition() {
        return $this->belongsTo(Tuition::class);
    }

    public function electedCourses() {
        return $this->hasMany(Course::class, );
    }

    public function studyPlan() {
        return $this->belongsTo(StudyPlan::class);
    }

    public function courses() {
        return $this->belongsToMany(Course::class, 'marks')->withPivot('mark', 'type');
    }

    public function attestations() {
        return $this->hasMany(Attestation::class);
    }

    public function scholarships() {
        return $this->hasMany(Scholarship::class);
    }

    public function dormitoryApplications() {
        return $this->hasMany(DormitoryApplication::class);
    }

    public function accommodations() {
        return $this->hasMany(Accommodation::class);
    }

    public function currentAccommodation() {
        return $this->hasOne(Accommodation::class)->whereNull('end_date');
    }

    public function payments() {
        return $this->hasMany(Payment::class);
    }

    public function group() {
        return $this->belongsTo(Group::class);
    }

    public function marks() {
        return $this->hasMany(Mark::class);
    }

}
