<?php
/**
 * Mubu - A simple framework for PHP Developers
 *
 * @package    Mubu
 * @author     İzni Burak Demirtaş <izniburak@gmail.com>
 * @web        <http://burakdemirtas.org>
 */

namespace Mubu\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Mubu\Exception\ExceptionHandler;

class CreateControllerCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('create:controller')
            ->addArgument('name', InputArgument::REQUIRED, 'The name for the controller.')
            ->addOption('--force', '-f', InputOption::VALUE_OPTIONAL, 'Force to re-create middleware.')
            ->setDescription('Create a new controller.')
            ->setHelp("This command makes you to create controller...")
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');
        $force = $input->hasParameterOption('--force');

        $file = getcwd() . '/app/Controllers/' . $name . '.php';

        if(!file_exists($file))
        {
            $this->createNewFile($file, $name);

            $output->writeln(
                "\n" . ' <info>+Success!</info> "' . ($name) . '" controller created.'
            );
        }
        else
        {
            if($force !== false)
            {
                unlink($file);
                $this->createNewFile($file, $name);

                $output->writeln(
                    "\n" . ' <info>+Success!</info> "' . ($name) . '" controller re-created.'
                );
            }
            else 
                throw new ExceptionHandler("File already exists! (".$name.")");
        }

        return;
    }

    private function createNewFile($file, $name)
    {
        $controller = ucfirst($name);
        $contents = <<<PHP
<?php

namespace App\Controllers;

use Mubu\Controller\Controller;

class $controller extends Controller
{
    function main()
    {

    }
}

PHP;

        if (false === file_put_contents($file, $contents)) 
        {
            throw new ExceptionHandler(sprintf(
                'The file "%s" could not be written to',
                $file
            ));
        }

        return;
    }
}
