<?php
/**
 * Mubu - A simple framework for PHP Developers
 *
 * @package  Mubu
 * @author   İzni Burak Demirtaş <izniburak@gmail.com>
 * @web      <http://burakdemirtas.org>
 */

namespace Mubu\Console;

use Phpmig\Console\Command as MigrationCommand;

class Command
{
    protected $app;

    protected $commandList = [
        'Mubu\Console\Commands\App\UpCommand',
        'Mubu\Console\Commands\App\DownCommand',
        'Mubu\Console\Commands\App\StatusCommand',

        'Mubu\Console\Commands\Make\ControllerCommand',
        'Mubu\Console\Commands\Make\ModelCommand',
        'Mubu\Console\Commands\Make\MiddlewareCommand',

        'Mubu\Console\Commands\Database\CreateCommand',
        'Mubu\Console\Commands\Database\RemoveCommand',
        'Mubu\Console\Commands\Database\ListCommand',

        'Mubu\Console\Commands\Remove\ControllerCommand',
        'Mubu\Console\Commands\Remove\ModelCommand',
        'Mubu\Console\Commands\Remove\MiddlewareCommand',
    ];

    protected $migrationCommands = [
        'Mubu\Console\Commands\Migrations\CheckCommand',
        'Mubu\Console\Commands\Migrations\DownCommand',
        'Mubu\Console\Commands\Migrations\GenerateCommand',
        'Mubu\Console\Commands\Migrations\MigrateCommand',
        'Mubu\Console\Commands\Migrations\RedoCommand',
        'Mubu\Console\Commands\Migrations\RollbackCommand',
        'Mubu\Console\Commands\Migrations\StatusCommand',
        'Mubu\Console\Commands\Migrations\UpCommand',
        'Mubu\Console\Commands\Migrations\RemoveCommand',
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
