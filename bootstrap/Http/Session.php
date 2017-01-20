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

class Session
{
    public function __construct() { }

    /**
    * Set session method. 
    *
    * @return null
    */
    public static function set($key, $value)
    {
        if(is_array($key))
            foreach ($key as $k => $v)
                $_SESSION[$k] = $v;
        else
            $_SESSION[$key] = $value;

        return;
    }

    /**
    * Get session method. 
    *
    * @return null | session value
    */
    public static function get($key = null)
    {
        return (is_null($key) ? $_SESSION : (isset($_SESSION[$key]) ? $_SESSION[$key] : null));
    }

    /**
    * Delete session method. 
    *
    * @return null
    */
    public static function delete($key)
    {
        if(isset($_SESSION[$key]))
            unset($_SESSION[$key]);

        return;
    }

    /**
    * Delete all session method. 
    *
    * @return null
    */
    public static function destroy()
    {
        $_SESSION = [];
        session_destroy();
        return;
    }

    /**
    * Get Session ID 
    *
    * @return string; session id
    */
    public static function id()
    {
        return session_id();
    }
}
