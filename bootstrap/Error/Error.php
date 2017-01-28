<?php
/**
* nur - a simple framework for PHP Developers
*
* @author   izni burak demirtaş (@izniburak) <izniburak@gmail.com>
* @web      <http://burakdemirtas.org>
* @url      <https://github.com/izniburak/nur>
* @license  The MIT License (MIT) - <http://opensource.org/licenses/MIT>
*/

namespace Nur\Error;

use Nur\Uri\Uri;

class Error
{
    function __construct() { }

    /**
    * Set Error Message and Display. 
    *
    * @return null
    */
    public static function message($title = null, $msg = null, $page = null)
    {
        $title = is_null($title) ? 'Oppss! System Error. ' : $title;
        $message = is_null($msg) ? 'Please check your codes.' : $msg;
        $page = is_null($page) ? 'index' : $page;
        $baseUrl = Uri::base();

        $file = realpath(ROOT . '/app/Views/errors/' . $page . '.php');
        if (file_exists($file))
        {
            require $file;
            die();
        }
        else
            die('<h2>' . $title . '</h2> ' . $message);
    }
}
