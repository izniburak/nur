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

class UpCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('app:up')
            ->setDescription("Bring the application out of maintenance mode.")
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $file = getcwd() . '/app.down';

        if(file_exists($file))
        {
            unlink($file);
            $output->writeln(
                "\n" . ' <info>+Success!</info> Mubu Application was started.'
            );
        }
        else 
            $output->writeln(
                "\n" . " <info>+Error!</info> Mubu Application's already started."
            );
        return;
    }
}
