<?php
/**
 * Created by PhpStorm.
 * User: sofian
 * Date: 31/07/2018
 * Time: 15:33
 */

namespace PTCalculator\Calculation\Enums;


class HighLatitudesMethods
{

    const NONE = 'none';
    const MIDNIGHT = 'midnight';
    const ONESEVENTH = 'oneseventh';
    const ANGLEBASED = 'anglebased';

    /**
     * @var array
     */
    public static $HighLatitudesMethodsDefinition = array(
        self::NONE => 'No adjustment',
        self::MIDNIGHT => 'middle of night',
        self::ONESEVENTH => '1/7th of night',
        self::ANGLEBASED => 'angle/60th of night'
    );

    /**
     * @return array
     */
    public static $HighLatitudesMethods = array(self::NONE, self::MIDNIGHT, self::ONESEVENTH, self::ANGLEBASED);

}