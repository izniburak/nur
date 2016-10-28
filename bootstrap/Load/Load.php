<?php
/**
 * Mubu - A simple framework for PHP Developers
 *
 * @package  Mubu
 * @author   İzni Burak Demirtaş <izniburak@gmail.com>
 * @web      <http://burakdemirtas.org>
 */

namespace Mubu\Load;

use Mubu\Exception\ExceptionHandler;

class Load
{
    private static $instance = null;
    public static $library, $model = [];

    public function __construct() { }

    public static function __callStatic($name, $val)
    {
        return self::${$name}($val[0], $val[1]);
    }

    /**
    * instance of Class
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
    * Load view file.
    *
    * @return null | throw ExceptionHandler
    */
    public static function view($name, $data = null)
    {
        $name = strtolower($name);
        $file = ROOT . '/app/views/' . $name . '.php';

        if (file_exists($file))
        {
            if (is_array($data))
                extract($data);

            require $file;
        }
        else
            throw new ExceptionHandler('<h2>Oppss! File Not Found.</h2> <b>View::' . $name . '</b> not found.');
    }

    /**
    * Load model controller file. 
    *
    * @return model | throw ExceptionHandler
    */
    public function model($name, $autoLoad = false)
    {
        $name = strtolower($name);
        $class = ($autoLoad ? $name : 'App\Models\\' . $name);
        $file = ROOT . '/app/models/' . $name . '.php';

        if (file_exists($file))
        {
            if(!class_exists($name))
                require $file;

            if (!isset(self::$model[$name]))
                self::$model[$name] = new $class();

            return self::$model[$name];
        }
        else
            throw new ExceptionHandler('<h2>Oppss! File Not Found.</h2> <b>Model::' . $name . '</b> not found.');
    }

    /**
    * Load library class file. 
    *
    * @return library | throw ExceptionHandler
    */
    public function library($name, $params = null, $autoLoad = false)
    {
        $name = strtolower($name);
        $class = ($autoLoad ? $name : 'App\Libraries\\' . $name);
        $file = ROOT . '/app/libraries/' . $name . '.php';

        if (file_exists($file))
        {
            if(!class_exists($name))
                require $file;

            if (!isset(self::$library[$name]) && is_null($params))
                self::$library[$name] = new $class();

            elseif(!isset(self::$library[$name]) && !is_null($params))

                if(is_array($params))
                    self::$library[$name] = eval("\$a = new $class('" . implode("', '", $params) . "'); return \$a;");
                else
                    self::$library[$name] = new $class($params);

            return self::$library[$name];
        }
        else
            throw new ExceptionHandler('<h2>Oppss! File Not Found.</h2> <b>Library::' . $name . '</b> not found.');
    }

    /**
    * Load helper file. 
    *
    * @return null | throw ExceptionHandler
    */
    public static function helper($name)
    {
        $name = strtolower($name);
        $file = ROOT . '/app/helpers/' . $name . '.php';

        if (file_exists($file))
            require $file;
        else
            throw new ExceptionHandler('<h2>Oppss! File Not Found.</h2> <b>Helper::' . $name . '</b> not found.');
    }

    public function __destruct()
    {
        self::$library = self::$model = [];
    }
}
