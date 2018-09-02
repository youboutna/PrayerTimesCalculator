<?php
/**
 * Created by PhpStorm.
 * User: sofian
 * Date: 05/08/2018
 * Time: 14:41
 */

namespace PTCalculator\PrayerTimes;


use PTCalculator\Calculation\PrTCalculatorInterface;

interface PrayerTimesInterface
{
    public function setLatitude(float $lat): PrayerTimesInterface;

    public function setLongitude(float $long): PrayerTimesInterface;

    public function setDate(\DateTimeImmutable $date): PrayerTimesInterface;

    public function setTimeZone(\DateTimeZone $timeZone): PrayerTimesInterface;

    public function setCalculator(PrTCalculatorInterface $calc): PrayerTimesInterface;

    public function setOutputFormat(string $outputFormat): PrayerTimesInterface;

    public function getDate(): \DateTimeImmutable;

    public function getTimeZone(): \DateTimeZone;

    public function getCalculator(): PrTCalculatorInterface;

    public function getTodayPrayerTimes();

    public function getFajr();

    public function getSunrise();

    public function getDhuhr();

    public function getAsr();

    public function getSunset();

    public function getMaghrib();

    public function getIsha();
}