<?php
/**
 * Created by PhpStorm.
 * User: sofian
 * Date: 01/08/2018
 * Time: 19:21
 */

namespace PTCalculator\Utils;


use Exception;

class JdateUtils
{
    /**
     * @param \DateTime $date
     * @return float
     * @throws \Exception
     */
    public static function dateTimeToJDate(\DateTimeImmutable $date){
        $day = intval($date->format('d'));
        $month = intval($date->format('m'));
        $year = intval($date->format('Y'));

        if($year>1980 && $year< 2150){
            return gregoriantojd($month, $day, $year);
        }else{
            throw new Exception("Unsuported periods");
        }

    }

    /**
     * @param \DateTime $date
     * @return int
     */
    public static function getTimeZoneHours(\DateTimeZone $timeZone): int
    {
        return floor($timeZone->getOffset(new \DateTime()) / 3600);
    }
    /**
     * calculate julian date from a calendar date
     * @param $year
     * @param $month
     * @param $day
     * @return float
     */
    public static function julianDate($year, $month, $day): float
    {
        if ($month <= 2)
        {
            $year -= 1;
            $month += 12;
        }
        $A = floor($year/ 100);
        $B = 2- $A+ floor($A/ 4);

        $JD = floor(365.25* ($year+ 4716))+ floor(30.6001* ($month+ 1))+ $day+ $B- 1524.5;
        return $JD;
    }

    /**
     * convert a calendar date to julian date (second method), unused
     * @param $year
     * @param $month
     * @param $day
     * @return float
     */
    /*
    public static function calcJD($year, $month, $day)
    {
        $J1970 = 2440588.0;
        $date = $year. '-'. $month. '-'. $day;
        $ms = strtotime($date);   // # of milliseconds since midnight Jan 1, 1970
        $days = floor($ms/ (1000 * 60 * 60* 24));
        return $J1970+ $days- 0.5;
    }
    */
}