<?php
/**
* nur - a simple framework for PHP Developers
*
* @author   izni burak demirtaş (@izniburak) <izniburak@gmail.com>
* @web      <http://burakdemirtas.org>
* @url      <https://github.com/izniburak/nur>
* @license  The MIT License (MIT) - <http://opensource.org/licenses/MIT>
*/

use Nur\Load\Load;
use Nur\Error\Error;
use Nur\Blade\Blade;

### Load::view function
if (!function_exists('view'))
{
    function view($name, $data = null)
    {
        return Load::getInstance()->view($name, $data);
    }
}

### Blade::make function
if (!function_exists('blade'))
{
    function blade($view = null, $data = [], $mergeData = [])
    {
        return blade::make($view, $data, $mergeData);
    }
}

### Load::library function
if (!function_exists('library'))
{
    function library($name, $params = null)
    {
        return Load::getInstance()->library($name, $params);
    }
}

### Load::model function
if (!function_exists('model'))
{
    function model($file)
    {
        return Load::getInstance()->model($file);
    }
}

### Load::helper function
if (!function_exists('helper'))
{
    function helper($name)
    {
        return Load::getInstance()->helper($name);
    }
}

### Error::message function
if (!function_exists('error'))
{
    function error($title = null, $msg = null, $page = null)
    {
        return Error::message($title, $msg, $page);
    }
}

### token generator function
if (!function_exists('getToken'))
{
    function getToken()
    {
        return _TOKEN;
    }
}

### token reset function
if (!function_exists('resetToken'))
{
    function resetToken()
    {
        if(isset($_SESSION['_token']))
        {
            $_SESSION['_token'] = '';
            unset($_SESSION['_token']);
        }
    }
}

### get config values function
if (!function_exists('getConfig'))
{
    function getConfig()
    {
        global $config;
        $a = $config;
        return $a;
    }
}

if (!class_exists('Uri')) 
{
    class Uri extends Nur\Uri\Uri { }
}

if (!class_exists('Http')) 
{
    class Http extends Nur\Http\Http { }
}

if (!class_exists('Session')) 
{
    class Session extends Nur\Http\Session { }
}

if (!class_exists('Cookie')) 
{
    class Cookie extends Nur\Http\Cookie { }
}
