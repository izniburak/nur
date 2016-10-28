<?php
/**
 * Mubu - A simple framework for PHP Developers
 *
 * @package  Mubu
 * @author   İzni Burak Demirtaş <izniburak@gmail.com>
 * @web      <http://burakdemirtas.org>
 */

 use Mubu\Load\Load;
 use Mubu\Error\Error;
 use Mubu\Blade\Blade;

### Load::view function
if (!function_exists('view'))
{
  function view($name, $data = null)
  {
  	return Load::view($name, $data);
  }
}

### Load::library function
if (!function_exists('library'))
{
  function library($name, $params = null)
  {
  	return Load::library($name, $params);
  }
}

### Load::model function
if (!function_exists('model'))
{
  function model($file)
  {
  	return Load::model($file);
  }
}

### Load::helper function
if (!function_exists('helper'))
{
  function helper($name)
  {
  	return Load::helper($name);
  }
}

### Error::message function
if (!function_exists('error'))
{
  function error($msg = null, $page = null)
  {
  	return Error::message($msg, $page);
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

### token generator function
if (!function_exists('token'))
{
	function token()
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
