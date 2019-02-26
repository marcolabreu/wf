<?php
/*
 * Get an array of strings containing all Mondays format in format 'Monday 1, Feb 2021'
 * for given month and year
 *
 * @param integer $year
 * @param integer $month
 * @return array|string
 */
function getAllMondaysOfMonth(int $year, int $month): array
{
    $mondays = [];
    $date = new DateTime("first monday of $year-$month");

    while ($date->format('m') == $month) {
        $mondays[] = $date->format('l j, M Y');
        $date->modify('+1 week');
    }

    return $mondays;
}


function mine(int $year, int $month): array
{
    $mondayStrings = []; 
    $mondayDates = getMondays($year, $month);

    foreach ($mondayDates as $monday) {
        array_push($mondayStrings, $monday->format("l j, M Y"));
    }

    return $mondayStrings;
}

function getMondays($year, $month)
{
    $firstMondayOfMonth = new DateTime("first monday of $year-$month");
    $lastMondayOfMonth = new DateTime("last monday of $year-$month");

    return new DatePeriod($firstMondayOfMonth,
        DateInterval::createFromDateString('next monday'),
        $lastMondayOfMonth->modify('+1 day')
    );
}
