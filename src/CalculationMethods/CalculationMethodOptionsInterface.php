<?php
/**
 * Created by PhpStorm.
 * User: sofian
 * Date: 10/08/2018
 * Time: 21:24
 */

namespace PTCalculator\CalculationMethods;


interface CalculationMethodOptionsInterface
{
    public function getFajrAngle(): float;

    public function getMaghribSelector(): int;

    public function getMaghribParameterValue(): float;

    public function getIshaSelector(): int;

    public function getIshaParameterValue(): float;

    public function getLabel(): string;

    public function configureOptions(array $options);

}