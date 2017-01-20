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

class MigrateCommand extends AbstractCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        parent::configure();

        $this->setName('migrate')
             ->addOption('--target', '-t', InputArgument::OPTIONAL, 'The version number to migrate to')
             ->setDescription('Run all migrations')
             ->setHelp(<<<EOT
The <info>migrate</info> command runs all available migrations, optionally up to a specific version

<info>migration:migrate</info>
<info>migration:migrate -t 20111018185412</info>

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

        $version = $input->getOption('target');

        ksort($migrations);
        sort($versions);

        if (!empty($versions)) {
            // Get the last run migration number
            $current = end($versions);
        } else {
            $current = 0;
        }

        if (null !== $version) {
            if (0 != $version && !isset($migrations[$version])) {
                return;
            }
        } else {
            $versionNumbers = array_merge($versions, array_keys($migrations));

            if (empty($versionNumbers)) {
                return;
            }

            $version = max($versionNumbers);
        }

        $direction = $version > $current ? 'up' : 'down';

        if ($direction == 'down') {
            /**
             * Run downs first
             */
            krsort($migrations);
            foreach($migrations as $migration) {
                if ($migration->getVersion() <= $version) {
                    break;
                }

                if (in_array($migration->getVersion(), $versions)) {
                    $container = $this->getContainer();
                    $container['phpmig.migrator']->down($migration);
                }
            }
        }

        ksort($migrations);
        foreach($migrations as $migration) {
            if ($migration->getVersion() > $version) {
                break;
            }

            if (!in_array($migration->getVersion(), $versions)) {
                $container = $this->getContainer();
                $container['phpmig.migrator']->up($migration);
            }
        }
    }
}
