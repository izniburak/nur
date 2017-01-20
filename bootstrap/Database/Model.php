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

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Nur\Database\Eloquent;

class Model extends EloquentModel
{
    public $timestamps = false;

    /**
    * Create Eloquent Model.
    *
    * @return null
    */
    function __construct()
    {
        $capsule = Eloquent::getInstance()->getCapsule();
        $schema = Eloquent::getInstance()->getSchema();
    }
}
