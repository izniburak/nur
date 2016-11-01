<?php
/**
 * Mubu - A simple framework for PHP Developers
 *
 * @package  Mubu
 * @author   İzni Burak Demirtaş <izniburak@gmail.com>
 * @web      <http://burakdemirtas.org>
 */

 if (!function_exists('htmlCompress'))
 {
 	function htmlCompress($html)
 	{
 		return str_replace(["\n", "\t", "\r", "   "], '', $html);
 	}
 }
