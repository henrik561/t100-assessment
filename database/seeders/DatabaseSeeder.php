<?php

namespace Database\Seeders;

use App\Enums\TransportationMethods;
use App\Models\Employee;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Define an array of employees
        $employees = [
            [
                'name' => 'Paul',
                'transportation_method' => TransportationMethods::CAR,
                'distance' => 60,
                'workdays_per_week' => 5,
            ],
            [
                'name' => 'Martin',
                'transportation_method' => TransportationMethods::BUS,
                'distance' => 8,
                'workdays_per_week' => 4,
            ],
            [
                'name' => 'Jeroen',
                'transportation_method' => TransportationMethods::BIKE,
                'distance' => 9,
                'workdays_per_week' => 5,
            ],
            [
                'name' => 'Tineke',
                'transportation_method' => TransportationMethods::BIKE,
                'distance' => 4,
                'workdays_per_week' => 3,
            ],
            [
                'name' => 'Arnout',
                'transportation_method' => TransportationMethods::TRAIN,
                'distance' => 23,
                'workdays_per_week' => 5,
            ],
            [
                'name' => 'Matthijs',
                'transportation_method' => TransportationMethods::BIKE,
                'distance' => 11,
                'workdays_per_week' => 4.5,
            ]
        ];

        // Loop through each employee and create a record
        foreach ($employees as $employee) {
            Employee::factory()->create($employee);
        }
    }
}
