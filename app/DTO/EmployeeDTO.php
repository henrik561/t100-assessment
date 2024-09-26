<?php

namespace App\DTO;

class EmployeeDTO
{
    public string $name;
    public string $transportation_method;
    public float $distance;

    public function __construct(string $name, string $transportation_method, float $distance)
    {
        $this->name = $name;
        $this->transportation_method = $transportation_method;
        $this->distance = $distance;
    }
}
