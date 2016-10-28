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

class CreateMiddlewareCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('create:middleware')
            ->addArgument('name', InputArgument::REQUIRED, 'The name for the middleware.')
            ->addOption('--force', '-f', InputOption::VALUE_OPTIONAL, 'Force to re-create middleware.')
            ->setDescription('Create a new middleware.')
            ->setHelp("This command makes you to create middleware...")
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');
        $force = $input->hasParameterOption('--force');

        $file = getcwd() . '/app/Middlewares/' . $name . '.php';

        if(!file_exists($file))
        {
            $this->createNewFile($file, $name);

            $output->writeln(
                "\n" . ' <info>+Success!</info> "' . ($name) . '" middleware created.'
            );
        }
        else
        {
            if($force !== false)
            {
                unlink($file);
                $this->createNewFile($file, $name);

                $output->writeln(
                    "\n" . ' <info>+Success!</info> "' . ($name) . '" middleware re-created.'
                );
            }
            else 
                throw new ExceptionHandler("File already exists! (".$name.")");
        }

        return;
    }

    private function createNewFile($file, $name)
    {
        $middleware = ucfirst($name);
        $contents = <<<PHP
<?php

namespace App\Middlewares;

use Mubu\Middleware\Middleware;

class $middleware extends Middleware
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
