<?php
/**
 * Created by PhpStorm.
 * User: sofian
 * Date: 05/08/2018
 * Time: 14:08
 */

namespace PTCalculator\Calculation\SunPosition;


interface SunPositionInterface
{
    public function getJday() : float;

    public function setJday(float $julianDate): SunPositionInterface;

    public function getEquationOfTime(float $julianDate = null) : float;

    public function getSunDeclination(float $julianDate = null) : float;
}