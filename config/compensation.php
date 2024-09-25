<?php

use App\Enums\TransportationMethods;

return [
    TransportationMethods::BIKE => [
        'rate_below_threshold' => 0.50,
        'rate_above_threshold' => 1.00,
        'threshold_distance_min' => 5,
        'threshold_distance_max' => 10,
    ],
    TransportationMethods::CAR => [
        'rate_per_km' => 0.10,
    ],
    TransportationMethods::BUS => [
        'rate_per_km' => 0.25,
    ],
    TransportationMethods::TRAIN => [
        'rate_per_km' => 0.25,
    ],
];
