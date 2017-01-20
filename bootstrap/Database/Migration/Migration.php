<?php
/**
* nur - a simple framework for PHP Developers
*
* @author   izni burak demirtaş (@izniburak) <izniburak@gmail.com>
* @web      <http://burakdemirtas.org>
* @url      <https://github.com/izniburak/nur>
* @license  The MIT License (MIT) - <http://opensource.org/licenses/MIT>
*/

namespace Nur\Database\Migration;

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
