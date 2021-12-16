<?php

$input = getInput('7.txt');

$crabs = array_map('convertToInts', explode(',',$input[0]));

foreach($crabs as $k => $crab){
    $positions[$crab] = isset($positions[$crab]) ? $positions[$crab] + 1 : 1;
}

ksort($positions);
$minPosition = 0;
$maxPosition = array_key_last($positions);
$i = 1;
$min = processPosition($positions, 0);
while ($i <= $maxPosition){
    $fuel = processPosition($positions, $i);
    if($fuel > $min){
        echo $min;
        die();
    }else{
        $min = $fuel;
    }
    $i++;
}


function processPosition(array $positions, int $candidate){
    $fuel = 0;
    foreach($positions as $position => $count){
        $fuel += abs($position - $candidate) * $count;
    }
    return $fuel;
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

function convertToInts(string $n): int
{
    return (int)$n;
}