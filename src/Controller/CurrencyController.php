<?php
/**
 * Currency Controller
 * Author Amit Thakur @ Thakuramit3@hotmail.com
 */

namespace App\Controller;
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
     * @Route("/", name="home_page", options={"expose" = true})
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function indexAction()
    {
        $apiKey = $this->getParameter('currency.api_key');
        $currencyLayer = new client($apiKey);
        $currenyResult = $this->changeCurrency($currencyLayer);
        return new JsonResponse($currenyResult);
    }

    /**
     * @param \OceanApplications\currencylayer\client $currencyLayer
     * @return array
     */
    private function changeCurrency(client $currencyLayer)
    {
        $currenyResult = $currencyLayer
            ->currencies('EUR,CHF')
            ->live();
        return $currenyResult;
    }
}