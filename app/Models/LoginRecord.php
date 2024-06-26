<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'login_at',
        'ip_address',
        'client',
        'successful',
    ];
}
