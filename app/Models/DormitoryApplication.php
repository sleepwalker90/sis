<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DormitoryApplication extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'status', 'academic_year'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

}
