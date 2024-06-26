<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lecturer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'phone_number',
        'room_number',
        'title',
        'office_hours'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_lecturer_assignments')->withPivot('study_plan_id', 'stream_id');
    }

    public function marks()
    {
        return $this->hasMany(Mark::class);
    }

    public function preferredCourses()
    {
        return $this->belongsToMany(Course::class, 'course_lecturer');
    }

}
