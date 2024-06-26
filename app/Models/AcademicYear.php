<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    use HasFactory;

    protected $fillable = ['year'];

    public function groups()
    {
        return $this->hasMany(Group::class);
    }

    public function streams()
    {
        return $this->hasMany(Stream::class);
    }
}
