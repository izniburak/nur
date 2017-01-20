<?php
/**
* nur - a simple framework for PHP Developers
*
* @author   izni burak demirtaş (@izniburak) <izniburak@gmail.com>
* @web      <http://burakdemirtas.org>
* @url      <https://github.com/izniburak/nur>
* @license  The MIT License (MIT) - <http://opensource.org/licenses/MIT>
*/

namespace Nur\Load;

use Nur\Exception\ExceptionHandler;

class Load
{
    private static $instance = null;
    public $library, $model = [];

    public function __construct() { }

    public static function __callStatic($method, $parameters)
    {
        return call_user_func_array([self::getInstance(), $method], $parameters);
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
        $name = ($name);
        $file = realpath(__DIR__ . '/../../app/Views/' . $name . '.php');

        if (file_exists($file))
        {
            if (is_array($data))
                extract($data);

            require $file;
        }
        else
            return new ExceptionHandler('Oppss! File not found.', '<b>View::' . $name . '</b> not found.');
    }

    /**
    * Load model controller file. 
    *
    * @return model | throw ExceptionHandler
    */
    public function model($name, $autoLoad = false)
    {
        $name = ($name);
        $class = ($autoLoad ? $name : 'App\Models\\' . $name);
        $file = realpath(__DIR__ . '/../../app/Models/' . $name . '.php');

        if (file_exists($file))
        {
            if(!class_exists($name))
                require $file;

            if (!isset($this->model[$name]))
                $this->model[$name] = new $class();

            return $this->model[$name];
        }
        else
            return new ExceptionHandler('Oppss! File not found.',  '<b>Model::' . $name . '</b> not found.');
    }

    /**
    * Load library class file. 
    *
    * @return library | throw ExceptionHandler
    */
    public function library($name, $params = null, $autoLoad = false)
    {
        $name = ($name);
        $class = ($autoLoad ? $name : 'App\Libraries\\' . $name);
        $file = realpath(__DIR__ . '/../../app/Libraries/' . $name . '.php');

        if (file_exists($file))
        {
            if(!class_exists($name))
                require $file;

            if (!isset($this->library[$name]) && is_null($params))
                $this->library[$name] = new $class();

            elseif(!isset($this->library[$name]) && !is_null($params))
                if(is_array($params))
                    $this->library[$name] = eval("\$a = new $class('" . implode("', '", $params) . "'); return \$a;");
                else
                    $this->library[$name] = new $class($params);

            return $this->library[$name];
        }
        else
            return new ExceptionHandler('Oppss! File not found.',  '<b>Library::' . $name . '</b> not found.');
    }

    /**
    * Load helper file. 
    *
    * @return null | throw ExceptionHandler
    */
    public static function helper($name)
    {
        $name = ($name);
        $file = realpath(__DIR__ . '/../../app/Helpers/' . $name . '.php');

        if (file_exists($file))
            require $file;
        else
            return new ExceptionHandler('Oppss! File not found.', '<b>Helper::' . $name . '</b> not found.');
    }

    public function __destruct()
    {
        $this->library = $this->model = [];
    }
}
