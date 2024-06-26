<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DormitoryApplicationPeriod extends Model
{
    use HasFactory;

    protected $fillable =['start_date', 'end_date'];

    public function isActive()
    {
        $today = Carbon::today();
        return $today->between($this->start_date, $this->end_date);
    }
}
