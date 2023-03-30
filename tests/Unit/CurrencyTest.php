<?php

namespace Tests\Unit;

use App\Services\CurrencyService;
use PHPUnit\Framework\TestCase;

class CurrencyTest extends TestCase
{
    /** @test */
    public function conver_usd_to_eur_successful(): void
    {
        $result = (new CurrencyService())->convert(100);
        $this->assertEquals(98, $result);
    }
}
