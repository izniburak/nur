<?php
/**
* nur - a simple framework for PHP Developers
*
* @author   izni burak demirtaş (@izniburak) <izniburak@gmail.com>
* @web      <http://burakdemirtas.org>
* @url      <https://github.com/izniburak/nur>
* @license  The MIT License (MIT) - <http://opensource.org/licenses/MIT>
*/

namespace Nur\Console;

use Phpmig\Console\Command as MigrationCommand;

class Command
{
    protected $app;

    protected $commandList = [
        'Nur\Console\Commands\App\UpCommand',
        'Nur\Console\Commands\App\DownCommand',
        'Nur\Console\Commands\App\StatusCommand',
        'Nur\Console\Commands\App\ServeCommand',

        'Nur\Console\Commands\Make\ControllerCommand',
        'Nur\Console\Commands\Make\ModelCommand',
        'Nur\Console\Commands\Make\MiddlewareCommand',

        'Nur\Console\Commands\Database\CreateCommand',
        'Nur\Console\Commands\Database\RemoveCommand',
        'Nur\Console\Commands\Database\ListCommand',

        'Nur\Console\Commands\Remove\ControllerCommand',
        'Nur\Console\Commands\Remove\ModelCommand',
        'Nur\Console\Commands\Remove\MiddlewareCommand',
    ];

    protected $migrationCommands = [
        'Nur\Console\Commands\Migrations\CheckCommand',
        'Nur\Console\Commands\Migrations\DownCommand',
        'Nur\Console\Commands\Migrations\GenerateCommand',
        'Nur\Console\Commands\Migrations\MigrateCommand',
        'Nur\Console\Commands\Migrations\RedoCommand',
        'Nur\Console\Commands\Migrations\RollbackCommand',
        'Nur\Console\Commands\Migrations\StatusCommand',
        'Nur\Console\Commands\Migrations\UpCommand',
        'Nur\Console\Commands\Migrations\RemoveCommand',
    ];

    /**
    * Set console application. 
    *
    * @return null
    */
    function __construct($app)
    {
        $this->app = $app;

        $this->generate();
    }

    /**
    * Genereta all Command class. 
    *
    * @return null
    */
    public function generate()
    {
        foreach ($this->commandList as $key => $value)
        {
            $this->app->add( new $value );
        }

        foreach($this->migrationCommands as $command)
        {
            $newCommand = new $command;
            $newCommand->setName("migration:" . $newCommand->getName());
            $this->app->add( $newCommand );
            $newCommand = null;
        }
    }

    /**
    * Run console commands. 
    *
    * @return null
    */
    public function run()
    {
        $this->app->run();
        exit();
    }
}
