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
    Mubu\Console\Commands\Migrations\AbstractCommand;;

/**
 * This file is part of phpmig
 *
 * Copyright (c) 2011 Dave Marshall <dave.marshall@atstsolutuions.co.uk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Down command
 *
 * @author      Dave Marshall <david.marshall@atstsolutions.co.uk>
 */
class DownCommand extends AbstractCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        parent::configure();

        $this->setName('down')
             ->addArgument('version', InputArgument::REQUIRED, 'The version number for the migration')
             ->setDescription('Revert a specific migration')
             ->setHelp(<<<EOT
The <info>down</info> command reverts a specific migration

<info>migration:down 20111018185412</info>

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

        if (!in_array($version, $versions)) {
            return;
        }

        if (!isset($migrations[$version])) {
            return;
        }

        $container = $this->getContainer();
        $container['phpmig.migrator']->down($migrations[$version]);
    }
}
