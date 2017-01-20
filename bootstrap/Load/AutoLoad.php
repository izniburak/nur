<?php
/**
* nur - a simple framework for PHP Developers
*
* @author   izni burak demirtaş (@izniburak) <izniburak@gmail.com>
* @web      <http://burakdemirtas.org>
* @url      <https://github.com/izniburak/nur>
* @license  The MIT License (MIT) - <http://opensource.org/licenses/MIT>
*/

namespace Nur\Load;

use Nur\Load\Load;

class AutoLoad
{
    private static $instance = null;
    private $config = [];
    private $load;

    public function __construct()
    {
        global $config;

        $this->config = $config;
        $this->load = Load::getInstance();
        $this->helper(); $this->library(); $this->model();
    }

    /**
    * instance of Class 
    *
    * @return instance
    */
    public static function getInstance()
    {
        if (null === self::$instance)
            self::$instance = new static();

        return self::$instance;
    }

    /**
    * Auto load helper files.
    *
    * @return null
    */
    private function helper()
    {
        if (isset($this->config['autoload']['helper']))
            foreach ($this->config['autoload']['helper'] as $helper)
                $this->load->helper($helper);
    }

    /**
    * Auto load library class.
    *
    * @return null
    */
    private function library()
    {
        if (isset($this->config['autoload']['library']))
        {
            foreach ($this->config['autoload']['library'] as $key => $library)
            {
                if(is_array($library))
                    $this->load->library[$key] = $this->load->library($key, $library, true);

                else
                    if(!is_int($key))
                        $this->load->library[$key] = $this->load->library($key, $library, true);
                    else
                        $this->load->library[$library] = $this->load->library($library, null, true);
            }
        }
    }

    /**
    * Auto load model class. 
    *
    * @return null
    */
    private function model()
    {
        if (isset($this->config['autoload']['model']))
            foreach ($this->config['autoload']['model'] as $model)
                $this->load->model[$model] = $this->load->model($model, true);
    }

    function __destruct()
    {
        self::$instance = null;
        $this->config = $this->load = null;
    }
}
