<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    public function getWorkingDaysPerWeek(): float
    {
        // ceil the number of workdays per week because working 4.5 days still means going to office 5 days
        return ceil($this->workdays_per_week);
    }
}
