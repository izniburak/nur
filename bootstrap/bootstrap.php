<?php
/**
 * Mubu - A simple framework for PHP Developers
 *
 * @package  Mubu
 * @author   İzni Burak Demirtaş <izniburak@gmail.com>
 * @web      <http://burakdemirtas.org>
 */

use Mubu\Http\Http;
use Mubu\Http\Session;
use Mubu\Load\AutoLoad;
use Mubu\Uri\Uri;

ob_start();
session_start();

global $config;
require_once 'app/config.php';

define('MUBU_VERSION', '1.0');
define('BASE_FOLDER', trim($config['folder'], '/'));
define('ADMIN_FOLDER', trim($config['admin'], '/'));
define('MODE', strtolower($config['mode']));
define('IP_ADDRESS', http::server('REMOTE_ADDR'));
define('ROOT', http::server('DOCUMENT_ROOT') . (BASE_FOLDER == '' ? '' : '/' . BASE_FOLDER));
define('APP_KEY', $config['key']);

switch (MODE)
{
    case 'development':
        ini_set('display_errors', 1);
        break;
    case 'testing':
    case 'production':
        ini_set('display_errors', 0);
        if (version_compare(PHP_VERSION, '5.3', '>='))
            error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
        else
            error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_USER_NOTICE);
        break;
    default:
        header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
        die('The application environment is not set correctly.');
}

date_default_timezone_set($config['timezone']);

if(empty(session::get('_token')))
    session::set('_token', $config['_token']);

define('_TOKEN', session::get('_token'));

require_once ROOT . '/bootstrap/route/route.php';

AutoLoad::getInstance();
Uri::getInstance();

require_once ROOT . '/app/routes.php';
Route::run();

ob_end_flush();
