<?php

namespace App\Controllers;

use Nur\Controller\Controller;

class Index extends Controller
{
    function main()
    {
        return blade('hello');
    }
}
