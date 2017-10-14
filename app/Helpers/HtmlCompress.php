<?php
/**
* nur - a simple framework for PHP Developers
*
* @author   izni burak demirtaş (@izniburak) <izniburak@gmail.com>
* @web      <http://burakdemirtas.org>
* @url      <https://github.com/izniburak/nur>
* @license  The MIT License (MIT) - <http://opensource.org/licenses/MIT>
*/

 if (!function_exists('htmlCompress'))
 {
     function htmlCompress($html)
     {
         return str_replace(["\n", "\t", "\r", "   "], '', $html);
     }
 }

if (!function_exists('compressHtml'))
{
    function compressHtml($buffer)
    {
        $search = array('/\>[^\S ]+/s', '/[^\S ]+\</s', '/(\s)+/s');
        $replace = array('>', '<', '\\1');
        if (preg_match("/\<html/i",$buffer) == 1 && preg_match("/\<\/html\>/i",$buffer) == 1) 
            $buffer = preg_replace($search, $replace, $buffer);
        $buffer = str_replace(array("\n", "\t", "\r", "   ", "    "), '', $buffer);

        return $buffer;
    }
}
