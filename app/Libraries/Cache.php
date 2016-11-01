<?php
/**
 * Mubu - A simple framework for PHP Developers
 *
 * @package  Mubu
 * @author   İzni Burak Demirtaş <izniburak@gmail.com>
 * @web      <http://burakdemirtas.org>
 */

namespace App\Libraries;

use Mubu\Http\Http;

class Cache
{
	private static $file;

	public function __construct()
	{
		$date = date('dmY-His');
		$fileName = md5('%%-' . http::server('REQUEST_URI') . time()) . '_' . $date . '.cache';
		$path = realpath(__DIR__ . '/../../storage/cache/html/');

		if (!file_exists($path))
			$creatPath = mkdir($path, 0777);
		self::$file = $path . $fileName;
	}

	public static function start($time = 1)
	{
		$cacheTime = $time * 60;
		if (file_exists(self::$file))
		{
			if (time() - $cacheTime < filemtime(self::$file))
			{
				readfile(self::$file);
				die();
			}
			else
				self::delete();
		}
		return;
	}

	public static function finish()
	{
		$fp = fopen(self::$file, 'w+');
		fwrite($fp, ob_get_contents());
		fclose($fp);
		return;
	}

	private static function delete()
	{
		unlink(self::$file);
		return;
	}
}
