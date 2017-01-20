<?php
/**
* nur - a simple framework for PHP Developers
*
* @author   izni burak demirtaş (@izniburak) <izniburak@gmail.com>
* @web      <http://burakdemirtas.org>
* @url      <https://github.com/izniburak/nur>
* @license  The MIT License (MIT) - <http://opensource.org/licenses/MIT>
*/

namespace Nur\Console\Commands\Migrations;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Config\FileLocator;
use Nur\Console\Commands\Migrations\AbstractCommand;

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

        $delete = $this->getContainer()['db']->table('nur_migrations')->where('version', $version)->delete();
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
