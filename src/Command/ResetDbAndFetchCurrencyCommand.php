<?php
/**
 * Reset db and fetch data from API Command
 * Author Amit Thakur @ Thakuramit3@hotmail.com
 */

namespace App\Command;

use http\Exception\RuntimeException;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class ResetDbAndFetchCurrencyCommand
 * @package App\Command
 */
class ResetDbAndFetchCurrencyCommand extends ContainerAwareCommand
{
   /**
     * Description of command
     */
    protected function configure()
    {
        $this->setName('app:resetdb:fetch:currency')
             ->setDescription('Drop, create, update schema and saves new currency values');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $output->writeln(
            ['Resetting database'],
            ['============']
        );

        //Drop existing database, if any
        $dropCommand = $this->getApplication()->find('doctrine:database:drop');
        $dropArgs = [
            'command' => 'doctrine:database:drop',
            '--force' => true
        ];
        $dropDatabaseCommand = new ArrayInput($dropArgs);
        $dropCommand->run($dropDatabaseCommand, $output);

        //Create new database
        $createCommand = $this->getApplication()->find('doctrine:database:create');
        $createCommand->run($input, $output);

        //Update database schema
        $updateCommand = $this->getApplication()->find('doctrine:schema:update');
        $updateSchemaArgs = [
            'command' => 'doctrine:schema:update',
            '--force' => true
        ];
        $updateSchemaCommand = new ArrayInput($updateSchemaArgs);
        $updateCommand->run($updateSchemaCommand, $output);

        //fetching data from currency layer API
        $apiKey = $this->getContainer()->getParameter('currency.api_key');
        $currencyManager = $this->getContainer()->get('app.currency_manager');
        $currencyValues = $currencyManager->changeCurrency($apiKey);

        // throw exception if no values are returned from API
        if(!$currencyValues) {
            throw new RuntimeException('No data received from API');
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
        $resourceUrl = $this->getContainer()->get('router')->generate('get_currency_values');
        $io->writeln('To fetch all currency values from db, request resource at ');
        $io->table(
            ['Name of endpoint', 'Url'],
            [
                ['get_currency_values', $resourceUrl]
            ]
        );

    }
}