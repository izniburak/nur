<?php
/**
 * Mubu - A simple framework for PHP Developers
 *
 * @package  Mubu
 * @author   İzni Burak Demirtaş <izniburak@gmail.com>
 * @web      <http://burakdemirtas.org>
 */

# Application Routes file.

Route::get('/', function() 
{
  view('index');
});

Route::get('/controller', 'HomeController@main');
