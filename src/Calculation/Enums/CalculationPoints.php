<?php
/**
 * Created by PhpStorm.
 * User: sofian
 * Date: 30/07/2018
 * Time: 10:57
 */

namespace PTCalculator\Calculation\Enums;

$a= 2;
class CalculationPoints
{
    const FAJR = 'fajr';
    const SUNRISE = 'sunrise';
    const DHUHR = 'dhuhr';
    const ASR = 'asr';
    const SUNSET = 'sunset';
    const MAGHRIB = 'maghrib';
    const ISHA = 'isha';

    /**
     * @var array
     */
    public static $calcPointsDescription = array(
        self::FAJR => 'When the sky begins to lighten (dawn).',
        self::SUNRISE => 'The time at which the first part of the Sun appears above the horizon.',
        self::DHUHR => 'When the Sun begins to decline after reaching its highest point in the sky.',
        self::ASR => 'The time when the length of any object\'s shadow reaches a factor (usually 1 or 2) of the length
         of the object itself plus the length of that object\'s shadow at noon.',
        self::SUNSET => 'The time at which the Sun disappears below the horizon.',
        self::MAGHRIB => 'Soon after sunset.',
        self::ISHA => 'The time at which darkness falls and there is no scattered light in the sky.',
    );

    /**
     * @var array
     */
    public static $calculationPoints = array(
        self::FAJR,
        self::SUNRISE,
        self::DHUHR,
        self::ASR,
        self::SUNSET,
        self::MAGHRIB,
        self::ISHA,
    );
}