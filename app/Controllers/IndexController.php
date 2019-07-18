<?php

namespace App\Controllers;

class IndexController extends Controller
{
    /**
     * Main method for this controller.
     *
     * @return \Nur\Http\Response|string
     */
    function main()
    {
        return blade('hello');
    }
}
