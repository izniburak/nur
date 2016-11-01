<?php
/**
 * Mubu - A simple framework for PHP Developers
 *
 * @package  Mubu
 * @author   İzni Burak Demirtaş <izniburak@gmail.com>
 * @web      <http://burakdemirtas.org>
 */

use Phpmig\Adapter,
    Pimple\Container,
    Illuminate\Database\Capsule\Manager as Capsule;

global $config;
require realpath(__DIR__ . '/../../../app/config.php');

$container = new Container();

$container['config'] = $config['db'];

$container['db'] = function ($c) {
    $capsule = new Capsule();
    $capsule->addConnection($c['config']);
    $capsule->setAsGlobal();
    $capsule->bootEloquent();

    return $capsule;
};

$container['phpmig.adapter'] = function($c) {
    return new Adapter\Illuminate\Database($c['db'], 'mubu_migrations');
};

$container['phpmig.migrations_path'] = realpath(__DIR__ . '/../../../app/Migrations');

$container['schema'] = function($c) {
    return $c['db']->schema();
};

return $container;
