<?php
/**
 * Currency Controller
 * Author Amit Thakur @ Thakuramit3@hotmail.com
 */

namespace App\Controller;

use App\Managers\CurrencyManager;
use OceanApplications\currencylayer\client;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CurrencyController
 * @package App\Controller
 */
class CurrencyController extends Controller
{
    /**
     * @Route("/currency-conversion/create", name="post_currency_conversion", options={"expose" = true})
     * @param CurrencyManager $manager
     * @return JsonResponse
     */
    public function indexAction(CurrencyManager $manager)
    {
        $apiKey = $this->getParameter('currency.api_key');
        $currenyResult = $this->changeCurrency($apiKey);
        $currenyResult = $manager->getConvertedValues($currenyResult['quotes']['USDEUR'], $currenyResult['quotes']['USDCHF']);
        $manager->postCurrencyConversion($currenyResult[0], $currenyResult[1]);
        return new JsonResponse($currenyResult);
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