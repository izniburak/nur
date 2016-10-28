<?php
/**
 * Mubu - A simple framework for PHP Developers
 *
 * @package  Mubu
 * @author   İzni Burak Demirtaş <izniburak@gmail.com>
 * @web      <http://burakdemirtas.org>
 */

/*
$file = "images/example.png";
$resize = new resize($file);
$resize->resizeImage(750, 500, 'auto'); // default: auto - @params: auto, crop, landscape, portrait, exact
$resize->saveImage($resimyolu, 100);
*/

namespace App\Libraries;

class Resize
{
	private $file;
	private $image;
	private $width;
	private $height;
	private $imageResized;

	function __construct($fileName)
	{
		$this->file = $fileName;

		if(!$this->isFile()) return false;
		$this->image = $this->openImage($fileName);
		$this->width = imagesx($this->image);
		$this->height = imagesy($this->image);
	}

	private function isFile()
	{
		if(file_exists($this->file))
			return true;
		else
			return false;
	}

	private function openImage($file)
	{
		$extension = strtolower(strrchr($file, '.'));
		switch($extension)
		{
			case '.jpg':
			case '.jpeg':
				$img = @imagecreatefromjpeg($file);
				break;
			case '.gif':
				$img = @imagecreatefromgif($file);
				break;
			case '.png':
				$img = @imagecreatefrompng($file);
				break;
			default:
				$img = false;
			break;
		}
		return $img;
	}

	public function resizeImage($newWidth, $newHeight, $option="auto")
	{
		if(!$this->isFile()) return false;
		$optionArray = $this->getDimensions($newWidth, $newHeight, $option);
		$optimalWidth = $optionArray['optimalWidth'];
		$optimalHeight = $optionArray['optimalHeight'];

		$this->imageResized = imagecreatetruecolor($optimalWidth, $optimalHeight);
		imagecopyresampled($this->imageResized, $this->image, 0, 0, 0, 0, $optimalWidth, $optimalHeight, $this->width, $this->height);

		if ($option == 'crop')
			$this->crop($optimalWidth, $optimalHeight, $newWidth, $newHeight);
	}

	private function getDimensions($newWidth, $newHeight, $option)
	{
		switch ($option)
		{
			case 'exact':
				$optimalWidth = $newWidth;
				$optimalHeight= $newHeight;
				break;
			case 'portrait':
				$optimalWidth = $this->getSizeByFixedHeight($newHeight);
				$optimalHeight= $newHeight;
				break;
			case 'landscape':
				$optimalWidth = $newWidth;
				$optimalHeight= $this->getSizeByFixedWidth($newWidth);
				break;
			case 'auto':
				$optionArray = $this->getSizeByAuto($newWidth, $newHeight);
				$optimalWidth = $optionArray['optimalWidth'];
				$optimalHeight = $optionArray['optimalHeight'];
				break;
			case 'crop':
				$optionArray = $this->getOptimalCrop($newWidth, $newHeight);
				$optimalWidth = $optionArray['optimalWidth'];
				$optimalHeight = $optionArray['optimalHeight'];
				break;
		}
		return ['optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight];
	}

	private function getSizeByFixedHeight($newHeight)
	{
		$ratio = $this->width / $this->height;
		$newWidth = $newHeight * $ratio;
		return $newWidth;
	}

	private function getSizeByFixedWidth($newWidth)
	{
		$ratio = $this->height / $this->width;
		$newHeight = $newWidth * $ratio;
		return $newHeight;
	}

	private function getSizeByAuto($newWidth, $newHeight)
	{
		if ($this->height < $this->width)
		{
			$optimalWidth = $newWidth;
			$optimalHeight= $this->getSizeByFixedWidth($newWidth);
		}
		elseif ($this->height > $this->width)
		{
			$optimalWidth = $this->getSizeByFixedHeight($newHeight);
			$optimalHeight= $newHeight;
		}
		else
		{
			if ($newHeight < $newWidth)
			{
				$optimalWidth = $newWidth;
				$optimalHeight= $this->getSizeByFixedWidth($newWidth);
			}
			else if ($newHeight > $newWidth)
			{
				$optimalWidth = $this->getSizeByFixedHeight($newHeight);
				$optimalHeight= $newHeight;
			}
			else
			{
				$optimalWidth = $newWidth;
				$optimalHeight= $newHeight;
			}
		}
		return ['optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight];
	}

	private function getOptimalCrop($newWidth, $newHeight)
	{
		$heightRatio = $this->height / $newHeight;
		$widthRatio = $this->width / $newWidth;

		if ($heightRatio < $widthRatio)
			$optimalRatio = $heightRatio;
		else
			$optimalRatio = $widthRatio;

		$optimalHeight = $this->height / $optimalRatio;
		$optimalWidth = $this->width / $optimalRatio;
		return ['optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight];
	}

	private function crop($optimalWidth, $optimalHeight, $newWidth, $newHeight)
	{
		$cropStartX = ( $optimalWidth / 2) - ( $newWidth /2 );
		$cropStartY = ( $optimalHeight/ 2) - ( $newHeight/2 );
		$crop = $this->imageResized;
		$this->imageResized = imagecreatetruecolor($newWidth , $newHeight);
		imagecopyresampled($this->imageResized, $crop , 0, 0, $cropStartX, $cropStartY, $newWidth, $newHeight , $newWidth, $newHeight);
	}

	public function saveImage($savePath, $imageQuality="100")
	{
		if(!$this->isFile()) return false;
		$extension = strrchr($savePath, '.');
		$extension = strtolower($extension);

		switch($extension)
		{
			case '.jpg':
			case '.jpeg':
				if (imagetypes() & IMG_JPG)
					imagejpeg($this->imageResized, $savePath, $imageQuality);
				break;
			case '.gif':
				if (imagetypes() & IMG_GIF)
					imagegif($this->imageResized, $savePath);
				break;
			case '.png':
				$scaleQuality = round(($imageQuality/100) * 9);
				$invertScaleQuality = 9 - $scaleQuality;
				if (imagetypes() & IMG_PNG)
					imagepng($this->imageResized, $savePath, $invertScaleQuality);
				break;
			default:
				break;
		}
		imagedestroy($this->imageResized);
	}
}
