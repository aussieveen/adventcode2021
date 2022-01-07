<?php

$input = getInput('14.txt');
$rules = [];
$pairs = [];

foreach($input as $n => $line){
    if($n === 0){
        $polymer = str_split($line);
        $firstChar = $polymer[0];
    }elseif($n >= 2){
        $r = explode(' -> ', $line);
        $rules[$r[0]] = $r[1];
    }
}

for($i = 0; $i < count($polymer) - 1; $i++){
    $pairs[$polymer[$i] . $polymer[$i+1]] = isset($pairs[$polymer[$i] . $polymer[$i+1]]) ? $pairs[$polymer[$i] . $polymer[$i+1]] + 1 : 1;
}

$step = 0;
while($step < 40){
    $newPairs = [];
    foreach($pairs as $element => $count){
        if(!isset($rules[$element])){
           continue;
        }
        $elementParts = str_split($element);
        $newPairs[$elementParts[0] . $rules[$element]] = isset($newPairs[$elementParts[0] . $rules[$element]]) ? $newPairs[$elementParts[0] . $rules[$element]] + $count : $count;
        $newPairs[$rules[$element] . $elementParts[1]] = isset($newPairs[$rules[$element] . $elementParts[1]]) ? $newPairs[$rules[$element] . $elementParts[1]] + $count : $count;
        $newPairs[$element] = isset($newPairs[$element]) ? $newPairs[$element] : 0;
    }
    $pairs = $newPairs;
    $step++;
}

$counts[$firstChar] = 1;
foreach($pairs as $element => $count){
    $counts[$element[1]] = isset($counts[$element[1]]) ? $counts[$element[1]] + $count : $count;
}
sort($counts);
outputLine(end($counts) - reset($counts));


function getInput(string $filename): array
{
    $inputFile = fopen($filename, 'r');
    $inputs = [];
    while (($line = fgets($inputFile)) !== false) {
        $inputs[] = str_replace("\n", "", str_replace("\r", "", $line));
    }
    fclose($inputFile);
    return $inputs;
}

function outputLine($string){
    echo $string . PHP_EOL;
}