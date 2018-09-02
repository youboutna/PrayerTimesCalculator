<?php
/**
 * Created by PhpStorm.
 * User: sofian
 * Date: 30/07/2018
 * Time: 14:34
 */

namespace PTCalculator\PrayerTimes;

use DateTimeZone;
use PTCalculator\Calculation\Enums\CalculationPoints;
use PTCalculator\Calculation\PrTCalculatorInterface;
use PTCalculator\Utils\JdateUtils;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PrayerTimes implements PrayerTimesInterface
{
    /**
     * @var PrTCalculatorInterface
     */
    private $calculator;

    /**
     * @var string
     */
    private $outputFormat;

    /**
     * PrayerTimes constructor.
     */
    public function __construct(PrTCalculatorInterface $calc, array $options = array())
    {
        $this->outputFormat = 'array';
        $this->calculator = $calc;
    }

    public function getFajr(){
        return $this->calculator->computeDayTimes()[0];
    }

    public function getSunrise(){
        return $this->calculator->computeDayTimes()[1];
    }

    public function getDhuhr(){
        return $this->calculator->computeDayTimes()[2];
    }

    public function getAsr(){
        return $this->calculator->computeDayTimes()[3];
    }

    public function getSunset(){
        return $this->calculator->computeDayTimes()[4];
    }

    public function getMaghrib(){
        return $this->calculator->computeDayTimes()[5];
    }

    public function getIsha(){
        return $this->calculator->computeDayTimes()[6];
    }

    /**
     * @return string
     */
    public function getOutputFormat(): string
    {
        return $this->outputFormat;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getDate(): \DateTimeImmutable
    {
        return $this->calculator->getDate();
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getTimeZone(): DateTimeZone
    {
        return $this->calculator->getTimeZone();
    }

    /**
     * @return PrTCalculatorInterface
     */
    public function getCalculator(): PrTCalculatorInterface
    {
        return $this->calculator;
    }

    /**
     * @param PrTCalculatorInterface $calculator
     * @return PrayerTimesInterface
     */
    public function setCalculator(PrTCalculatorInterface $calculator): PrayerTimesInterface
    {
        $this->calculator = $calculator;
        return $this;
    }

    /**
     * @param \DateTime $date
     * @return PrayerTimesInterface
     * @throws \Exception
     */
    public function setDate(\DateTimeImmutable $date): PrayerTimesInterface
    {
        $this->calculator->setDate($date);
        return $this;
    }

    /**
     * @param \DateTimeZone $timeZone
     * @return PrayerTimesInterface
     */
    public function setTimeZone(\DateTimeZone $timeZone): PrayerTimesInterface
    {
        $this->calculator->setTimeZone($timeZone);
        return $this;
    }

    /**
     * @param float $lat
     * @return PrayerTimesInterface
     */
    public function setLatitude(float $lat): PrayerTimesInterface
    {
        $this->calculator->setLatitude($lat);
        return $this;
    }

    /**
     * @param float $long
     * @return PrayerTimesInterface
     */
    public function setLongitude(float $long): PrayerTimesInterface
    {
        $this->calculator->setLongitude($long);
        return $this;
    }

    /**
     * @param string $outputFormat
     * @return PrayerTimesInterface
     */
    public function setOutputFormat(string $outputFormat): PrayerTimesInterface
    {
        $this->outputFormat = $outputFormat;
        return $this;
    }


    /**
     * @param string $outputFormat
     * @return array
     * @throws \Exception
     */
    public function getTodayPrayerTimes()
    {
        if ($this->outputFormat === 'array'){
            return array_combine(CalculationPoints::$calculationPoints, $this->calculator->computeDayTimes());

        }
        if ($this->outputFormat === 'json'){
            return json_encode(array_combine(CalculationPoints::$calculationPoints, $this->calculator->computeDayTimes()));
        }
        else{
            throw new \Exception('Requested input format not implemented');
        }
    }
}