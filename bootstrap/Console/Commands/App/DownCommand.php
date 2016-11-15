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

class DownCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('app:down')
            ->setDescription("Put the application into maintenance mode.")
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $file = getcwd() . '/app.down';

        if(!file_exists($file))
        {
            touch($file);
            $output->writeln(
                "\n" . ' <info>+Success!</info> Mubu Application was stopped.'
            );
        }
        else 
            $output->writeln(
                "\n" . " <info>+Error!</info> Mubu Application's already stopped."
            );

        return;
    }
}
