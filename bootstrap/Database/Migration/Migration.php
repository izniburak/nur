<?php
/**
 * Mubu - A simple framework for PHP Developers
 *
 * @package  Mubu
 * @author   İzni Burak Demirtaş <izniburak@gmail.com>
 * @web      <http://burakdemirtas.org>
 */

namespace Mubu\Database\Migration;

use Phpmig\Migration\Migration as BaseMigration;

class Migration extends BaseMigration
{
    protected $schema;

    /**
    * Initialize for Migration Class. 
    *
    * @return null
    */
    public function init()
    {
        $this->schema = $this->get('schema');
    }
}
