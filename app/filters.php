<?php
/**
* nur - a simple framework for PHP Developers
*
* @author   izni burak demirtaş (@izniburak) <izniburak@gmail.com>
* @web      <http://burakdemirtas.org>
* @url      <https://github.com/izniburak/nur>
* @license  The MIT License (MIT) - <http://opensource.org/licenses/MIT>
*/

# Route Filters
# Application Route basic middleware and patterns defination file.

# Create a new pattern for Route parameters.
Route::pattern('demo', '[0-9]+');

# Example basic middleware for csrf protection.
Route::middleware('csrf', function()
{
    if( !csrfCheck( Http::post('_token') ) )
        return Uri::redirect('/no-access');
});
