<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dormitory extends Model
{
    use HasFactory;

    protected $fillable = [
        'building',
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function applications()
    {
        return $this->hasMany(DormitoryApplication::class);
    }
}
