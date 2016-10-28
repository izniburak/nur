<?php
/**
 * Mubu - A simple framework for PHP Developers
 *
 * @package  Mubu
 * @author   İzni Burak Demirtaş <izniburak@gmail.com>
 * @web      <http://burakdemirtas.org>
 */

namespace Mubu\Database;

use Illuminate\Database\Capsule\Manager as Capsule;
use Mubu\Database\Eloquent;

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
