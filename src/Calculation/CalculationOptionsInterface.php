<?php
/**
 * Created by PhpStorm.
 * User: sofian
 * Date: 15/08/2018
 * Time: 16:48
 */

namespace PTCalculator\Calculation;


interface CalculationOptionsInterface
{
    /**
     * @return int
     */
    public function getAsrJuristic(): int;

    /**
     * @return int
     */
    public function getNumIterations(): int;

    /**
     * @return int
     */
    public function getDhuhrMinutes(): int;
    /**
     * @return int
     */
    public function getAdjustHighLatitudesMethodId(): int;
    /**
     * @return int
     */
    public function getTimeFormatId(): int;

    /**
     * @param array $options
     * @return mixed
     */
    public function configureOptions(array $options);
}