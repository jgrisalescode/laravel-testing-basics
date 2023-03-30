<?php

namespace App\Services;

class CurrencyService
{

    const EUR = 0.98;

    public function convert(float $amount): float
    {
        return self::EUR * $amount;
    }
}
