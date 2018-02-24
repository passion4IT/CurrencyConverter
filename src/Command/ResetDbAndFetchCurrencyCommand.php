<?php
/**
 * Reset db and fetch data from API Command
 * Author Amit Thakur @ Thakuramit3@hotmail.com
 */

namespace App\Command;

use App\Traits\APITrait;
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
    use APITrait;

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
        $io->title('This command will reset db, fetch data from API and save in db');

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
        $router = $this->getContainer()->get('router');

        //fetch data currency data from API and save in db
        $this->fetchAndSave($io, $currencyManager, $apiKey, $router);
    }
}