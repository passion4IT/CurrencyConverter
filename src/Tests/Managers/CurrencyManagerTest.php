<?php

namespace App\Tests\Managers;

use App\Managers\CurrencyManager;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CurrencyManagerTest extends WebTestCase
{
    CONST API_KEY = 'CHANGE_API_KEY';

    /** @var EntityManager */
    private $em;

    /**
     * access doctrine manager
     */
    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->em = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    /**
     * test getConvertedValues
     */
    public function testgetConvertedValues()
    {
        $currencyManager = new CurrencyManager($this->em);
        $values = $currencyManager->getConvertedValues(1.23, 1.34);
        $this->assertEquals(2, count($values));
    }

    /**
     * test changeCurrency
     */
    public function testChangeCurrency()
    {
        $currencyManager = new CurrencyManager($this->em);
        $jsonResults = $currencyManager->changeCurrency(self::API_KEY);
        $this->assertInternalType('array', $jsonResults);
        $this->assertArrayHasKey('source', $jsonResults);
    }
}