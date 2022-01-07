<?php

$input = getInput('14.txt');
$rules = [];

foreach($input as $n => $line){
    if($n === 0){
        $polymer = str_split($line);
    }elseif($n >= 2){
        $r = explode(' -> ', $line);
        $rules[$r[0]][] = $r[1];
    }
}
$step = 0;
while($step < 40){
    outputLine($step);
    $polymerEnd = false;
    $i = 0;
    while(!$polymerEnd){
        if(!isset($polymer[$i+1])){
            $polymerEnd = true;
            continue;
        }
        if(isset($rules[$polymer[$i] . $polymer[$i+1]])){
            $polymer = array_merge(array_slice($polymer, 0, $i + 1),$rules[$polymer[$i] . $polymer[$i+1]],array_slice($polymer, $i + 1, count($polymer) - 1));
            $i++;
        }
        $i++;
    }
    $step++;
}

$counts = [];
foreach($polymer as $p){
    $counts[$p] = isset($counts[$p]) ? $counts[$p] + 1 : 1;
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