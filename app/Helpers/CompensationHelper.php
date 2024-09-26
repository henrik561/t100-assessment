<?php

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Number;

class CompensationHelper
{
    public static function formatCompensationAsCurrency(float $amount): string
    {
        return Number::currency($amount, 'EUR', 'nl_NL');
    }

    public static function getWorkingDaysInMonth(int $month): int
    {
        $date = Carbon::now()->setMonth($month)->startOfMonth();
        return collect(range(1, $date->daysInMonth))->map(function ($day) use ($date) {
            return $date->clone()->setDay($day)->isWeekend() ? 0 : 1;
        })->sum();
    }

    public static function getMonthLabel(int $month): string
    {
        return Carbon::now()->setMonth($month)->startOfMonth()->locale('nl_NL')->isoFormat('dddd D MMMM YYYY');
    }
}
