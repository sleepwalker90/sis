<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'type',
        'amount',
        'status',
        'transaction_id',
    ];

    public function scopeFilter($query, $filters)
    {
        if (isset($filters['fn'])) {
            $query->where('fn', $filters['fn']);
        }

        if (isset($filters['egn'])) {
            $query->where('egn', $filters['egn']);
        }

        return $query;
    }


    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
