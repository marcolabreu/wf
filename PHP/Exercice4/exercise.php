<?php
/*
 * Get an array of \DateTime objects for each day (specified) in a year and month
 *
 * @param integer $year
 * @param integer $month
 * @param integer $daysError    Number of days into month that requires inclusion of previous Monday
 * @return array|\DateTime[]
 */
function getAllDaysInAMonth(int $year, int $month) {

    $startDay = new \DateTime($dateString);

    if ($startDay->format('j') > $daysError) {
        $startDay->modify('- 7 days');
    }

    $mondays = array();

    while ($startDay->format('Y-m') <= $year.'-'.str_pad($month, 2, 0, STR_PAD_LEFT)) {
        $days[] = clone($startDay);
        $startDay->modify('+ 7 days');
    }

    return $mondays;
}