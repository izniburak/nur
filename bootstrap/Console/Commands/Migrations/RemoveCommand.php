<?php
/**
 * Mubu - A simple framework for PHP Developers
 *
 * @package    Mubu
 * @author     İzni Burak Demirtaş <izniburak@gmail.com>
 * @web        <http://burakdemirtas.org>
 */
 
namespace Mubu\Console\Commands\Migrations;

use Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Input\InputArgument,
    Symfony\Component\Console\Output\OutputInterface,
    Symfony\Component\Config\FileLocator,
    Mubu\Console\Commands\Migrations\AbstractCommand;

/**
 * This file is part of phpmig
 *
 * Copyright (c) 2011 Dave Marshall <dave.marshall@atstsolutuions.co.uk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Up command
 *
 * @author      Dave Marshall <david.marshall@atstsolutions.co.uk>
 */
class RemoveCommand extends AbstractCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        parent::configure();

        $this->setName('remove')
             ->addArgument('version', InputArgument::REQUIRED, 'The version number for the migration')
             ->setDescription('Remove a specific migration')
             ->setHelp(<<<EOT
The <info>up</info> command removes a specific migration

EOT
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->bootstrap($input, $output);

        $migrations = $this->getMigrations();
        $versions   = $this->getAdapter()->fetchAll();

        $version = $input->getArgument('version');

        if (in_array($version, $versions)) {
            $output->writeLn("\n" . ' <error>-Error!</error> "' . ($version) . '" migration is active. Please down it.');
            return;
        }

        if (!isset($migrations[$version])) {
            return;
        }
        
        $mask = getcwd() . '/app/Migrations/' . $version . "_*.php";
        array_map("unlink", glob($mask));
        $output->writeLn("\n" . ' <info>+Success!</info> "' . ($version) . '" migration removed.');

        /*
        $container = $this->getContainer();
        $container['phpmig.migrator']->up($migrations[$version]);

        $delete = $this->getContainer()['db']->table('mubu_migrations')->where('version', $version)->delete();
        if($delete)
        {
            $mask = getcwd() . '/app/Migrations/' . $version . "_*.php";
            array_map("unlink", glob($mask));
            $output->writeLn("\n" . ' <info>+Success!</info> "' . ($version) . '" migration removed.');
        }
        else 
            $output->writeLn("\n" . ' <danger>+Error!</danger> "' . ($version) . '" migration not found.');
        */
    }
}
