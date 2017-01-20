<?php
/**
* nur - a simple framework for PHP Developers
*
* @author   izni burak demirtaş (@izniburak) <izniburak@gmail.com>
* @web      <http://burakdemirtas.org>
* @url      <https://github.com/izniburak/nur>
* @license  The MIT License (MIT) - <http://opensource.org/licenses/MIT>
*/

namespace Nur\Database;

use Buki\Pdox as QueryProvider;

class Sql
{
    /**
    * Class instance variable
    */
    private static $instance = null; 

    /**
    * Call static function for Pdox Class
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
    * @return PdoxObject
    */
    public static function getInstance()
    {
        if (null === self::$instance)
        {
            $config = getConfig();
            $config['db']['cachedir'] = realpath(__DIR__ . '/../../storage/cache/sql/');
            if($config['db']['driver'] == "sqlite")
                $config['db']['database'] = realpath(__DIR__ . '/../../storage/database/'. $config['db']['database']);

            self::$instance = new QueryProvider($config['db']);
        }

        return self::$instance;
    }
}
