<?php
/**
 * Created by PhpStorm.
 * User: sofian
 * Date: 05/08/2018
 * Time: 15:09
 */

namespace PTCalculator\Calculation;


use DateTimeImmutable;
use DateTimeZone;
use PTCalculator\Calculation\SunPosition\SunPositionInterface;
use PTCalculator\CalculationMethods\CalculationMethodOptionsInterface;

interface PrTCalculatorInterface
{

    /**
     * @return SunPositionInterface
     */
    public function getSunPos(): SunPositionInterface;

    /**
     * @return CalculationMethodOptionsInterface
     */
    public function getCmOptions(): CalculationMethodOptionsInterface;

    /**
     * @return CalculationOptions
     */
    public function getOptions(): CalculationOptionsInterface;

    /**
     * @return float
     */
    public function getAdjustedJDate(): float;

    /**
     * @return int
     */
    public function getTimeZoneHours(): int;

    /**
     * @return float
     */
    public function getLatitude(): float;

    /**
     * @return float
     */
    public function getLongitude(): float;

    /**
     * @return DateTimeImmutable
     */
    public function getDate() : DateTimeImmutable;

    /**
     * @return DateTimeZone
     */
    public function getTimeZone(): DateTimeZone;

    /**
     * @param DateTimeImmutable $dti
     * @return PrTCalculatorInterface
     */
    public function setDate(DateTimeImmutable $dti) : PrTCalculatorInterface;

    /**
     * @return PrTCalculatorInterface
     */
    public function setTimeZone(DateTimeZone $tz): PrTCalculatorInterface;

    /**
     * @param float $latitude
     * @return PrTCalculator
     */
    public function setLatitude(float $latitude): PrTCalculatorInterface;

    /**
     * @param float $longitude
     * @return PrTCalculator
     */
    public function setLongitude(float $longitude): PrTCalculatorInterface;

    /**
     * @param CalculationMethodOptionsInterface $cm_options
     * @return PrTCalculator
     */
    public function setCmOptions(CalculationMethodOptionsInterface $cm_options): PrTCalculatorInterface;

    /**
     * @param CalculationOptions $options
     * @return PrTCalculator
     */
    public function setOptions(CalculationOptionsInterface $options): PrTCalculatorInterface;

    /**
     * @return mixed
     */
    public function computeDayTimes();

}