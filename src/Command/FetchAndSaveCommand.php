<?php
/**
 * Reset db and fetch data from API Command
 * Author Amit Thakur @ Thakuramit3@hotmail.com
 */

namespace App\Command;

use App\Traits\APITrait;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class FetchAndSaveCommand
 * @package App\Command
 */
class FetchAndSaveCommand extends ContainerAwareCommand
{
    use APITrait;

    /**
     * Description of Command
     */
    protected function configure()
    {
        $this->setName('app:fetch:currency:save')
            ->setDescription('This will fetch currency values from API and save in db');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('This command will fetch data from API for EURO, USD, FRANC conversion');

        $currencyManager = $this->getContainer()->get('app.currency_manager');
        $apiKey = $this->getContainer()->getParameter('currency.api_key');
        $router = $this->getContainer()->get('router');

        //fetch data from API and save values in db
        $this->fetchAndSave($io, $currencyManager, $apiKey, $router);
    }
}