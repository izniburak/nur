<?php
/**
 * Mubu - A simple framework for PHP Developers
 *
 * @package  Mubu
 * @author   İzni Burak Demirtaş <izniburak@gmail.com>
 * @web      <http://burakdemirtas.org>
 */

namespace Mubu\Http;

class Http
{
    private static $value;

    /**
    * Set or Get HTTP POST method. 
    *
    * @return string | null
    */
    public static function post($key = null, $value = null, $filter = false)
    {
        if(is_null($key)) return $_POST;

        if(is_null($value))
            self::$value = (isset($_POST[$key]) ? $_POST[$key] : null);
        else
            $_POST[$key] = self::$value = $value;

        return self::filter(self::$value, $filter);
    }

    /**
    * Set or Get HTTP GET method. 
    *
    * @return string | null
    */
    public static function get($key = null, $value = null, $filter = false)
    {
        if(is_null($key)) return $_GET;

        if(is_null($value))
            self::$value = (isset($_GET[$key]) ? $_GET[$key] : null);
        else
            $_GET[$key] = self::$value = $value;

        return self::filter(self::$value, $filter);
    }

    /**
    * Set or Get HTTP REQUEST method. 
    *
    * @return string | null
    */
    public static function request($key = null, $value = null, $filter = false)
    {
        if(is_null($key)) return $_REQUEST;

        if(is_null($value))
            self::$value = (isset($_REQUEST[$key]) ? $_REQUEST[$key] : null);
        else
            $_REQUEST[$key] = self::$value = $value;

        return self::filter(self::$value, $filter);
    }

    /**
    * Get HTTP FILES method. 
    *
    * @return string | null
    */
    public static function files($key = null, $name = null)
    {
        if(is_null($key)) return $_FILES;

        if (isset($_FILES[$key]))
        {
            if (!is_null($name))
                return $_FILES[$key][$name];
            else
                return $_FILES[$key];
        }

        return;
    }

    /**
    * Get HTTP SERVER method. 
    *
    * @return string | null
    */
    public static function server($key = null, $value = null)
    {
        if(is_null($key)) return $_SERVER;

        if(is_null($value))
            self::$value = (isset($_SERVER[$key]) ? $_SERVER[$key] : null);
        else
            $_SERVER[$key] = self::$value = $value;

        return self::$value;
    }

    /**
    * Filter method for HTTP Values. 
    *
    * @return string | null
    */
    private static function filter($str = null, $filter = false)
    {
        if(is_null($str)) return null;

        if($filter)
            $str = htmlspecialchars($str, ENT_QUOTES, 'UTF-8');

        $str = trim($str);

        return $str;
    }
}
