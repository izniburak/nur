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

class CreateModelCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('create:model')
            ->addArgument('name', InputArgument::REQUIRED, 'The name for the model.')
            ->addOption('--table', '-t', InputOption::VALUE_OPTIONAL, 'The table name for model.')
            ->addOption('--force', '-f', InputOption::VALUE_OPTIONAL, 'Force to re-create model.')
            ->setDescription('Create a new model.')
            ->setHelp("This command makes you to create model...")
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');
        $force = $input->hasParameterOption('--force');
        $tableName = $input->hasParameterOption('--table');
        $table = '';

        if ($tableName) 
            $table = $input->getOption('table');

        $file = getcwd() . '/app/Models/' . $name . '.php';

        if(!file_exists($file))
        {
            $this->createNewFile($file, $name, $table);

            $output->writeln(
                "\n" . ' <info>+Success!</info> "' . ($name) . '" model created.'
            );
        }
        else
        {
            if($force !== false)
            {
                unlink($file);
                $this->createNewFile($file, $name, $table);

                $output->writeln(
                    "\n" . ' <info>+Success!</info> "' . ($name) . '" model re-created.'
                );
            }
            else 
                throw new ExceptionHandler("File already exists! (".$name.")");
        }

        return;
    }

    private function createNewFile($file, $name, $tableName = '')
    {
        $model = ucfirst($name);
        $table = 'protected $table = "'.$tableName.'";';
        $contents = <<<PHP
<?php

namespace App\Models;

use Mubu\Database\Model;

class $model extends Model
{
    $table

    function yourModelMethod()
    {
        return;
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
