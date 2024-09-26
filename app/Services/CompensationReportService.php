<?php

namespace App\Services;

use App\Enums\TransportationMethods;
use App\Models\Employee;
use Illuminate\Support\Facades\Config;
use Carbon\Carbon;

class CompensationReportService
{
    private $currentYear;

    public function __construct()
    {
        $this->currentYear = Carbon::now()->year;
    }
    /**
     * Generate the compensation report grouped by year and month.
     */
    public function generateReport()
    {
        $employees = Employee::all();

        return collect(range(1, 12))->mapWithKeys(function ($month) use ($employees) {
            return [$month => $this->calculateMonthlyCompensation($employees, $month)];
        })->toArray();
    }

    /**
     * Calculate the compensation for all employees for a given month.
     */
    private function calculateMonthlyCompensation($employees, $month)
    {
        return $employees->map(function ($employee) use ($month) {
            return [
                'name' => $employee->name,
                'compensation' => $this->calculateEmployeeCompensation($employee, $month),
            ];
        });
    }

    /**
     * Calculate the compensation for a single employee based on transportation method and distance.
     */
    private function calculateEmployeeCompensation(Employee $employee, $currentMonth)
    {
        $employeeWorkingDays = $this->getWorkingDaysInMonth($currentMonth);
        $distancePerDay = $employee->distance * 2; // Round trip distance
        $totalCompensation = 0;

        switch ($employee->transportation_method) {
            case TransportationMethods::BIKE:
                [$rateBelowThreshold, $rateAboveThreshold, $thresholdDistanceMin, $thresholdDistanceMax] = array_values(Config::get('compensation.' . TransportationMethods::BIKE));

                $dailyCompensation = 0;

                // Calculate for the below threshold distance (first 5 km)
                if ($distancePerDay <= $thresholdDistanceMin) {
                    $dailyCompensation = $distancePerDay * $rateBelowThreshold;
                }
                // Calculate for the distance between 5 km and 10 km
                elseif ($distancePerDay > $thresholdDistanceMin && $distancePerDay <= $thresholdDistanceMax) {
                    // First 5 km at the below threshold rate
                    $dailyCompensation = $thresholdDistanceMin * $rateBelowThreshold;

                    // Remaining distance (up to 10 km) at the above threshold rate
                    $remainingDistance = $distancePerDay - $thresholdDistanceMin;
                    $dailyCompensation += $remainingDistance * $rateAboveThreshold;
                }
                // Calculate for distance beyond 10 km
                else {
                    // First 5 km at the below threshold rate
                    $dailyCompensation = $thresholdDistanceMin * $rateBelowThreshold;

                    // 5-10 km at the above threshold rate
                    $midRangeDistance = $thresholdDistanceMax - $thresholdDistanceMin;
                    $dailyCompensation += $midRangeDistance * $rateAboveThreshold;

                    // Distance beyond 10 km at the below threshold rate again
                    $remainingDistance = $distancePerDay - $thresholdDistanceMax;
                    $dailyCompensation += $remainingDistance * $rateBelowThreshold;
                }

                // Total weekly compensation = daily compensation * number of working days
                $totalCompensation = $dailyCompensation * $employeeWorkingDays;
                break;

            case TransportationMethods::BUS:
            case TransportationMethods::TRAIN:
            case TransportationMethods::CAR:
                // For Bus, Train, and Car, use a fixed rate per kilometer
                $ratePerKm = Config::get('compensation.' . $employee->transportation_method . '.rate_per_km');

                // Total compensation for the day
                $dailyCompensation = $distancePerDay * $ratePerKm;

                // Total weekly compensation = daily compensation * number of working days
                $totalCompensation = $dailyCompensation * $employeeWorkingDays;
                break;

            default:
                break;
        }

        return $totalCompensation;
    }

    private function getWorkingDaysInMonth($month)
    {
        $date = Carbon::now()->setMonth($month)->startOfMonth();

        return collect(range(1, $date->daysInMonth))->map(function ($day) use ($date) {
            return $date->clone()->setDay($day)->isWeekend() ? 0 : 1;
        })->sum();
    }
}
