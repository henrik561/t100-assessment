<?php

namespace App\DTO;

class CompensationReportDTO
{
    public string $name;
    public string $transport;
    public string $distance;
    public string $compensation;
    public string $month;

    public function __construct(string $name, string $transport, string $distance, string $compensation, string $month)
    {
        $this->name = $name;
        $this->transport = $transport;
        $this->distance = $distance;
        $this->compensation = $compensation;
        $this->month = $month;
    }
}
