<?php

namespace App\Tests\Managers;

use App\Managers\CurrencyManager;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class CurrencyManagerTest
 * @package App\Tests\Managers
 */
class CurrencyManagerTest extends WebTestCase
{

    /** @var EntityManager */
    private $em;

    /** @var string */
    private $apiKey;

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
        $jsonResults = $currencyManager->changeCurrency($this->apiKey);
        $this->assertInternalType('array', $jsonResults);
        $this->assertArrayHasKey('source', $jsonResults);
    }

    /**
     * access doctrine manager
     */
    protected function setUp()
    {
        $kernel = self::bootKernel();
        $this->em = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
        $this->apiKey = $kernel->getContainer()->getParameter('currency.api_key');
    }
}