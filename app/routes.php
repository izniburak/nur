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
use Nur\Facades\Route;
use Nur\Http\{Request, Response};

Route::get('/', function(Request $request): Response
{
    return view('index');
});

Route::get('/controller', 'IndexController@main');

Route::controller('/test', 'TestController');
