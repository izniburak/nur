<?php
/**
* nur - a simple framework for PHP Developers
*
* @author   izni burak demirtaş (@izniburak) <izniburak@gmail.com>
* @web      <http://burakdemirtas.org>
* @url      <https://github.com/izniburak/nur>
* @license  The MIT License (MIT) - <http://opensource.org/licenses/MIT>
*/

namespace Nur\Exception;

use Exception;
use Nur\Error\Error;

class ExceptionHandler 
{
    /**
    * Create Exception Class. 
    *
    * @return string | null
    */
    public function __construct($title, $message)
    {
        $debug = (APP_MODE == 'production' ? false : true);

        if($debug)
            throw new Exception(strip_tags($title . ' - ' . $message), 1);
        else
            Error::message($title, $message);
    }
}
