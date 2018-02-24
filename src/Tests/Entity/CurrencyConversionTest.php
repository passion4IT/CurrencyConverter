<?php

namespace App\Tests\Entity;

use App\Entity\CurrencyConversion;
use PHPUnit\Framework\TestCase;

class CurrencyConversionTest extends TestCase
{
    /**
     * Test Constructor of CurrencyConversion Entity
     */
    public function testConstructor()
    {
        $currencyConversion = self::createConversion(1.45, 1.43);
        $this->assertInstanceOf(CurrencyConversion::class, $currencyConversion);
    }

    /**
     * test getId
     */
    public function testGetId()
    {
        $currencyConversion = self::createConversion(1.34, 1.40);
        $this->assertGreaterThan(30, strlen($currencyConversion->getId()));
    }

    /**
     * test getEuroValue
     */
    public function testGetEuroValue()
    {
        $currencyConversion = self::createConversion(1.47, 1.49);
        $this->assertSame(1, (int)($currencyConversion->getEuroValue()));
    }

    /**
     * test getUSDEquivalent
     */
    public function testGetUSDEquivalent()
    {
        $currencyConversion = self::createConversion(1.54, 1.35);
        $this->assertEquals(1.54, $currencyConversion->getUSDEquivalent());
    }

    /**
     * test getFrancEquivalent
     */
    public function testGetFrancEquivalent()
    {
        $currencyConversion = self::createConversion(1.44, 1.34);
        $this->assertLessThanOrEqual(1.34, $currencyConversion->getFrancEquivalent());
    }

    /**
     * test GetTimestamp
     */
    public function testGetTimestamp()
    {
        $currencyConversion = self::createConversion(1.03, 1.23);
        $this->assertInstanceOf(\DateTime::class, $currencyConversion->getTimestamp());
    }

    /**
     * @param $dollar
     * @param $franc
     * @return CurrencyConversion
     */
    private static function createConversion($dollar, $franc)
    {
        $currencyConversion = new CurrencyConversion(1, $dollar, $franc);
        return $currencyConversion;
    }
}