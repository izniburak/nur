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
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Config\FileLocator;
use Nur\Console\Commands\Migrations\AbstractCommand;

class GenerateCommand extends AbstractCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        parent::configure();

        $this->setName('generate')
             ->addArgument('name', InputArgument::REQUIRED, 'The name for the migration')
             ->addArgument('path', InputArgument::OPTIONAL, 'The directory in which to put the migration ( optional if phpmig.migrations_path is setted )')
             ->setDescription('Generate a new migration')
             ->setHelp(<<<EOT
The <info>generate</info> command creates a new migration with the name and path specified

<info>migration:generate Dave Test</info>

EOT
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->bootstrap($input, $output);

        $path = $input->getArgument('path');
        $set = $input->getOption('set');
        if( null === $path ){
            if (isset($this->container['phpmig.migrations_path'])) {
                $path = $this->container['phpmig.migrations_path'];
            }
            if (isset($this->container['phpmig.sets']) && isset($this->container['phpmig.sets'][$set]['migrations_path'])) {
                $path = $this->container['phpmig.sets'][$set]['migrations_path'];
            }
        }
        $locator = new FileLocator(array());
        $path    = $locator->locate($path, getcwd(), $first = true);

        if (!is_writeable($path)) {
            throw new \InvalidArgumentException(sprintf(
                'The directory "%s" is not writeable',
                $path
            ));
        }

        $path = realpath($path);

        $migrationName = $this->transMigName($input->getArgument('name'));

        $basename  = date('YmdHis') . '_' . $migrationName . '.php';

        $path = $path . DIRECTORY_SEPARATOR . $basename;

        if (file_exists($path)) 
        {
            throw new \InvalidArgumentException(sprintf(
                'The file "%s" already exists',
                $path
            ));
        }

        $className = $this->migrationToClassName($migrationName);

        if (isset($this->container['phpmig.migrations_template_path'])) {
            $migrationsTemplatePath = $this->container['phpmig.migrations_template_path'];
            if (false === file_exists($migrationsTemplatePath)) {
                throw new \RuntimeException(sprintf(
                    'The template file "%s" not found',
                    $migrationsTemplatePath
                ));
            }

            if (preg_match('/\.php$/', $migrationsTemplatePath)) {
                ob_start();
                include($migrationsTemplatePath);
                $contents = ob_get_clean();
            } else {
                $contents = file_get_contents($migrationsTemplatePath);
                $contents = sprintf($contents, $className);
            }
        } else {
            $schema = '$this';
            $blueprint = '$table';
            $contents = <<<PHP
<?php

use Nur\Database\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;

class $className extends Migration
{
    /* Do the migration */
    public function up()
    {
        {$schema}->schema->create("", function(Blueprint $blueprint)
        {
            {$blueprint}->increments("id");
            
            {$blueprint}->timestamps();
            {$blueprint}->enum("status", [0, 1]);
        });
    }

    /* Undo the migration */
    public function down()
    {
        {$schema}->schema->drop("");
    }
}

PHP;
        }

        if (false === file_put_contents($path, $contents)) {
            throw new \RuntimeException(sprintf(
                'The file "%s" could not be written to',
                $path
            ));
        }

        $output->writeln(
            "\n" . ' <info>+Success!</info> ' .
            '"' . str_replace([getcwd(), 'app', 'Migrations', '/', '\\', '.php'], '', $path) . '" migration generated.'
        );

        return;
    }

    protected function transMigName($migrationName)
    {
        //http://php.net/manual/en/language.variables.basics.php
        if (preg_match('/[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*/', $migrationName)) {
            return $migrationName;
        }
        return 'mig' . $migrationName;
    }
}
