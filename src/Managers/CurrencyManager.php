<?php
/**
 * Currency Manager
 * Author Amit Thakur @ Thakuramit3@hotmail.com
 */

namespace App\Managers;

use App\Entity\CurrencyConversion;
use Doctrine\Common\Persistence\ObjectManager;
use OceanApplications\currencylayer\client;

/**
 * Class CurrencyManager
 * @package App\Managers
 */
class CurrencyManager
{
    /**
     * @var ObjectManager
     */
    private $em;

    /**
     * CurrencyManager constructor.
     * @param ObjectManager
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
        $convertedValues = $this->em->getRepository(CurrencyConversion::class)->findBy([], ['timestamp' => 'DESC']);
        $valuesArray = [];
        /** @var CurrencyConversion $value */
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
        /** @var CurrencyConversion $currencyConversion */
        $currencyConversion = new CurrencyConversion(1, $usdValue, $francValue);
        $this->em->persist($currencyConversion);
        $this->em->flush();
    }

    /**
     * @param $euro
     * @param $franc
     * @return array
     * Currencylayer API only converts from USD to other currencies
     * with free version
     * this will convert euro to usd and franc
     */
    public function getConvertedValues($euro, $franc):array
    {
        $usdValue = sprintf('%0.6f', 1/$euro);
        $francValue = sprintf('%0.6f', $franc/$euro);
        return [$usdValue, $francValue];
    }

    /**
     * @param $apiKey
     * @return array
     */
    public function changeCurrency($apiKey):array
    {
        $currencyLayer = new client($apiKey);
        $currenyResult = $currencyLayer
            ->currencies('EUR,CHF')
            ->live();
        return $currenyResult;
    }

}