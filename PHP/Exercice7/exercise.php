<?php

function divide(float $dividend, float $divisor) : float
{
    if ($divisor == 0){
        throw new RuntimeException('Division by 0 is not allowed');
    } else {
        return $dividend/$divisor;
    }

}

function arrayDivide(array $array, float $divisor) : array
{
    $result = [];
    try {
      foreach ($array as $number){
          $result[] =  divide($number, $divisor);
      }
        return $result;
    } catch (Exception $exception){
        return $array;
    }

}

