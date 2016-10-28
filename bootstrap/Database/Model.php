<?php
/**
 * Mubu - A simple framework for PHP Developers
 *
 * @package  Mubu
 * @author   İzni Burak Demirtaş <izniburak@gmail.com>
 * @web      <http://burakdemirtas.org>
 */

namespace Mubu\Database;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Mubu\Database\Eloquent;

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
