<?php
/**
 * Mubu - A simple framework for PHP Developers
 *
 * @package    Mubu
 * @author     İzni Burak Demirtaş <izniburak@gmail.com>
 * @web        <http://burakdemirtas.org>
 */

namespace Mubu\Console\Commands\App;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class StatusCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('app:status')
            ->setDescription("The current state of the application.")
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $file = getcwd() . '/app.down';

        if(!file_exists($file))
            $output->writeln(
                "\n" . " Mubu Application's running."
            );
        else 
            $output->writeln(
                "\n" . " Mubu Application has been stopped."
            );

        return;
    }
}
