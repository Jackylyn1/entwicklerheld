<?php

/*
Objective
The Easter Bunny arrives every year, but unlike Santa Claus, the Easter Bunny appears rather out of the blue. However, the date is not quite so unexpected. It is irregular, but can be determined using a formula for any given year. Can you find such a formula?

Lost your progress or you want to start from scratch? You can find the initial state of the source file here: Initial State

Scenario 1: Easter Sunday
Easter Sunday is calculated as follows:
It is the first Sunday after the full moon after the beginning of spring. The beginning of spring is a fixed date, the day of the vernal equinox on March 21.
The earliest date for Easter Sunday could be March 22. The latest date for Easter Sunday may be April 25.
With this, everything is quite clear, and we can start calculating.
The function calculateEasterSunday should calculate the date of Easter Sunday for a given year and return it as java.util.Calendar object.
In 2022, Easter Sunday is April 17.
Your implementation should also work with other years.

Scenario 2: All Easter Holidays
With the calculation of Easter Sunday done, it is not hard to figure out the dates of Easter Monday and Good Friday.
In 2022, when Easter Sunday is on April 17, Easter Monday is one day later and Good Friday is two days before Easter Sunday.
Your function should return these three dates as a list of datetime objects: April 15, April 17 and April 18
Your implementation should also work with other years.
*/

declare(strict_types=1);

function getFullMoonCyclusTime(): float {
     return 29.530 * 86400;
}

function changeFullMoonTime(float $timestampFullMoon, float $timestampBeginningOfSpring):float {
    if($timestampFullMoon > $timestampBeginningOfSpring){ return -getFullMoonCyclusTime();}
    return getFullMoonCyclusTime();
}

function getNextFullMoon(int $timestampBeginningOfSpring){
    $timestampFullMoon = strtotime('04/16/2022');
    while(abs($timestampFullMoon - $timestampBeginningOfSpring) > getFullMoonCyclusTime() || $timestampFullMoon < $timestampBeginningOfSpring){
        $timestampFullMoon += changeFullMoonTime($timestampFullMoon, $timestampBeginningOfSpring);
    }
    $fullMoon = new DateTime();
    return $fullMoon->setTimestamp(intval(round($timestampFullMoon)));
}

function calculate_easter_sunday(int $year): DateTime {
    $timestampBeginningOfSpring = strtotime('03/21/' . $year);
    return getNextFullMoon($timestampBeginningOfSpring)->modify('next Sunday');
}

function calculate_easter_days(int $year): array {
    return [calculate_easter_sunday($year)->modify('-2 day'), calculate_easter_sunday($year), calculate_easter_sunday($year)->modify('+1 day')];
}

?>