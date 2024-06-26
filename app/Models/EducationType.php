<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationType extends Model
{
    use HasFactory;

    public function majors() {
        return $this->hasMany(Major::class, 'education_type_id', 'id');
    }
}
