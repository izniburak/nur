<?php
/**
* nur - a simple framework for PHP Developers
*
* @author   izni burak demirtaş (@izniburak) <izniburak@gmail.com>
* @web      <http://burakdemirtas.org>
* @url      <https://github.com/izniburak/nur>
* @license  The MIT License (MIT) - <http://opensource.org/licenses/MIT>
*/

namespace Nur\Uri;

use Nur\Http\Http;
use Route;

class Uri
{
    protected static $instance = null;
    protected static $base = null;
    protected static $url = null;
    protected static $http = 'http://';

    /**
    * Create URI class values. 
    *
    * @return string | null
    */
    function __construct()
    {
        if(!is_null(self::$instance))
            return;

        self::$base = BASE_FOLDER;
        
        self::$url = http::server('HTTP_HOST') . '/' . self::$base . '/';
        if((!empty(http::server('HTTPS')) && http::server('HTTPS') !== 'off') || http::server('SERVER_PORT') == 443)
            self::$http = 'https://';
    }

    public static function __callStatic($method, $args)
    {
        $name = str_replace('ssl', '', strtolower($method));
        self::$http = 'https://';
        return self::$name(($args ? $args[0] : null));
    }

    /**
    * instance of Class. 
    *
    * @return string | null
    */
    public static function getInstance()
    {
        if (null === self::$instance)
            self::$instance = new static();

        return self::$instance;
    }

    /**
    * Get base url for app. 
    *
    * @return string
    */
    public static function base($data = null)
    {
        $data = (!is_null($data)) ? self::$url . $data : self::$url . '/';
        return self::$http . self::replace($data);
    }

    /**
    * Get admin url for app. 
    *
    * @return string
    */
    public static function admin($data = null)
    {
        $data = (!is_null($data)) ? self::$url . '/' . ADMIN_FOLDER . '/' . $data : self::$url . '/' . ADMIN_FOLDER . '/';
        return self::$http . self::replace($data);
    }

    /**
    * Get route uri value with params. 
    *
    * @return string
    */
    public static function route($name, $params = null)
    {
        $routes = Route::getRoutes();
        $found = false;

        foreach ($routes as $key => $value)
        {
            if($value['alias'] == $name)
            {
                $found = true;
                break;
            }
        }

        if($found)
        {
            if(strstr($routes[$key]['route'], '{'))
            {
                $segment = explode('/', $routes[$key]['route']);
                $i = 0;
                foreach ($segment as $key => $value)
                {
                    if(strstr($value, '{'))
                    {
                        $segment[$key] = $params[$i];
                        $i++;
                    }
                }
                $newUrl = implode('/', $segment);
            }
            else
                $newUrl = $routes[$key]['route'];

            $data = str_replace(self::$base, '', self::$url) . '/' . $newUrl;
            return self::$http . self::replace($data);
        }
        else
            return self::$http . self::replace(self::$url);
    }

    /**
    * Get assets directory for app. 
    *
    * @return string
    */
    public static function assets($data = null)
    {
        $data = (!is_null($data)) ? self::$url . '/assets/' . $data : self::$url . '/assets/';
        return self::$http . self::replace($data);
    }

    /**
    * Redirect to another URL. 
    *
    * @return null
    */
    public static function redirect($data = null)
    {
        if(substr($data, 0, 4) == 'http' || substr($data, 0, 5) == 'https')
            header('Location: ' . $data, true, 302);
        else
        {
            $data = (!is_null($data)) ? self::$url . '/' . $data : self::$url;
            header('Location: ' . self::$http . self::replace($data), true, 302);
        }

        die();
    }

    /**
    * Get active URI. 
    *
    * @return string | null
    */
    public static function current()
    {
        return self::$http . http::server('HTTP_HOST') . http::server('REQUEST_URI');
    }

    /**
    * Get segments of URI. 
    *
    * @return string | null
    */
    public static function segment($num = null)
    {
        if ( is_null(http::server('REQUEST_URI')) || is_null(http::server('SCRIPT_NAME')) )
            return null;

        if (!is_null($num))
        {
            $uri = self::replace( str_replace(self::$base, '', http::server('REQUEST_URI')) );
            $uriA = explode('/', $uri);
            return (isset($uriA[$num]) ? $uriA[$num] : null);
        }
        else
            return null;
    }

    /**
    * Replace. 
    *
    * @return string | null
    */
    private static function replace($data)
    {
        return str_replace(array('///', '//'), '/', $data);
    }
}
