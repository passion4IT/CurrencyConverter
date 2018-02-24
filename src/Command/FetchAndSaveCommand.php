<?php
/**
 * Reset db and fetch data from API Command
 * Author Amit Thakur @ Thakuramit3@hotmail.com
 */

namespace App\Command;

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
    }
}