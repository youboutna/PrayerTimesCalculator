<?php
/**
 * Created by PhpStorm.
 * User: sofian
 * Date: 07/08/2018
 * Time: 16:41
 */

namespace PTCalculator\PrayerTimes;


use DateInterval;
use DateTime;
use PTCalculator\Calculation\PrTCalculator;
use PTCalculator\PrayerTimes\Builder\PrayerTimesBuilderInterface;
use PTCalculator\Utils\JdateUtils;

class PrayerTimesFactory
{

    /**
     * @var
     */
    private $builder;

    public function __construct(PrayerTimesBuilderInterface $builder)
    {
        $this->builder = $builder;
    }

    /**
     * @return PrayerTimesInterface
     */
    public function getTodayPrayerTimes($outputFormat = null): PrayerTimesInterface
    {
        if(is_null($outputFormat)){
            return $this->builder->getPrayerTimes();
        }else{
            return $this->builder->getPrayerTimes()->setOutputFormat($outputFormat);
        }
    }

    /**
     * @param $outputFormat
     * @throws \Exception
     */
    public function getCurrentMonthPrayerTimes()
    {
        $month = $this->builder->getPrayerTimes()->getDate()->format('m');
        $year = $this->builder->getPrayerTimes()->getDate()->format('y');
        $currentMonthDayCount = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $oneDayInterval = new \DateInterval("P1D");
        $enddate = $this->builder->getPrayerTimes()->getDate()->add(new \DateInterval("P".$currentMonthDayCount."D"));
        $oneMonth = new \DatePeriod(
            $this->builder->getPrayerTimes()->getDate(),
            $oneDayInterval,
            $enddate
        );
        $tabResult = array();

        foreach($oneMonth as $day){
            $tabResult[] = array(
                'date' => $day->format('d-m-Y'),
                'prayer_times' => $this->builder->getPrayerTimes()->getTodayPrayerTimes()
            );
            //inc one day
            $nextday = $this->builder->getPrayerTimes()->getDate()->add($oneDayInterval);
            $this->builder->getPrayerTimes()->setDate($nextday);
        }
        return $tabResult;
    }

    /**
     * @param $outputFormat
     */
    public function getCurrentYearPrayerTimes($outputFormat)
    {
        //TODO implement that
    }
}