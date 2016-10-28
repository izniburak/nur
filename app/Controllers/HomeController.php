<?php

namespace App\Controllers;

use Mubu\Controller\Controller;

class HomeController extends Controller
{
  function main()
  {
    return blade('hello');
  }
}
