<?php
$password;
$salt;

$passLen = strlen($password);
$ceilPosition = ceil($passLen/2);
$floorPosition = floor($passLen/2) + $passLen%2;

$saltedPassword = substr($password, 0, $floorPosition) . $salt . substr($password, $ceilPosition);
