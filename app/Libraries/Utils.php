<?php
/**
 * Created by PhpStorm.
 * User: kiran
 * Date: 30/9/17
 * Time: 4:51 PM
 */

namespace App\Libraries;


use Carbon\Carbon;

class Utils
{
    public static function parseDate($dateDate){
        if($dateDate === "0000-00-00" || $dateDate == null){
            return "NA";
        }
        else{
            return  Carbon::parse($dateDate)->format(PHP_DATE_FORMAT);
        }
    }

    public static function parseDateTime($dateDate){
        if($dateDate === "0000-00-00 00:00:00" || $dateDate == null){
            return "NA";
        }
        else{
            return  Carbon::parse($dateDate)->format(PHP_DATE_TIME_FORMAT);
        }
    }
}