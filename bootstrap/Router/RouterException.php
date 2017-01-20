<?php
/**
* nur - a simple framework for PHP Developers
*
* @author   izni burak demirtaş (@izniburak) <izniburak@gmail.com>
* @web      <http://burakdemirtas.org>
* @url      <https://github.com/izniburak/nur>
* @license  The MIT License (MIT) - <http://opensource.org/licenses/MIT>
*/
 
namespace Nur\Router;

use Nur\Exception\ExceptionHandler;

class RouterException extends ExceptionHandler
{
    /**
    * Create Exception Class.
    *
    * @return string | Exception
    */
    public function __construct($message)
    {
        parent::__construct("Opps! 404 Not Found.", $message);
    }
}
