<?php
/**
* nur - a simple framework for PHP Developers
*
* @author   izni burak demirtaş (@izniburak) <izniburak@gmail.com>
* @web      <http://burakdemirtas.org>
* @url      <https://github.com/izniburak/nur>
* @license  The MIT License (MIT) - <http://opensource.org/licenses/MIT>
*/

namespace Nur\Blade;

use Nur\Blade\BladeRegister as BladeTemplate;

class Blade
{
    public static $class;
    private static $templateFolder = '/storage';

    /**
    * Class constructer and create Blade Template Engine. 
    *
    * @return null
    */
    public function __construct()
    {
        $cache = __DIR__ . '/../..' . self::$templateFolder . '/blade';

        if(!is_dir( realpath($cache) ))
            mkdir($cache, 0755);
        $views = realpath(__DIR__ . '/../../app/Views');

        self::$class = new BladeTemplate($views, $cache);
    }

    /**
    * instance of Class. 
    *
    * @return instance
    */
    public static function getInstance()
    {
        static $instance = null;

        if (null === $instance)
            $instance = new static();

        return $instance;
    }

    /**
    * Get class method call by static reference. 
    *
    * @return string | null
    */
    public static function __callstatic($name, $params)
    {
        self::$class->$name($params);
    }

    /**
    * Display view file. 
    *
    * @return false | null
    */
    public static function make($view = null, $data = [], $mergeData = [])
    {
        self::getInstance();
        if(($view))
            echo self::$class->view()->make($view, $data, $mergeData)->render();
        else
            return false;
    }

    public function __destruct()
    {
        self::$class = null;
    }
}
