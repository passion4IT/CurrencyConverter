<?php
/**
 * Currency Controller
 * Author Amit Thakur @ Thakuramit3@hotmail.com
 */

namespace App\Controller;

use App\Managers\CurrencyManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
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
     * @Route("/", name="home_page")
     * @Method("GET")
     */
    public function indexAction()
    {
        return $this->render('index.html.twig');
    }

    /**
     * @Route("/currency/conversion", name="fetch_new_rate", options={"expose" = true})
     * @param CurrencyManager $manager
     * @Method("GET")
     * @return JsonResponse
     */
    public function getCurrencyFromAPI(CurrencyManager $manager)
    {
        $apiKey = $this->getParameter('currency.api_key');
        $currenyResult = $manager->changeCurrency($apiKey);
        $currenyResult = $manager->getConvertedValues($currenyResult['quotes']['USDEUR'], $currenyResult['quotes']['USDCHF']);
        $manager->postCurrencyConversion($currenyResult[0], $currenyResult[1]);
        $newRates = $manager->getCurrencyConversions();
        return new JsonResponse($newRates);
    }

    /**
     * @Route("/currencies", name="get_currency_values", options={"expose"= true})
     * @param CurrencyManager $manager
     * @Method("GET")
     * @return JsonResponse
     */
    public function getCurrencyValues(CurrencyManager $manager)
    {
        $convertedValues = $manager->getCurrencyConversions();
        return new JsonResponse($convertedValues);
    }
}