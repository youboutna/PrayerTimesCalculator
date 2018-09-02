<?php
/**
 * Created by PhpStorm.
 * User: sofian
 * Date: 01/08/2018
 * Time: 22:47
 */

namespace PTCalculator\PrayerTimes\Builder;

use PTCalculator\Calculation\PrTCalculatorInterface;
use PTCalculator\PrayerTimes\PrayerTimesInterface;

interface PrayerTimesBuilderInterface{

    /**
     * @param array $cm_options_array
     * @return mixed
     */
    public function addCmOptions(array $cm_options_array = array()): PrayerTimesBuilderInterface;

    /**
     * @param array $calc_options_array
     * @return mixed
     */
    public function addCalcOptions(array $calc_options_array = array()): PrayerTimesBuilderInterface;

    /**
     * @return PrTCalculatorInterface
     */
    public function getPrayerTimes(): PrayerTimesInterface;

}