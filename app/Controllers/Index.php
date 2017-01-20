<?php

namespace App\Controllers;

use Nur\Controller\Controller;

class Index extends Controller
{
    function main()
    {
        return blade('hello');
    }

    function test()
    {
        return false;
    }

    function foo($bar, $ber = 1, $bor = 1)
    {
        return $bar;
    }
}
