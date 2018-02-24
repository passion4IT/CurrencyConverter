<?php
/**
 * Currency Controller
 * Author Amit Thakur @ Thakuramit3@hotmail.com
 */

namespace App\Controller;

use App\Entity\CurrencyConversion;
use App\Managers\CurrencyManager;
use OceanApplications\currencylayer\client;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CurrencyController
 * @package App\Controller
 */
class CurrencyController extends Controller
{
    /**
     * @Route("/currency-conversion/create", name="post_currency_conversion", options={"expose" = true})
     * @return JsonResponse
     */
    public function indexAction(CurrencyManager $manager)
    {
        $apiKey = $this->getParameter('currency.api_key');
        $currencyLayer = new client($apiKey);
        $currenyResult = $this->changeCurrency($currencyLayer);
        $manager->postCurrencyConversion($currenyResult['quotes']['USDEUR'], $currenyResult['quotes']['USDCHF']);
        return new JsonResponse($currenyResult);
    }

    /**
     * @param client $currencyLayer
     * @return array
     */
    private function changeCurrency(client $currencyLayer)
    {
        $currenyResult = $currencyLayer
            ->currencies('EUR,CHF')
            ->live();
        return $currenyResult;
    }

    /**
     * @Route("/currencies", name="get_currency_values", options={"expose"= true})
     * @param CurrencyManager $manager
     * @return JsonResponse
     */
    public function getCurrencyValues(CurrencyManager $manager)
    {
        $convertedValues = $manager->getCurrencyConversions();
        return new JsonResponse($convertedValues);
    }
}