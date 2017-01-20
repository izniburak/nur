<?php
/**
* nur - a simple framework for PHP Developers
*
* @author   izni burak demirtaş (@izniburak) <izniburak@gmail.com>
* @web      <http://burakdemirtas.org>
* @url      <https://github.com/izniburak/nur>
* @license  The MIT License (MIT) - <http://opensource.org/licenses/MIT>
*/

use Nur\Router\Router as RouterProvider;
use Nur\Exception\ExceptionHandler;

class Route
{
    /**
    * Class instance variable
    */
    private static $instance = null; 

    /**
    * Call static function for Route Class
    *
    * @return mixed
    */
    public static function __callStatic($method, $parameters)
    {
        return call_user_func_array([self::getInstance(), $method], $parameters);
    }

    /**
    * Get class instance
    *
    * @return RouterObject
    */
    public static function getInstance()
    {
        if(file_exists(ROOT . "/app.down"))
            throw new ExceptionHandler("The system is under maintenance.", "We will be back very soon.");

        if (null === self::$instance)
        {
            self::$instance = new RouterProvider(
            [
                'paths' => [
                    'controllers' => 'app/Controllers/',
                    'middlewares' => 'app/Middlewares/'
                ],
                'namespaces' => [
                    'controllers' => 'App\\Controllers',
                    'middlewares' => 'App\\Middlewares'
                ]
            ]);
        }

        return self::$instance;
    }
}
