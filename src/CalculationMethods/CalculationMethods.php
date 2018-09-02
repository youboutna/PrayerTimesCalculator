<?php
/**
 * Created by PhpStorm.
 * User: sofian
 * Date: 15/07/2018
 * Time: 15:39
 */

namespace PTCalculator\CalculationMethods;


class CalculationMethods
{
    const MWL = 'mwl'; //Europe, Far East, parts of US
    const ISNA = 'isna'; //North America (US and Canada)
    const Egypt = 'egypt'; //Africa, Syria, Lebanon, Malaysia
    const Makkah = 'makkah'; //Arabian Peninsula
    const Karachi = 'karachi'; //Pakistan, Afganistan, Bangladesh, India
    const Tehran = 'tehran'; //Iran, Some Shia communities
    const Jafari ='jafari'; //Some Shia communities worldwide
    const Custom = 'custom';

    /**
     * Calculation methods names @metadata
     * @var array
     */
    public static $calculationMethodsNames = array(
        self::MWL => 'Muslim World League',
        self::ISNA => 'Islamic Society of North America',
        self::Egypt => 'Egyptian General Authority of Survey',
        self::Makkah => 'Umm al-Qura University',
        self::Karachi => 'University of Islamic Sciences',
        self::Jafari => 'Shia Ithna Ashari, Leva Research Institute, Qum',
        self::Custom => 'User method'
    );

    /**
     * @var array
     */
    public static $juristicMethods = array('shafii', 'hanafi');

    /**
     * Defaults options | VALUES for calculation methods
     * @return array
     */
    public static final function getDefaultsParametersMap(): array
    {
        return array(
            self::MWL => array(18, 1, 0, 0, 17),
            self::ISNA => array(15, 1, 0, 0, 15),
            self::Egypt => array(19.5, 1, 0, 0, 17.5),
            self::Makkah => array(18.5, 1, 0, 1, 90),
            self::Karachi => array(18, 1, 0, 0, 18),
            self::Jafari => array(16, 0, 4, 0, 14),
            self::Custom => array(18, 1, 0, 0, 17) //init like mwl
        );
    }

}