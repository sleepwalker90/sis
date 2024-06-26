<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'stream_id',
        'academic_year_id',
    ];

    public function stream()
    {
        return $this->belongsTo(Stream::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }
}
