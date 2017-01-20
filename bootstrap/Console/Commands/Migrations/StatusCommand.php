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
use Symfony\Component\Console\Output\OutputInterface;
use Nur\Console\Commands\Migrations\AbstractCommand;

class StatusCommand extends AbstractCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        parent::configure();

        $this->setName('status')
             ->setDescription('Show the up/down status of all migrations')
             ->setHelp(<<<EOT
The <info>status</info> command prints a list of all migrations, along with their current status

EOT
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->bootstrap($input, $output);
        $output->writeln("");
        $output->writeln(" Status   Migration ID    Migration Name ");
        $output->writeln("-----------------------------------------");

        $versions = $this->getAdapter()->fetchAll();
        foreach($this->getMigrations() as $migration) {

            if (in_array($migration->getVersion(), $versions)) {
                $status = "     <info>up</info> ";
                unset($versions[array_search($migration->getVersion(), $versions)]);
            } else {
                $status = "   <error>down</error> ";
            }

            $output->writeln(
                $status .
                sprintf(" %14s ", $migration->getVersion()) .
                " <comment>" . $migration->getName() . "</comment>"
            );
        }

        foreach($versions as $missing) {
            $output->writeln(
                '    <error>up</error> ' .
                sprintf("  %14s ", $missing) .
                ' <error>** MISSING **</error> '
            );
        }

        // print status
        $output->writeln("");
        return;
    }
}
