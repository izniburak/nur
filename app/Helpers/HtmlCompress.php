<?php
/**
* nur - a simple framework for PHP Developers
*
* @author   izni burak demirtaş (@izniburak) <izniburak@gmail.com>
* @web      <http://burakdemirtas.org>
* @url      <https://github.com/izniburak/nur>
* @license  The MIT License (MIT) - <http://opensource.org/licenses/MIT>
*/

if (!function_exists('htmlCompress')) {
    function htmlCompress($buffer)
    {
        $search = ['/\>[^\S ]+/s', '/[^\S ]+\</s', '/(\s)+/s'];
        $replace = ['>', '<', '\\1'];
        if (preg_match("/\<html/i",$buffer) == 1 && preg_match("/\<\/html\>/i",$buffer) == 1) 
            $buffer = preg_replace($search, $replace, $buffer);
        $buffer = str_replace(["\n", "\t", "\r", "   ", "    "], '', $buffer);

        return $buffer;
    }
}
