<?php

namespace Mubu\Exception;

use Exception;
use Mubu\Error\Error;

class ExceptionHandler extends Exception
{
    /**
    * Create Exception Class. 
    *
    * @return string | null
    */
    public function __construct($message)
    {
        //parent::__construct($message);
        Error::message($message);
    }

    public function __toString()
    {
        return $this->getMessage();
    }
}
