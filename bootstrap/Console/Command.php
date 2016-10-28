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
        'Mubu\Console\Commands\CreateControllerCommand',
        'Mubu\Console\Commands\CreateModelCommand',
        'Mubu\Console\Commands\CreateMiddlewareCommand',
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
