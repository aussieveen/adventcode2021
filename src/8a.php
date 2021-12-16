<?php

$input = getInput('8.txt');
$dictionary = [
    2 => 1,
    3 => 7,
    4 => 4,
    7 => 8
];

$sum = 0;
foreach($input as $line){
    $sum += getSimpleDigitsCount($line, $dictionary);
}
outputLine($sum);

function getSimpleDigitsCount(string $line, $dictionary):int
{
    $line = str_replace("\r", "", $line);
    $line = str_replace("\n", "", $line);
    $sum = 0;
    $parts = explode(' | ', $line);
    foreach(explode(' ', $parts[1]) as $displayDigit){
        if(in_array(strlen($displayDigit), array_keys($dictionary))){
            $sum++;
        }
    }
    return $sum;
}

function getInput(string $filename): array
{
    $inputFile = fopen($filename, 'r');
    $inputs = [];
    while (($line = fgets($inputFile)) !== false) {
        $inputs[] = $line;
    }
    fclose($inputFile);
    return $inputs;
}

function outputLine($string){
    echo $string . PHP_EOL;
}