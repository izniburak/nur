<?php
/**
 * Mubu - A simple framework for PHP Developers
 *
 * @package  Mubu
 * @author   İzni Burak Demirtaş <izniburak@gmail.com>
 * @web      <http://burakdemirtas.org>
 */

### $_POST function
if (!function_exists('post'))
{
	function post($key = null, $value = '')
	{
		if(is_null($key)) return $_POST;

		if (!$value)
			$result = (isset($_POST[$key]) ? $_POST[$key] : '');
		else
			$_POST[$key] = $result = $value;

		return $result;
	}
}

### $_GET function
if (!function_exists('get'))
{
	function get($key = null, $value = '')
	{
		if(is_null($key)) return $_GET;

		if (!$value)
			$result = (isset($_GET[$key]) ? $_GET[$key] : '');
		else
			$_GET[$key] = $result = $value;

		return $result;
	}
}

### $_REQUEST function
if (!function_exists('request'))
{
	function request($key = null, $value = '')
	{
		if(is_null($key)) return $_REQUEST;

		if (!$value)
			$result = (isset($_REQUEST[$key]) ? $_REQUEST[$key] : '');
		else
			$_REQUEST[$key] = $result = $value;

		return $result;
	}
}

### $_SERVER function
if (!function_exists('server'))
{
	function server($key = null, $value = '')
	{
		if(is_null($key)) return $_SERVER;

		if (!$value)
			$result = (isset($_SERVER[$key]) ? $_SERVER[$key] : '');
		else
			$_SERVER[$key] = $result = $value;

		return $result;
	}
}

### $_FILES function
if (!function_exists('files'))
{
	function files($key = null, $name = '')
	{
		if(is_null($key)) return $_FILES;
		if (isset($_FILES[$key]))
		{
			if ($name)
				return $_FILES[$key][$name];
			else
				return $_FILES[$key];
		}
		return;
	}
}


### remove function
if (!function_exists('remove'))
{
	function remove($file)
	{
		if (file_exists($file))
		{
			@unlink($file);
			return true;
		}

		return false;
	}
}

### seo (search engine optimization) urls function
if (!function_exists('seo'))
{
	function seo($sef)
	{
		$x = ['İ', 'Ö', 'Ü', 'Ğ', 'Ç', 'Ş', 'ö', 'ü', 'ğ', 'ç', 'ş', 'ı', '_', ' ', '--', '---'];
		$y = ['i', 'o', 'u', 'g', 'c', 's', 'o', 'u', 'g', 'c', 's', 'i', '-', '-', '-', '-'];
		$sef = str_replace($x, $y, $sef);
		$sef = preg_replace("@[^A-Za-z0-9\-_]+@i", "", $sef);
		$sef = strtolower($sef);
		return $sef;
	}
}

### curl function
if (!function_exists('ch'))
{
	function ch($feed, $ref = null, $coo = null)
	{
		$ch = curl_init();
		$timeout = 0;
		curl_setopt ($ch, CURLOPT_URL, $feed);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
		if(!is_null($coo))
		{
			curl_setopt($ch, CURLOPT_COOKIEFILE, $coo);
			curl_setopt($ch, CURLOPT_COOKIEJAR, $coo);
		}
		if(is_null($ref))
			curl_setopt($ch, CURLOPT_REFERER, $feed);
		else
			curl_setopt($ch, CURLOPT_REFERER,$ref);
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}
}

### dd function
if (!function_exists('dd'))
{
	function dd($str)
	{
		die(var_dump($str));
	}
}

### stripslashes function
if (!function_exists('s'))
{
	function s($str)
	{
		if(is_array($str))
			return array_filter($str, 's');

		$str = htmlspecialchars_decode($str, ENT_QUOTES);
		$str = html_entity_decode($str, ENT_QUOTES, 'UTF-8');
		return trim(stripslashes($str));
	}
}

### strip_tags function
if (!function_exists('st'))
{
	function st($str, $accept = null)
	{
		if(is_array($str))
			return array_filter($str, 'st');

		if(is_null($accept))
			return trim(strip_tags($str));
		else
			return trim(strip_tags($str, $accept));
	}
}

### substr function
if (!function_exists('ss'))
{
	function ss($str, $x, $y = '')
	{
		if(strlen($str) > $x) $str = mb_substr($str, 0, $x, 'UTF-8') . $y;
		return $str;
	}
}

### echo function
if (!function_exists('e'))
{
	function e($str, $p = false)
	{
		if($p == false)
			echo $str;
		else
			print_r($str);
	}
}
