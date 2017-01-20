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

class Cookie
{
    public function __construct() { }

    /**
    * Set cookie method. 
    *
    * @return null
    */
    public static function set($key, $value, $time = 0)
    {
        if(is_array($key))
        {
            foreach ($key as $k => $v)
            {
                setcookie($k, $v, ($time == 0 ? 0 : time() + $time), '/');
                $_COOKIE[$k] = $v;
            }
        }
        else
        {
            setcookie($key, $value, ($time == 0 ? 0 : time() + $time), '/');
            $_COOKIE[$key] = $value;
        }

        return;
    }

    /**
    * Get cookie method.
    *
    * @return null | cookie value
    */
    public static function get($key = null)
    {
        return (is_null($key) ? $_COOKIE : (isset($_COOKIE[$key]) ? $_COOKIE[$key] : null));
    }

    /**
    * Delete cookie method.
    *
    * @return null
    */
    public static function delete($key)
    {
        if(isset($_COOKIE[$key]))
        {
            setcookie($key, null, -1, '/');
            unset($_COOKIE[$key]);
        }

        return;
    }

    /**
    * Delete all cookie method. 
    *
    * @return null
    */
    public static function destroy()
    {
        foreach ($_COOKIE as $k => $v)
        {
            setcookie($k, null, -1, '/');
            unset($_COOKIE[$k]);
        }

        return;
    }
}
