<?php

namespace App\Services;

use App\Enums\TransportationMethods;
use App\DTO\EmployeeDTO;
use App\Helpers\CompensationHelper;
use Illuminate\Support\Facades\Config;

class CompensationCalculatorService
{
    public function calculateEmployeeCompensation(EmployeeDTO $employee, int $currentMonth): string
    {
        $employeeWorkingDays = CompensationHelper::getWorkingDaysInMonth($currentMonth);
        $distancePerDay = $employee->distance * 2; // Round trip distance
        $totalCompensation = 0;

        switch ($employee->transportation_method) {
            case TransportationMethods::BIKE:
                [$rateBelowThreshold, $rateAboveThreshold, $thresholdDistanceMin, $thresholdDistanceMax] = array_values(Config::get('compensation.' . TransportationMethods::BIKE));

                $totalCompensation = $this->calculateBikeCompensation($distancePerDay, $rateBelowThreshold, $rateAboveThreshold, $thresholdDistanceMin, $thresholdDistanceMax, $employeeWorkingDays);
                break;

            case TransportationMethods::BUS:
            case TransportationMethods::TRAIN:
            case TransportationMethods::CAR:
                $ratePerKm = Config::get('compensation.' . $employee->transportation_method . '.rate_per_km');
                $dailyCompensation = $distancePerDay * $ratePerKm;
                $totalCompensation = $dailyCompensation * $employeeWorkingDays;
                break;

            default:
                break;
        }

        return CompensationHelper::formatCompensationAsCurrency($totalCompensation);
    }

    private function calculateBikeCompensation($distancePerDay, $rateBelowThreshold, $rateAboveThreshold, $thresholdDistanceMin, $thresholdDistanceMax, $employeeWorkingDays): float
    {
        $dailyCompensation = 0;

        if ($distancePerDay <= $thresholdDistanceMin) {
            $dailyCompensation = $distancePerDay * $rateBelowThreshold;
        } elseif ($distancePerDay > $thresholdDistanceMin && $distancePerDay <= $thresholdDistanceMax) {
            $dailyCompensation = $thresholdDistanceMin * $rateBelowThreshold;
            $remainingDistance = $distancePerDay - $thresholdDistanceMin;
            $dailyCompensation += $remainingDistance * $rateAboveThreshold;
        } else {
            $dailyCompensation = $thresholdDistanceMin * $rateBelowThreshold;
            $midRangeDistance = $thresholdDistanceMax - $thresholdDistanceMin;
            $dailyCompensation += $midRangeDistance * $rateAboveThreshold;
            $remainingDistance = $distancePerDay - $thresholdDistanceMax;
            $dailyCompensation += $remainingDistance * $rateBelowThreshold;
        }

        return $dailyCompensation * $employeeWorkingDays;
    }
}
