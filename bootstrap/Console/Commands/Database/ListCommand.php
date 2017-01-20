<?php
/**
* nur - a simple framework for PHP Developers
*
* @author   izni burak demirtaş (@izniburak) <izniburak@gmail.com>
* @web      <http://burakdemirtas.org>
* @url      <https://github.com/izniburak/nur>
* @license  The MIT License (MIT) - <http://opensource.org/licenses/MIT>
*/

namespace Nur\Console\Commands\Database;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('database:list')
            ->setDescription('List all sqlite databases.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dir = $mask = getcwd() . "/storage/database/";
        $mask = $dir . "*.sqlite*";
        $dbList = glob($mask);

        if(count($dbList) > 0)
        {
            $output->writeln("");
            $output->writeln("        Database Name         Size           Time");
            $output->writeln(" -----------------------------------------------------");

            foreach ($dbList as $file) 
            {
                $mb = false;
                $filesize = (filesize($file) / 1024);
                if($filesize > 1024)
                {
                    $filesize = ($filesize / 1024);
                    $mb = true;
                }

                $output->writeln(
                    sprintf(
                        " %20s  %11.3f".($mb ? 'MB' : 'KB')."  %17s",
                        str_replace($dir, '', $file),
                        $filesize,
                        date("d.m.Y", filemtime($file))
                    )
                );
            }
        }
        else 
            $output->writeln(
                "\n" . ' No SQLite databases yet. '
            );


        return;
    }
}
