<?php
/**
 * Created by PhpStorm.
 * User: sofian
 * Date: 05/08/2018
 * Time: 14:02
 */

namespace PTCalculator\PrayerTimes\Builder;


use PTCalculator\Calculation\PrTCalculator;
use PTCalculator\Calculation\PrTCalculatorInterface;
use PTCalculator\PrayerTimes\PrayerTimes;
use PTCalculator\PrayerTimes\PrayerTimesInterface;
use PTCalculator\Utils\JdateUtils;

abstract class AbstractPrayerTimesBuilder implements PrayerTimesBuilderInterface
{
    /**
     * @var PrayerTimesInterface
     */
    protected $prayerTimes;

    /**
     * @var array
     */
    protected $calculationMethodOptions;

    /**
     * @var array
     */
    protected $calculationOptions;

    /**
     * @var PrTCalculatorInterface
     */
    protected $calculator;

    /**
     * @param array $cm_options
     * @return PrayerTimesBuilderInterface
     */
    public abstract function addCmOptions(array $cm_options = array()): PrayerTimesBuilderInterface;

    /**
     * @param array $calc_options
     * @return PrayerTimesBuilderInterface
     */
    public abstract function addCalcOptions(array $calc_options = array()): PrayerTimesBuilderInterface;

    /**
     * @return PrayerTimesBuilderInterface
     */
    protected function addCustomCalculator(PrTCalculatorInterface $calc): PrayerTimesBuilderInterface
    {
        $this->calculator = $calc;
        $this->prayerTimes = new PrayerTimes($this->calculator);
        return $this;
    }

}