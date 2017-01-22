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

use Nur\Router\RouterCommand;
use Nur\Router\RouterException;

class Router extends \Buki\Router
{
    /**
    * Router constructer method.
    *
    * @return
    */
    function __construct($params = [])
    {
        parent::__construct($params);
    }

    /**
	* Throw new Exception for Router Error
	*
	* @return RouterException
	*/
	public function exception($message = '')
	{
		return new RouterException($message);
	}

    /**
	* RouterCommand class
	*
	* @return RouterCommand
	*/
	public function routerCommand($message = '')
	{
		return RouterCommand::getInstance();
	}
}
