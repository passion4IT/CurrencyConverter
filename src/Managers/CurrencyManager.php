<?php
/**
 * Currency Manager
 * Author Amit Thakur @ Thakuramit3@hotmail.com
 */

namespace App\Managers;

use App\Entity\CurrencyConversion;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class CurrencyManager
 * @package App\Managers
 */
class CurrencyManager
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * CurrencyManager constructor.
     * @param EntityManager
     */
    public function __construct(ObjectManager $em)
    {
        $this->em = $em;
    }

    /**
     * @return array
     */
    public function getCurrencyConversions():array
    {
        $convertedValues = $this->em->getRepository(CurrencyConversion::class)->findAll();
        $valuesArray = [];
        foreach($convertedValues as $value) {
            $valuesArray[$value->getId()] = [
                'euro'=> $value->getEuroValue(),
                'usd'=> $value->getUSDEquivalent(),
                'franc'=> $value->getFrancEquivalent(),
                'timestamp'=> $value->getTimestamp(),
            ];
        }

        return $valuesArray;
    }

    /**
     * @param $usdValue
     * @param $francValue
     */
    public function postCurrencyConversion($usdValue, $francValue):void
    {
        $currencyConversion = new CurrencyConversion(1, $usdValue, $francValue);
        $this->em->persist($currencyConversion);
        $this->em->flush();
    }
}