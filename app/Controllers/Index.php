<?php

namespace App\Controllers;

class Index extends Controller
{
    function main()
    {
        return blade('hello');
    }
}
