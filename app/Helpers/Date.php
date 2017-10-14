<?php
/**
* nur - a simple framework for PHP Developers
*
* @author   izni burak demirtaş (@izniburak) <izniburak@gmail.com>
* @web      <http://burakdemirtas.org>
* @url      <https://github.com/izniburak/nur>
* @license  The MIT License (MIT) - <http://opensource.org/licenses/MIT>
*/

if (!function_exists('dateTr'))
{
    function dateTr($time, $day = false)
    {
        $format = "d M Y" . ($day ? ", l" : "");
        $date = date($format, $time);
        $eng = [
            "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec", 
            "Monday", "Tuesday", "Wednesday", "Thurday", "Friday", "Saturday", "Sunday"
        ];
        $tr	= [
            "Ocak", "Şubat", "Mart", "Nisan", "Mayıs", "Haziran", "Temmuz", "Ağustos", "Eylül", "Ekim", "Kasım", "Aralık", 
            "Pazartesi", "Salı", "Çarşamba", "Perşembe", "Cuma", "Cumartesi", "Pazar"
        ];
        return str_replace($eng, $tr, $date);
    }
}

if (!function_exists('hours'))
{
    function hours($time = false, $s = false)
    {
        $format = "H:i" . ($s ? ":i" : "");
        $hour	= date($format, ($time == false ? time() : $time));
        return $hour;	
    }
}
