<?php

namespace App\Traits;

use App\Managers\CurrencyManager;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Trait APITrait
 * @package App\Traits
 */
trait APITrait
{
    /**
     * @param CurrencyManager $currencyManager
     * @param $apiKey
     */
    public function fetchAndSave(SymfonyStyle $io, CurrencyManager $currencyManager, $apiKey, $router)
    {
        try {
            $currencyValues = $currencyManager->changeCurrency($apiKey);
        } catch(\RuntimeException $exception) {
            throw new \RuntimeException($exception->getMessage());
        }

        $convertedValues = $currencyManager->getConvertedValues($currencyValues['quotes']['USDEUR'], $currencyValues['quotes']['USDCHF']);
        $io->success('Currency Values received from API');
        $io->table(
            ['EUR', 'USD', 'FRANC'],
            [
                [1, sprintf('%0.6f',$convertedValues[0]), sprintf('%0.6f', $convertedValues[1])]
            ]
        );

        $io->text('Saving currency values in db...');
        $currencyManager->postCurrencyConversion(1, $convertedValues[0], $convertedValues[1]);
        $io->success('Values saved successfully in db!');

        // provided endpoint to fetch all values from db
        $resourceUrl = $router->generate('get_currency_values');
        $io->writeln('Get all currency values from database at ');
        $io->table(
            ['Name of endpoint', 'Url'],
            [
                ['get_currency_values', $resourceUrl]
            ]
        );
    }
}