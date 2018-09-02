<?php
/**
 * Created by PhpStorm.
 * User: sofian
 * Date: 30/07/2018
 * Time: 14:41
 */

namespace PTCalculator\Calculation;

use DateTimeImmutable;
use DateTimeZone;
use PTCalculator\Calculation\SunPosition\SunPosition;
use PTCalculator\Calculation\SunPosition\SunPositionInterface;
use PTCalculator\CalculationMethods\CalculationMethodOptions;
use PTCalculator\CalculationMethods\CalculationMethodOptionsInterface;
use PTCalculator\Utils\JdateUtils;
use PTCalculator\Utils\MathsUtils;

class PrTCalculator implements PrTCalculatorInterface
{
    /**
     * @var SunPositionInterface
     */
    private $sunPos;

    /**
     * @var CalculationMethodOptionsInterface
     */
    private $cm_options;

    /**
     * @var CalculationOptions
     */
    private $options;

    /**
     * @var DateTimeImmutable
     */
    private $date;

        /**
     * @var float
     */
    private $jDate;

    /**
     * @var int
     */
    private $timeZoneHours;

    /**
     * @var \DateTimeZone
     */
    private $timeZone;

    /**
     * @var float
     */
    private $latitude;

    /**
     * @var float
     */
    private $longitude;

    /**
     * PrTCalculator constructor.
     * @param float $jDate
     * @param float $lat
     * @param float $long
     * @param int $timeZoneHours
     * @param int $timeFormat
     * @throws \Exception
     */
    public function __construct(DateTimeImmutable $date, float $lat, float $long, DateTimeZone $tz,
                                SunPositionInterface $customSunPos = null){
        $this->latitude = $lat;
        $this->longitude = $long;
        $this->timeZone = new DateTimeZone("Europe/Paris");
        $this->setdate($date);
        $this->setTimeZone($tz);
        ($customSunPos === null)
            ? $this->sunPos = new SunPosition($this->jDate)
            : $this->sunPos = $customSunPos;
        $this->setOptions(new CalculationOptions());
        $this->setCmOptions(new CalculationMethodOptions());
    }

    /************************************************************************
     * GETTERS
     ************************************************************************/


    /**
     * @return SunPosition
     */
    public function getSunPos(): SunPositionInterface
    {
        return $this->sunPos;
    }

    /**
     * @return CalculationMethodOptionsInterface
     */
    public function getCmOptions(): CalculationMethodOptionsInterface
    {
        return $this->cm_options;
    }

    /**
     * @return CalculationOptions
     */
    public function getOptions(): CalculationOptionsInterface
    {
        return $this->options;
    }

    /**
     * @return float
     */
    public function getAdjustedJDate(): float
    {
        return $this->jDate;
    }

    /**
     * @return int
     */
    public function getTimeZoneHours(): int
    {
        return $this->timeZoneHours;
    }

    /**
     * @return float
     */
    public function getLatitude(): float
    {
        return $this->latitude;
    }

    /**
     * @return float
     */
    public function getLongitude(): float
    {
        return $this->longitude;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getDate() : DateTimeImmutable
    {
        return $this->date;
    }

    /**
     * @return DateTimeZone
     */
    public function getTimeZone(): DateTimeZone
    {
       return $this->timeZone;
    }

    /************************************************************************
     * SETTERS
     ************************************************************************/

    /**
     * @return PrTCalculatorInterface
     * @throws \Exception
     */
    public function setDate(DateTimeImmutable $dti): PrTCalculatorInterface
    {
        $this->date = $dti;
        $this->jDate = JdateUtils::dateTimeToJDate($this->date);
        $this->handleTimeZoneHoursSync();
        return $this;
    }

    /**
     * @return PrTCalculatorInterface
     */
    public function setTimeZone(DateTimeZone $tz): PrTCalculatorInterface
    {
        $this->timeZone = $tz;
        $this->handleTimeZoneHoursSync();
        return $this;
    }

    /**
     * @param float $latitude
     */
    public function setLatitude(float $latitude): PrTCalculatorInterface
    {
        $this->latitude = $latitude;
        return $this;
    }

    /**
     * @param float $longitude
     */
    public function setLongitude(float $longitude): PrTCalculatorInterface
    {
        $this->longitude = $longitude;
        return $this;
    }

    /**
     * @param CalculationMethodOptionsInterface $cm_options
     * @return PrTCalculator
     */
    public function setCmOptions(CalculationMethodOptionsInterface $cm_options): PrTCalculatorInterface
    {
        $this->cm_options = $cm_options;
        return $this;
    }

    /**
     * @param CalculationOptionsInterface $options
     * @return PrTCalculator
     */
    public function setOptions(CalculationOptionsInterface $options): PrTCalculatorInterface
    {
        $this->options = $options;
        return $this;
    }



    /************************************************************************
     * PUBLIC METHODS
     ************************************************************************/



    /**
     * compute prayer times at given julian date
     * @return mixed
     */
    public function computeDayTimes(): array
    {
        $times= array(5, 6, 12, 13, 18, 18, 18);
        for ($i=1; $i<=$this->options->getNumIterations(); $i++){
            $times = $this->computeTimes($times);
        }
        $times = $this->adjustTimes($times);
        return $this->adjustTimesFormat($times);
    }

    /**
     * compute prayer times at given julian date
     * @param $times
     * @return array
     */
    public function computeTimes(array $times): array
    {
        $t = $this->dayPortion($times);
        $Fajr    = $this->computeTime(180.0 - $this->cm_options->getFajrAngle(), $t[0]);
        $Sunrise = $this->computeTime(180.0 - 0.833, $t[1]);
        $Dhuhr   = $this->computeMidDay($t[2]);
        $Asr     = $this->computeAsr(1 + $this->options->getAsrJuristic(), $t[3]);
        $Sunset  = $this->computeTime(0.833, $t[4]);
        $Maghrib = $this->computeTime($this->cm_options->getMaghribParameterValue(), $t[5]);
        $Isha    = $this->computeTime($this->cm_options->getIshaParameterValue(), $t[6]);
        return array($Fajr, $Sunrise, $Dhuhr, $Asr, $Sunset, $Maghrib, $Isha);
    }

    /************************************************************************
     * CLASS INTERNALS
     ************************************************************************/
    /**
     * @param float $jDate
     */
    protected function setJDate(float $jDate): PrTCalculatorInterface
    {
        $this->jDate = $jDate - $this->longitude/ (15* 24);
        //get sync sunPos with new jday
        $this->sunPos->setJday($this->jDate);
        return $this;
    }

    /**
     * @param int $timeZoneHours
     */
    protected function setTimeZoneHours(int $timeZoneHours): PrTCalculatorInterface
    {
        $this->timeZoneHours = $timeZoneHours;
        return $this;
    }

    /**
     * adjust times in a prayer time array
     * @param $times
     * @return mixed
     */
    protected function adjustTimes(array $times): array
    {
        for ($i=0; $i<7; $i++){
            $times[$i] += $this->timeZoneHours- $this->longitude/ 15;
        }
        $times[2] += $this->options->getDhuhrMinutes()/ 60; //Dhuhr
        if ($this->cm_options->getMaghribSelector() == 1){
            $times[5] = $times[4]+ $this->cm_options->getMaghribParameterValue()/ 60;
        } // Maghrib
        if ($this->cm_options->getIshaSelector() == 1){ // Isha
            $times[6] = $times[5]+ $this->cm_options->getIshaParameterValue()/ 60;
        }
        if ($this->options->getAdjustHighLatitudesMethodId() != 0){
            $times = $this->adjustHighLatTimes($times);
        }
        return $times;
    }

    /**
     * convert times array to given time format
     * @param $times
     * @return mixed
     */
    protected function adjustTimesFormat(array $times): array
    {
        if ($this->options->getTimeFormatId() == 3){
            return $times;
        }
        for ($i=0; $i<7; $i++){
            if ($this->options->getTimeFormatId() == 1){
                $times[$i] = MathsUtils::floatToTime12($times[$i]);
            }
            else if ($this->options->getTimeFormatId() == 2){
                $times[$i] = MathsUtils::floatToTime12($times[$i], true);
            }
            else{
                $times[$i] = MathsUtils::floatToTime24($times[$i]);
            }
        }
        return $times;
    }

    /**
     *  adjust Fajr, Isha and Maghrib for locations in higher latitudes
     * @param $times
     * @return mixed
     */
    protected function adjustHighLatTimes(array $times): array
    {
        $nightTime = MathsUtils::timeDiff($times[4], $times[1]); // sunset to sunrise

        // Adjust Fajr
        $FajrDiff = $this->nightPortion($this->cm_options->getFajrAngle())* $nightTime;
        if (is_nan($times[0]) || MathsUtils::timeDiff($times[0], $times[1]) > $FajrDiff)
            $times[0] = $times[1]- $FajrDiff;

        // Adjust Isha
        $IshaAngle = ($this->cm_options->getIshaSelector() == 0) ? $this->cm_options->getIshaParameterValue() : 18;
        $IshaDiff = $this->nightPortion($IshaAngle)* $nightTime;
        if (is_nan($times[6]) || MathsUtils::timeDiff($times[4], $times[6]) > $IshaDiff)
            $times[6] = $times[4]+ $IshaDiff;

        // Adjust Maghrib
        $MaghribAngle = ($this->cm_options->getMaghribSelector() == 0) ? $this->cm_options->getMaghribParameterValue() : 4;
        $MaghribDiff = $this->nightPortion($MaghribAngle)* $nightTime;
        if (is_nan($times[5]) || MathsUtils::timeDiff($times[4], $times[5]) > $MaghribDiff)
            $times[5] = $times[4]+ $MaghribDiff;

        return $times;
    }

    /**
     * the night portion used for adjusting times in higher latitudes
     * @param $angle
     * @return float|int
     */
    protected function nightPortion(float $angle): float
    {
        if ($this->options->getAdjustHighLatitudesMethodId() == 1){
            return 1/60* $angle;
        }
        if ($this->options->getAdjustHighLatitudesMethodId() == 2){
            return 1/2;
        }
        if ($this->options->getAdjustHighLatitudesMethodId() == 3){
            return 1 / 7;
        }else{
            return $angle;
        }
    }

    /**
     * convert hours to day portions
     * @param $times
     * @return mixed
     */
    protected function dayPortion(array $times): array
    {
        for ($i=0; $i<7; $i++){
            $times[$i] /= 24;
        }
        return $times;
    }


    /**
     * compute mid-day (Dhuhr, Zawal) time
     * @param $t
     * @return float
     */
    protected function computeMidDay(float $t): float
    {
        $T = $this->sunPos->getEquationOfTime($this->jDate + $t);
        $Z = MathsUtils::hoursRangeReduce(12 - $T);
        return (float) $Z;
    }

    /**
     * compute time for a given angle G
     * @param $G
     * @param $t
     * @return float
     */
    protected function computeTime(float $G, float $t): float
    {
        $D = $this->sunPos->getSunDeclination($this->jDate + $t);
        $Z = $this->computeMidDay($t);
        $V = 1/15* MathsUtils::darccos(
            (-MathsUtils::dsin($G)- MathsUtils::dsin($D)* MathsUtils::dsin($this->latitude))/
                (MathsUtils::dcos($D)* MathsUtils::dcos($this->latitude)));
        return (float) ($Z+ ($G > 90 ? -$V : $V));
    }

    /**
     * compute the time of Asr
     * @param $step
     * @param $t
     * @return float
     */
    protected function computeAsr(int $step, float $t): float  // Shafii: step=1, Hanafi: step=2
    {
        $D = $this->sunPos->getSunDeclination($this->jDate + $t);
        $G = -MathsUtils::darccot($step + MathsUtils::dtan(abs($this->latitude - $D)));
        return $this->computeTime($G, $t);
    }

    protected function handleTimeZoneHoursSync(): void
    {
        /**
         * $this->date (immutable) to mutable,
         */
        $mdate = new \DateTime();
        $mdate->setTimestamp($this->date->getTimestamp());
        $mdate->setTimezone($this->timeZone);
        /**
         * on recupere le decalage horaire (int secondes)
         */
        $this->timeZoneHours = $this->timeZone->getOffset($mdate)/3600;
        unset($mdate);
    }
}