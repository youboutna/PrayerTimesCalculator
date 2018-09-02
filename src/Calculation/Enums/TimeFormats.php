<?php
/**
 * Created by PhpStorm.
 * User: sofian
 * Date: 31/07/2018
 * Time: 14:14
 */

namespace PTCalculator\Calculation\Enums;


class TimeFormats
{
    const TIME24 = 'time24';
    const TIME12 = 'time12';
    const TIME12NS = 'time12NS';
    const FLOAT = 'float';

    /**
     * @var array
     */
    public static $timeFormatsDefinition = array(
        self::TIME24 => '24-hour format',
        self::TIME12 => '12-hour format',
        self::TIME12NS => '12-hour format with no suffix',
        self::FLOAT => 'floating point number'
    );

    /**
     * @return array
     */
    public static $timeFormats = array(self::TIME24, self::TIME12, self::TIME12NS, self::FLOAT);

}
