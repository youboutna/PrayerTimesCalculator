<?php
/**
 * Created by PhpStorm.
 * User: sofian
 * Date: 01/08/2018
 * Time: 23:19
 */

namespace PTCalculator\PrayerTimes\Builder;

use Calculator;
use PTCalculator\Calculation\PrTCalculator;
use PTCalculator\Calculation\PrTCalculatorInterface;
use PTCalculator\PrayerTimes\PrayerTimes;
use PTCalculator\PrayerTimes\PrayerTimesInterface;
use PTCalculator\Utils\JdateUtils;

class ToulousePrayerTimesBuilder extends AbstractPrayerTimesBuilder implements PrayerTimesBuilderInterface
{
    /**
     * MWLPrTBuilder constructor.
     * @param float $lat
     * @param float $long
     * @throws \Exception
     */
    public function __construct()
    {
        $timeZoneDefault = new \DateTimeZone('Europe/Paris');
        $start_date = \DateTimeImmutable::createFromFormat("d-m-Y", "01-05-2018");
        $this->calculator = new PrTCalculator(
            $start_date,
            43.578137,
            1.443246,
            $timeZoneDefault
        );
        $this->addCmOptions();
        $this->addCalcOptions();
        $this->prayerTimes = new PrayerTimes($this->calculator);
    }
    /**
     * @param array $cm_options
     * @return PrayerTimesBuilderInterface
     */
    public function addCmOptions(array $cm_options = array()): PrayerTimesBuilderInterface
    {
        if (empty($cm_options)){
            $cm_options = array(
                'method_name'     => "Toulouse",
                'fajr_angle' => 18, // deg
                'maghrib_selector'     => 1, //(0 = angle; 1 = min after sunset)
                'maghrib_parameter_value' => 3, //(deg or min)
                'isha_selector'     => 0, //(0 = angle; 1 = min after maghrib)
                'isha_parameter_value' => 16 //(deg or min)
            );
        }
        $this->calculator->getCmOptions()->configureOptions($cm_options);
        return $this;
    }

    /**
     * @param array $calc_options
     * @return PrayerTimesBuilderInterface
     */
    public function addCalcOptions(array $calc_options = array()): PrayerTimesBuilderInterface
    {
        if (empty($calc_options)){
            $calc_options = $defaultOptions = array(
                'asr_juristic_method_handler' => 0,
                'number_of_iterations' => 1,
                'dhuhr_minutes_offset' => 1,
                'adjust_high_latitudes_method_handler' => 0,
                'time_format_id_handler' => 0
            );
        }
        $this->calculator->getOptions()->configureOptions($calc_options);
        return $this;
    }

    /**
     * @return PrTCalculatorInterface
     */
    public function getPrayerTimes(): PrayerTimesInterface
    {
        return $this->prayerTimes;
    }
}