<?php
/**
* nur - a simple framework for PHP Developers
*
* @author   izni burak demirtaş (@izniburak) <izniburak@gmail.com>
* @web      <http://burakdemirtas.org>
* @url      <https://github.com/izniburak/nur>
* @license  The MIT License (MIT) - <http://opensource.org/licenses/MIT>
*/

namespace Nur\Database;

use Illuminate\Database\Capsule\Manager as Capsule;
use Nur\Database\Eloquent;

Eloquent::getInstance()->getCapsule();

class Builder extends Capsule
{
    /**
    * Set Eloquent Capsule for Builder. 
    *
    * @return null
    */
    function __construct()
    {
        parent::__construct();
    }
}
