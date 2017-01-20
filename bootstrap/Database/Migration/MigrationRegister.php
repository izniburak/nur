<?php
/**
* nur - a simple framework for PHP Developers
*
* @author   izni burak demirtaş (@izniburak) <izniburak@gmail.com>
* @web      <http://burakdemirtas.org>
* @url      <https://github.com/izniburak/nur>
* @license  The MIT License (MIT) - <http://opensource.org/licenses/MIT>
*/

use Phpmig\Adapter;
use Pimple\Container;
use Illuminate\Database\Capsule\Manager as Capsule;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;

try {
    $config = Yaml::parse(file_get_contents('app/config.yml'));
}
catch (ParseException $e) {
    die(printf("Unable to parse the Config YAML string. Error Message: %s", $e->getMessage()));
}

if($config['db']['driver'] == "sqlite")
    $config['db']['database'] = realpath(__DIR__ . '/../../../storage/database/'. $config['db']['database']);

$container = new Container();

$container['config'] = $config['db'];

$container['db'] = function ($c) {
    $capsule = new Capsule();
    $capsule->getContainer()->singleton(
        \Illuminate\Contracts\Debug\ExceptionHandler::class
        /* \Your\ExceptionHandler\Implementation::class */
    );
    $capsule->addConnection($c['config']);
    $capsule->setAsGlobal();
    $capsule->bootEloquent();

    return $capsule;
};

$container['phpmig.adapter'] = function($c) {
    return new Adapter\Illuminate\Database($c['db'], 'nur_migrations');
};

$container['phpmig.migrations_path'] = realpath(__DIR__ . '/../../../app/Migrations');

$container['schema'] = function($c) {
    return $c['db']->schema();
};

return $container;
