<?php
/**
 * nur - a simple framework for PHP Developers
 *
 * @author   izni burak demirtaş (@izniburak) <izniburak@gmail.com>
 * @web      <http://burakdemirtas.org>
 * @url      <https://github.com/izniburak/nur>
 * @license  The MIT License (MIT) - <http://opensource.org/licenses/MIT>
 */

ob_start();

// Autoload Dependencies
require_once __DIR__ . '/../vendor/autoload.php';

/** @var \Nur\Kernel\Application $app */
$app = require_once __DIR__ . '/../app/bootstrap.php';

$app->start(APP_ENV);
