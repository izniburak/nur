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

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;

class Eloquent
{
    private static $instance = null;
    private static $capsule = null;
    private static $schema = null;

    /**
    * Create Eloquent Capsule. 
    *
    * @return null
    */
    function __construct()
    {
        $capsule = new Capsule;

        $config = getConfig();
        $capsule->addConnection($config['db']);

        // Set the event dispatcher used by Eloquent models... (optional)
        $capsule->setEventDispatcher(new Dispatcher(new Container));

        // Make this Capsule instance available globally via static methods... (optional)
        $capsule->setAsGlobal();

        // Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
        $capsule->bootEloquent();

        self::$capsule = $capsule;
        self::$schema = $capsule->schema();
    }

    /**
    * instance of Class.
    *
    * @return instance
    */
    public static function getInstance()
    {
        if (null === self::$instance)
            self::$instance = new static();

        return self::$instance;
    }

    /**
    * Get Eloquent Capsule. 
    *
    * @return object
    */
    public static function getCapsule()
    {
        return self::$capsule;
    }

    /**
    * Get Eloquent Schema. 
    *
    * @return object
    */
    public static function getSchema()
    {
        return self::$schema;
    }
}
