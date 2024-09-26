<?php

namespace App\Services;

use App\DTO\CompensationReportDTO;
use App\DTO\EmployeeDTO;
use App\Models\Employee;
use App\Helpers\CompensationHelper;
use Illuminate\Support\Collection;

class CompensationReportService
{
    protected $compensationCalculatorService;

    public function __construct(CompensationCalculatorService $compensationCalculatorService)
    {
        $this->compensationCalculatorService = $compensationCalculatorService;
    }

    /**
     * Generate the compensation report grouped by year and month.
     */
    public function generateReport(): Collection
    {
        $employees = Employee::all()->map(fn($employee) => new EmployeeDTO($employee->name, $employee->transportation_method, $employee->distance));

        return collect(range(1, 12))->map(function ($month) use ($employees) {
            return $this->calculateMonthlyCompensation($employees, $month);
        })->flatten(1);
    }

    /**
     * Calculate the compensation for all employees for a given month.
     */
    private function calculateMonthlyCompensation(Collection $employees, int $month): Collection
    {
        return $employees->map(function (EmployeeDTO $employee) use ($month) {
            return new CompensationReportDTO(
                $employee->name,
                $employee->transportation_method,
                ($employee->distance * CompensationHelper::getWorkingDaysInMonth($month)) . 'km',
                $this->compensationCalculatorService->calculateEmployeeCompensation($employee, $month),
                CompensationHelper::getMonthLabel($month)
            );
        });
    }
}
