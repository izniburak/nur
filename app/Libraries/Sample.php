<?php
/**
* nur - a simple framework for PHP Developers
*
* @author   izni burak demirtaş (@izniburak) <izniburak@gmail.com>
* @web      <http://burakdemirtas.org>
* @url      <https://github.com/izniburak/nur>
* @license  The MIT License (MIT) - <http://opensource.org/licenses/MIT>
*/

# You can use this class example to write your own libraries.

namespace App\Libraries;

class Sample
{
    protected static $instance = null;

    /**
    * Call static function for class
    *
    * @return mixed
    */
    public static function __callStatic($method, $parameters)
    {
        return call_user_func_array([self::getInstance(), $method], $parameters);
    }

    /**
    * Instance of class.
    *
    * @return object | null
    */
    public static function getInstance()
    {
        if (is_null(self::$instance))
            self::$instance = new static();

        return self::$instance;
    }
}
