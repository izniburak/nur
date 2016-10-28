<?php
/**
 * Mubu - A simple framework for PHP Developers
 *
 * @package  Mubu
 * @author   İzni Burak Demirtaş <izniburak@gmail.com>
 * @web      <http://burakdemirtas.org>
 */

namespace App\Libraries;

use DebugBar\StandardDebugBar;

class Debug
{
	public static $class;
	private static $debugBar;

	public function __construct()
	{
		self::$class = new StandardDebugBar();
		self::$debugBar = self::$class->getJavascriptRenderer();
	}

	public static function __callstatic($name, $params)
	{
		self::$name($params);
	}

	public function head()
	{
		$script = str_replace(['href="/', 'src="/'], ['href="' . uri::base(), 'src="' . uri::base()], self::$debugBar->renderHead());
		echo $script;
	}

	public function render()
	{
		echo self::$debugBar->render();
	}

	public function addMessage($msg)
	{
		self::$class['messages']->addMessage($msg);
	}

	public function __destruct()
	{
		self::$class = null;
	}
}
