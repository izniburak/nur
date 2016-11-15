<?php
/**
 * Mubu - A simple framework for PHP Developers
 *
 * @package    Mubu
 * @author     İzni Burak Demirtaş <izniburak@gmail.com>
 * @web        <http://burakdemirtas.org>
 */

namespace Mubu\Console\Commands\Database;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Mubu\Exception\ExceptionHandler;

class CreateCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('database:create')
            ->addArgument('name', InputArgument::REQUIRED, 'The name for the database.')
            ->addOption('--type', '-t', InputOption::VALUE_OPTIONAL, 'The type for database.')
            ->addOption('--force', '-f', InputOption::VALUE_OPTIONAL, 'Force to re-create database file.')
            ->setDescription('Create a sqlite database.')
            ->setHelp("This command makes you to create sqlite or sqlite3 database...")
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');
        $force = $input->hasParameterOption('--force');
        $type = $input->hasParameterOption('--type');

        $databaseType = ($type) ? $input->getOption('type') : 'sqlite';

        $file = getcwd() . '/storage/database/' . $name . '.' . $databaseType;

        if(!file_exists($file))
        {
            touch($file);

            $output->writeln(
                "\n" . ' <info>+Success!</info> "' . ($name) . '" '.$databaseType.' database created.'
            );
        }
        else
        {
            if($force !== false)
            {
                unlink($file);
                touch($file);

                $output->writeln(
                    "\n" . ' <info>+Success!</info> "' . ($name) . '" '.$databaseType.' database re-created.'
                );
            }
            else 
                $output->writeln(
                    "\n" . ' <error>-Error!</error> Database already exists! ('.$name.'.'.$databaseType.')'
                );
        }

        return;
    }
}
