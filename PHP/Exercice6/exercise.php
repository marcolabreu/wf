<?php

function easterReverse(string $FilenameToEdit) {


    $fileContent = file_get_contents($FilenameToEdit);

    //echo "$fileContent";

    //echo "<br> HalfWay: ".floor(strlen($fileContent) / 2);


    $secondPart = substr($fileContent, floor(strlen($fileContent) / 2));
    $firstPart = substr($fileContent, 0, strlen($secondPart) - 1);

    //echo "<br>firstPart:<br>".$firstPart;

    //echo "<br>secondPart:<br>".$secondPart;

    //echo "<br>secondPartReversed:<br>".strrev($secondPart);

    $file = fopen($FilenameToEdit, 'r+');
    fseek($file, strlen($firstPart), SEEK_SET);
    fwrite($file, strrev($secondPart), strlen($secondPart));
    fclose($file);

}

function easterReverseBad($file)
{
    $fileSize = filesize($file);
    $middleFile = floor($fileSize / 2);
    $handle = fopen($file, "r");
    $secondPart = '';
    $fileContent = file_get_contents($file);

    fseek($handle, 0, SEEK_END);
    for ($i = $fileSize; $i > $middleFile; $i--) {
        fseek($handle, -2, SEEK_CUR);
        $secondPart .= fgetc($handle);
    }

    $firstPart = substr($fileContent, 0, strlen($secondPart) - 1);
    fseek($handle, strlen($firstPart), SEEK_SET);
    fwrite($handle, $secondPart, strlen($secondPart));
    fclose($handle);
}

easterReverse("file.txt");
