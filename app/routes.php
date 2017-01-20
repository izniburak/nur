<?php
/**
* nur - a simple framework for PHP Developers
*
* @author   izni burak demirtaş (@izniburak) <izniburak@gmail.com>
* @web      <http://burakdemirtas.org>
* @url      <https://github.com/izniburak/nur>
* @license  The MIT License (MIT) - <http://opensource.org/licenses/MIT>
*/

# Application Routes file.

Route::get('/', function()
{   
	view('index');
});

Route::group('/foo', function()
{
    Route::get('/bar', 'Index@main');
    Route::get('/baz', 'Index@main');
});

Route::get('/test/controller', 'Index@main');

Route::get('/hello/{s}', function( $name )
{
    echo "Hello, " . $name;
});
