<?php
/**
* nur - a simple framework for PHP Developers
*
* @author   izni burak demirtaş (@izniburak) <izniburak@gmail.com>
* @web      <http://burakdemirtas.org>
* @url      <https://github.com/izniburak/nur>
* @license  The MIT License (MIT) - <http://opensource.org/licenses/MIT>
*/

namespace Nur\Http;

class Http
{
    protected static $value;

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

        $key = strtoupper($key);

        if(is_null($value))
            self::$value = (isset($_SERVER[$key]) ? $_SERVER[$key] : null);
        else
            $_SERVER[$key] = self::$value = $value;

        return self::$value;
    }


    /**
    * Get User IP Address. 
    *
    * @return string 
    */
    static function getUserIP()
    {
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = @$_SERVER['REMOTE_ADDR'];

        if(filter_var($client, FILTER_VALIDATE_IP))
            $ip = $client;
        elseif(filter_var($forward, FILTER_VALIDATE_IP))
            $ip = $forward;
        else
            $ip = $remote;

        return $ip;
    }

    /**
    * Filter method for HTTP Values. 
    *
    * @return string | null
    */
    protected static function filter($str = null, $filter = false)
    {
        if(is_null($str)) return null;

        if($filter)
            $str = htmlspecialchars($str, ENT_QUOTES, 'UTF-8');

        $str = trim($str);

        return $str;
    }
}
