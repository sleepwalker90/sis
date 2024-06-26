<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accommodation extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'room_id', 'dormitory_id', 'start_date', 'end_date', 'status'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function dormitory()
    {
        return $this->belongsTo(Dormitory::class);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if ($model->status == 'active') {
                // Ensure there is only one active accommodation for the student
                Accommodation::where('student_id', $model->student_id)
                    ->where('status', 'active')
                    ->update(['status' => 'left', 'end_date' => now()]);
            }
        });
    }
}
