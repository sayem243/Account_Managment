<?php
/**
 * Created by PhpStorm.
 * User: hasan
 * Date: 6/10/20
 * Time: 12:26 PM
 */

namespace App\CustomClass;


class NumberToWordConverter
{

    public static $hyphen      = ' ';
    public static $conjunction = '  ';
    public static $separator   = ' ';
    public static $negative    = 'negative ';
    public static $decimal     = ' point ';
    public static $dictionary  = array(
        0                   => 'zero',
        1                   => 'one',
        2                   => 'two',
        3                   => 'three',
        4                   => 'four',
        5                   => 'five',
        6                   => 'six',
        7                   => 'seven',
        8                   => 'eight',
        9                   => 'nine',
        10                  => 'ten',
        11                  => 'eleven',
        12                  => 'twelve',
        13                  => 'thirteen',
        14                  => 'fourteen',
        15                  => 'fifteen',
        16                  => 'sixteen',
        17                  => 'seventeen',
        18                  => 'eighteen',
        19                  => 'nineteen',
        20                  => 'twenty',
        30                  => 'thirty',
        40                  => 'fourty',
        50                  => 'fifty',
        60                  => 'sixty',
        70                  => 'seventy',
        80                  => 'eighty',
        90                  => 'ninety',
        100                 => 'hundred',
        1000                => 'thousand',
        1000000             => 'million',
        1000000000          => 'billion',
        1000000000000       => 'trillion',
        1000000000000000    => 'quadrillion',
        1000000000000000000 => 'quintillion'
    );

    public static function convert($number){
        if (!is_numeric($number) ) return false;
        $num = number_format($number,2);

        $num_arr = explode(".",$num);
        $string = '';
        switch (true) {
            case $number < 21:
                $string = self::$dictionary[$number];
                break;
            case $number < 100:
                $tens   = ((int) ($number / 10)) * 10;
                $units  = $number % 10;
                $string = self::$dictionary[$tens];
                if ($units) {
                    $string .= self::$hyphen . self::$dictionary[$units];
                }
                break;
            case $number < 1000:
                $hundreds  = $number / 100;
                $remainder = $number % 100;
                $string = self::$dictionary[$hundreds] . ' ' . self::$dictionary[100];
                if ($remainder) {
                    $string .= self::$conjunction . self::convert($remainder);
                }
                break;
            default:
                $baseUnit = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int) ($number / $baseUnit);
                $remainder = $number % $baseUnit;
                $string = self::convert($numBaseUnits) . ' ' . self::$dictionary[$baseUnit];
                if ($remainder) {
                    $string .= $remainder < 100 ? self::$conjunction : self::$separator;
                    $string .= self::convert($remainder);
                }
                break;
        }

        $decnum = $num_arr[1];
        $customNumber = array(
            '01'                   => 'one',
            '02'                   => 'two',
            '03'                   => 'three',
            '04'                   => 'four',
            '05'                   => 'five',
            '06'                   => 'six',
            '07'                   => 'seven',
            '08'                   => 'eight',
            '09'                   => 'nine',
        );
        if($decnum > 0){
            $string .= " and poisa ";
            if($decnum < 21 && !array_key_exists($decnum,$customNumber)){
                $string .= self::$dictionary[$decnum];
            }
            elseif($decnum < 100){
                $tens   = ((int) ($decnum / 10)) * 10;
                $units  = $decnum % 10;
                $string .= self::$dictionary[$tens];
                if ($units) {
                    $string .= self::$hyphen . self::$dictionary[$units];
                }
//
            }
            $string = $string." only";
        }


        return ucwords($string)  ;
    }

}