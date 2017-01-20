<?php
/**
* nur - a simple framework for PHP Developers
*
* @author   izni burak demirtaş (@izniburak) <izniburak@gmail.com>
* @web      <http://burakdemirtas.org>
* @url      <https://github.com/izniburak/nur>
* @license  The MIT License (MIT) - <http://opensource.org/licenses/MIT>
*/

namespace Nur\Console\Commands\Remove;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class ControllerCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('remove:controller')
            ->addArgument('name', InputArgument::REQUIRED, 'The name for the controller.')
            ->setDescription('Remove a controller.')
            ->setHelp("This command makes you to remove controller...")
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');

        $file = getcwd() . '/app/Controllers/' . $name . '.php';

        if(file_exists($file))
        {
            unlink($file);

            $output->writeln(
                "\n" . ' <info>+Success!</info> "' . ($name) . '" controller removed.'
            );
        }
        else
        {
            $output->writeln(
                "\n" . ' <error>-Error!</error> Controller not found! ('.$name.')'
            );
        }

        return;
    }
}
