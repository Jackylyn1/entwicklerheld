<?php 
/*Objective
Let's give Jordi a little rest and take a closer look at the problem with the inbox.
Obviously there are periods when Santa has official working hours and can receive mail and there are the other times, Old Men's Lapland '06 ... well, you have heard of it... - So we need an implementation of how to deliver the mail that arrives out of hours to Santa at the right time. But let's go step by step.
Discuss this challenge in our subreddit
Lost your progress or you want to start from scratch? You can find the initial state of the source file here: Initial State

Scenario 1: Business hours
Regular business hours are from 8:00 to 16:00.
All mail received during this time can be processed immediately.
Any mail received before 8:00 will be scheduled to 8:00.
Those received after 15:59 will be dated to the next day at 8:00.
A mail received on 05.08.2021 at 5:00 should be scheduled to 8:00 on the same day.
A mail received on 15.07.2021 at 16:22 should be scheduled to 8:00 on 16.07.2021.
Your implementation should also work on other dates and times.

Scenario 2: Weekends
Mail is processed only during the week from Monday to Friday.
A mail received on Sunday 28.02.2021 should be scheduled to Monday 01.03.2021.
Your implementation should also work on other dates and times.

Scenario 3: Holidays
Mail is also not processed on holidays and vacation periods.
For this there is an array $HOLIDAY_LIST, where all dates can be found.
Each entry contains the name, the first and the last day of this vacation period.
$HOLIDAY_LIST = [
    ...
    [
        "name" => "new year",
        "start" => ["day" => 1, "month" => 1],
        "end" => ["day" => 6, "month" => 1],
    ],
    ...
]
            

A mail received on 02.01.2021 should be scheduled to 07.01.2021.
Your implementation should also work on other dates and times. */

declare(strict_types=1);
include("holidays.php");

function calculateTime(DateTime $time_of_arrival){
    $hour = $time_of_arrival->format('H');
    if($hour < 16 && $hour >= 8){
        return $time_of_arrival;
    }
    $time_of_arrival = startTime(clone $time_of_arrival);
    if($hour >= 16){
        return $time_of_arrival->add(new DateInterval('P1D'));
    }
    return $time_of_arrival;
}

function calculateWeekday($time_of_arrival){
    if(in_array($time_of_arrival->format('w'),[6,0])){
        $time_of_arrival->modify('next Monday');
        $time_of_arrival = startTime(clone $time_of_arrival);
    }
    return $time_of_arrival;
}

function getHolidayDate(array $date, string $year){
    return new DateTime("{$year}-{$date['month']}-{$date['day']}");
}

function ignoreHolidays(DateTime $time_of_arrival){
    global $HOLIDAY_LIST;
    foreach($HOLIDAY_LIST as $holiday){
        $currentYear = $time_of_arrival->format('Y');
        $startDateTime = getHolidayDate($holiday['start'], $currentYear);
        $endDateTime = getHolidayDate($holiday['end'], $currentYear);
        $endDateTime->setTime(23, 59, 59);
        if ($endDateTime < $startDateTime) {
            $endDateTime->modify('+1 year');
        }
        if($time_of_arrival >= $startDateTime && $time_of_arrival <= $endDateTime){
            $time_of_arrival = $endDateTime->modify('+1 day');
            $time_of_arrival = startTime(clone $time_of_arrival);
        }
    }
    return $time_of_arrival;
}

function startTime(DateTime $time_of_arrival){
    $time_of_arrival->setTime(8, 0, 0);
    return $time_of_arrival;
}

function calculated_time_to_process(DateTime $time_of_arrival):  DateTime {
    $time_of_arrival = calculateTime(clone $time_of_arrival);
    $time_of_arrival = calculateWeekday(clone $time_of_arrival);
    $time_of_arrival = ignoreHolidays(clone $time_of_arrival);
    return $time_of_arrival;
}
?>