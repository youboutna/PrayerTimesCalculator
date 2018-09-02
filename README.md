**Prayer Times Calculator** 
Adapted from http://praytimes.org/wiki/Code

- v0.0.2 : 
    + Start testSuite.
    + Refactored
    
- 1st version v0.0.1 : 
    Can calculate prayer times,
    accepting many params to customize calculation method
    and output format.
    
**Installation process** : 
```php
git clone https://github.com/sofian69009/PrayerTimesCalculator.git
cd PrayerTimesCalculator
composer install
```

**Usage**
```php
require_once __DIR__ . '/vendor/autoload.php';

//get builder
$toulouse_PrTbuilder = new ToulousePrayerTimesBuilder();

//get PrayerTimesFactory
$factory = new PrayerTimesFactory($toulouse_PrTbuilder);

//get PrayerTimes handler
$prayer_timesObject = $factory->getTodayPrayerTimes();

//change date
$prayer_timesObject->setDate(DateTimeImmutable::createFromFormat('d-m-Y', '01-01-2018'));

//get monthly prayer times
$monthPrayerTimes = $factory->getMonthPrayerTimes();
```
