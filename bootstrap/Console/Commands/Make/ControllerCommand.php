<?php
/**
* nur - a simple framework for PHP Developers
*
* @author   izni burak demirtaş (@izniburak) <izniburak@gmail.com>
* @web      <http://burakdemirtas.org>
* @url      <https://github.com/izniburak/nur>
* @license  The MIT License (MIT) - <http://opensource.org/licenses/MIT>
*/

namespace Nur\Console\Commands\Make;

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
            ->setName('make:controller')
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
                $output->writeln(
                    "\n" . ' <error>-Error!</error> Controller already exists! ('.$name.')'
                );
        }

        return;
    }

    private function createNewFile($file, $name)
    {
        $controller = ucfirst($name);
        $contents = <<<PHP
<?php

namespace App\Controllers;

use Nur\Controller\Controller;

class $controller extends Controller
{
    function main()
    {

    }
}

PHP;

        if (false === file_put_contents($file, $contents)) 
            throw new \RuntimeException( sprintf('The file "%s" could not be written to', $file) );

        return;
    }
}
