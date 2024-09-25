<?php

namespace App\Enums;

enum TransportationMethods: string
{
    const BIKE = 'bike';
    const CAR = 'car';
    const BUS = 'bus';
    const TRAIN = 'train';

    public static function toArray(): array
    {
        return array_column(self::cases(), 'value');
    }
}
