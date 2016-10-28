<?php
/**
 * Mubu - A simple framework for PHP Developers
 *
 * @package  Mubu
 * @author   İzni Burak Demirtaş <izniburak@gmail.com>
 * @web      <http://burakdemirtas.org>
 */

namespace Mubu\Error;

class Error
{
    function __construct() { }

    /**
    * Set Error Message and Display. 
    *
    * @return null
    */
    public static function message($msg = null, $page = null)
    {
        $message = is_null($msg) ? 'Oppss! System error. Please check your codes.' : $msg;

        if(is_null($page))
        {
            $file = '/app/views/errors/index.php';
            if (file_exists($file))
            {
                require $file;
                die();
            }
            else
                die($message);
        }
        else
        {
            $file = '/app/views/errors/' . $page . '.php';
            if (file_exists($file))
            {
                require $file;
                die();
            }

            else
                die($msg);
        }
    }
}
