<?php

namespace Database\Factories;

use App\Enums\TransportationMethods;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            // again this is a workaround for the toArray() or cases() methods not working //TODO: optimize this
            'transportation_method' => $this->faker->randomElement([TransportationMethods::BIKE, TransportationMethods::CAR, TransportationMethods::BUS, TransportationMethods::TRAIN]),
            'distance' => $this->faker->numberBetween(1, 100),
            'workdays_per_week' => $this->faker->randomFloat(1, 1, 5),
        ];
    }
}
