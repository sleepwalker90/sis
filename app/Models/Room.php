<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    public function dormitory()
    {
        return $this->belongsTo(Dormitory::class);
    }

    public function applications()
    {
        return $this->hasMany(DormitoryApplication::class);
    }

    public function accommodations()
    {
        return $this->hasMany(Accommodation::class);
    }


}
