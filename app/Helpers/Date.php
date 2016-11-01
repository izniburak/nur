<?php
/**
 * Mubu - A simple framework for PHP Developers
 *
 * @package  Mubu
 * @author   İzni Burak Demirtaş <izniburak@gmail.com>
 * @web      <http://burakdemirtas.org>
 */

if (!function_exists('trDate'))
{
	function trDate($time)
	{
		$d 		= date("j M Y", $time);
		$ing	= ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"];
		$tr		= ["Ocak", "Şubat", "Mart", "Nisan", "Mayıs", "Haziran", "Temmuz", "Ağustos", "Eylül", "Ekim", "Kasım", "Aralık", "Pazartesi", "Salı", "Çarşamba", "Perşembe", "Cuma", "Cumartesi", "Pazar"];
		return str_replace($ing, $tr, $d);
	}
}

if (!function_exists('hours'))
{
	function hours($time, $s = false)
	{
		$x	= date("H:i", $time);
		if($s) $x = date("H:i:s", $time);
		return $x;	
	}
}
