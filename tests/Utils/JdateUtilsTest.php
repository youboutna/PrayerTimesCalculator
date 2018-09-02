<?php

use PHPUnit\Framework\TestCase;
use PTCalculator\Utils\JdateUtils;

/**
 * Created by PhpStorm.
 * User: sofian
 * Date: 07/08/2018
 * Time: 23:39
 */

class JdateUtilsTest extends TestCase
{
    /**
     * @dataProvider dateProvider
     * @throws Exception
     */
    public function testConvertValidDateToJulianDate($expected, $providedData): void
    {
        $this->assertEquals($expected, JdateUtils::dateTimeToJDate($providedData));
    }

    /**
     * @dataProvider badDateProvider
     * @throws Exception
     */
    public function testDateOutOfRangeErrorDate($providedData): void
    {
        $this->expectException(Exception::class);
        JdateUtils::dateTimeToJDate($providedData);

    }

    /**
     * @throws Exception
     */
    public function testGetTimeZoneHours(){
        $tz = new DateTimeZone("Asia/Kabul");
        $offset = floor($tz->getOffset(new \DateTime()) / 3600);
        $this->assertEquals($offset, JdateUtils::getTimeZoneHours($tz));
    }

    //#####################\\
    //###   PROVIDERS   ###\\
    //#####################\\

    public function dateProvider()
    {
        return [
            [2458337.500000, new DateTime("7-8-2018", new DateTimeZone('Asia/Gaza'))],
            [2458337.500000, new DateTime("7-8-2018", new DateTimeZone('Europe/Paris'))],
            [2458283.500000, new DateTime("14-6-2018", new DateTimeZone('Europe/Paris'))],
            [2458177.500000, new DateTime("28-2-2018", new DateTimeZone('Europe/Paris'))],
            [2460941.500000, new DateTime("23-9-2025", new DateTimeZone('Europe/Paris'))],
        ];
    }

    public function badDateProvider()
    {
        return [
            [new DateTime("7-8-1234", new DateTimeZone('Asia/Gaza'))],
            [new DateTime("7-8-1234", new DateTimeZone('Europe/Paris'))],
            [new DateTime("14-6-1925", new DateTimeZone('Europe/Paris'))],
            [new DateTime("15-12-0012", new DateTimeZone('Europe/Paris'))]
        ];
    }

}