<?php

/**
 * Get winner
 *
 * Return the winner of a game containing multiple rounds
 *
 * @param array[] $input The input containing rounds
 *
 * @return string
 */

function getWinner(array $input): string
{
    $brotherA = 0;
    $brotherB = 0;

    foreach ($input as [$cardA, $cardB]) {
        if ($cardA > $cardB) {
            $brotherA++;
        } else if ($cardA < $cardB) {
            $brotherB++;
        }
    }
    if ($brotherA > $brotherB) {
        return 'A';
    }
    return 'B';
}

function marcoWinner(array $input): string
{
    $brotherA = 0;
    $brotherB = 0;

    foreach ($input as [$cardA, $cardB]) {
        if ($cardA > $cardB) {
            $brotherA++;
        } else if ($cardA < $cardB) {
            $brotherB++;
        }
    }

        return $brotherA > $brotherB ? 'A' : 'B';

}

//$winner = getWinner($input);
$winner = marcoWinner($input);
