<?php
namespace App\Helpers;

class Apphelper
{

    public static function Appseotitle($inputString)
    {
        $cleanedString = preg_replace('/[^\p{L}\d]+/u', '-', $inputString);
        $cleanedString = trim($cleanedString, '-');
        $cleanedString = str_replace(' ', '-', $cleanedString);
        $seoTitle = strtolower($cleanedString);
        return $seoTitle;
    }

}
