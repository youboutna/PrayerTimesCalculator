<?php
/**
 * Created by PhpStorm.
 * User: sofian
 * Date: 30/07/2018
 * Time: 10:56
 */

namespace PTCalculator\Calculation\SunPosition;

use PTCalculator\Utils\MathsUtils;

/**
 * Simple algorithm for computing the Sun's angular coordinates
 * to an accuracy of about 1 arc/minute within two centuries of 2000.
 * The algorithm requires only the Julian date of the time
 * for which the Sun's coordinates are needed (Julian dates are a form of Universal Time.)
 *
 * http://aa.usno.navy.mil/faq/docs/SunApprox.html
 *
 * Class AstronomicalMeasures
 * @package PTCalcBundle\Services\PTCalculator\Calculation
 */
class SunPosition implements SunPositionInterface
{
    /**
     * @var float
     */
    private $equationOfTime;

    /**
     * @var float
     */
    private $sunDeclination;

    /**
     * @var float
     */
    private $jday;

    /**
     * SunPosition constructor.
     */
    public function __construct($jday)
    {
        $this->jday = $jday;
        $this->setSunPositions($this->jday);
    }

    /**
     * @return float
     */
    public function getJday(): float
    {
        return $this->jday;
    }

    /**
     * @param float $jday
     * @return SunPosition
     */
    public function setJday(float $jday): SunPositionInterface
    {
        $this->jday = $jday;
        $this->setSunPositions($jday);
        return $this;
    }

    /**
     * Recomputes sun positions and returns EoT if jday is changed,
     * else only returns EoT.
     * @param float|null $jday
     * @return float
     */
    public function getEquationOfTime(float $jday = null): float
    {
        if(is_null($jday) || $jday === $this->jday){
            return $this->equationOfTime;
        }else{
            $this->setSunPositions($jday);
            return $this->equationOfTime;
        }
    }

    /**
     * Recomputes sun positions and returns sun declination if jday is changed,
     * else only returns sun declination.
     * @return float
     */
    public function getSunDeclination(float $jday = null): float
    {
        if(is_null($jday) || $jday === $this->jday){
            return $this->sunDeclination;
        }else{
            $this->setSunPositions($jday);
            return $this->sunDeclination;
        }
    }

    /**
     * @param float $jd
     */
    private function setSunPositions(float $jd): void
    {
        $this->jday = $jd;
        //$D number of days from 01/01/2000
        $D = $this->jday - 2451545.0;
        // Mean anomaly of the sun, in degrees
        $g = MathsUtils::degreesRangeReduce(357.529 + 0.98560028 * $D);
        // Mean longitude of the sun, in degrees
        $q = MathsUtils::degreesRangeReduce(280.459 + 0.98564736 * $D);
        // Geocentric apparent ecliptic longitude of the sun, in degrees
        $L =
            MathsUtils::degreesRangeReduce($q + 1.915 *
                MathsUtils::dsin($g) + 0.020 * MathsUtils::dsin(2 * $g));
        // The distance of the Sun from the Earth, in astronomical units (AU), not used
        //$R = 1.00014 - 0.01671 * MathsUtils::dcos($g) - 0.00014 * MathsUtils::dcos(2 * $g);
        // The mean obliquity of the ecliptic in degree
        $e = 23.439 - 0.00000036 * $D;
        // Sun's declination
        $this->sunDeclination =
            (float) MathsUtils::darcsin(MathsUtils::dsin($e)* MathsUtils::dsin($L));
        // Sun's ascension
        $RA =
            MathsUtils::hoursRangeReduce(
                MathsUtils::darctan2(
                    MathsUtils::dcos($e) * MathsUtils::dsin($L),
                    MathsUtils::dcos($L))/ 15);
        // EQT apparent solar time minus mean solar time
        $this->equationOfTime = (float) ($q/15 - $RA);
    }
}