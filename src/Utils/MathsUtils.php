<?php
/**
 * Created by PhpStorm.
 * User: sofian
 * Date: 30/07/2018
 * Time: 13:55
 */

namespace PTCalculator\Utils;

class MathsUtils
{
    /**
     * @param float $d
     * @return float
     */
    public static function dsin(float $d)
    {
        return sin(self::dtr($d));
    }

    /**
     * @param float $d
     * @return float
     */
    public static function dcos(float $d)
    {
        return cos(self::dtr($d));
    }

    /**
     * @param float $d
     * @return float
     */
    public static function dtan(float $d)
    {
        return tan(self::dtr($d));
    }

    /**
     * @param float $x
     * @return float|int
     */
    public static function darcsin(float $x)
    {
        return self::rtd(asin($x));
    }

    /**
     * @param float $x
     * @return float|int
     */
    public static function darccos(float $x)
    {
        return self::rtd(acos($x));
    }

    /**
     * @param float $x
     * @return float|int
     */
    public static function darctan(float $x)
    {
        return self::rtd(atan($x));
    }

    /**
     * @param float $y
     * @param float $x
     * @return float|int
     */
    public static function darctan2(float $y, float $x)
    {
        return self::rtd(atan2($y, $x));
    }

    /**
     * @param float $x
     * @return float|int
     */
    public static function darccot(float $x)
    {
        return self::rtd(atan(1/$x));
    }

    /**
     * @param float $deg
     * @return float
     */
    public static function dtr(float $deg)
    {
        return ($deg * M_PI) / 180.0;
    }

    /**
     * @param float $rad
     * @return float|int
     */
    public static function rtd(float $rad)
    {
        return ($rad * 180.0) / M_PI;
    }

    /**
     * @param float $angle
     * @return float
     */
    public static function degreesRangeReduce(float $angle)
    {
        $angle = $angle - 360.0 * floor($angle / 360.0);
        $angle = $angle < 0 ? $angle + 360.0 : $angle;
        return $angle;
    }

    /**
     * @param float $hours
     * @return float
     */
    public static function hoursRangeReduce(float $hours)
    {
        $hours = $hours - 24.0 * floor($hours / 24.0);
        $hours = $hours < 0 ? $hours + 24.0 : $hours;
        return $hours;
    }

    /**
     * @param $time
     * @return string
     */
    public static function floatToTime24($time)
    {
        if (is_nan($time)){
            throw new \InvalidArgumentException('Please provide a valid time');
        }
        $d = new \DateTime();
        $time = self::hoursRangeReduce($time+ 0.5/ 60);  // add 0.5 minutes to round
        //$time = self::hoursRangeReduce($time+ 1/3600);  // add 0.5 second to round
        $hours = floor($time);
        $minutes = floor(($time- $hours)* 60);
        $secondes = floor((($time- $hours)* 60-$minutes)*60);
        $r_minutes = $minutes;
        /**
         if($secondes > 30 && $secondes < 60){
            $r_minutes = $minutes+1;
        }
         */
        return self::twoDigitsFormat($hours). ':'. self::twoDigitsFormat($r_minutes);
    }

    /**
     * @param $time
     * @param bool $noSuffix
     * @return string
     */
    public static function floatToTime12($time, $noSuffix = false)
    {
        if (is_nan($time)){
            throw new \InvalidArgumentException('Please provide a valid time');
        }
        $time = self::hoursRangeReduce($time+ 0.5/ 60);  // add 0.5 minutes to round
        $hours = floor($time);
        $minutes = floor(($time- $hours)* 60);
        $suffix = $hours >= 12 ? ' pm' : ' am';
        $hours = ($hours+ 12- 1)% 12+ 1;
        return $hours. ':'. self::twoDigitsFormat($minutes). ($noSuffix ? '' : $suffix);
    }

    /**
     * @param $time
     * @return string
     */
    public static function floatToTime12NS($time)
    {
        return self::floatToTime12($time, true);
    }

    /**
     * @param $time1
     * @param $time2
     * @return float
     */
    public static function timeDiff($time1, $time2)
    {
        return self::hoursRangeReduce($time2- $time1);
    }


    /**
     * @param $num
     * @return string
     */
    public static function twoDigitsFormat($num)
    {
        return ($num <10) ? '0'. $num : $num;
    }

}