<?php
/**
* nur - a simple framework for PHP Developers
*
* @author   izni burak demirtaş (@izniburak) <izniburak@gmail.com>
* @web      <http://burakdemirtas.org>
* @url      <https://github.com/izniburak/nur>
* @license  The MIT License (MIT) - <http://opensource.org/licenses/MIT>
*/

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
