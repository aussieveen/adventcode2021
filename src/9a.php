<?php

$input = getInput('9.txt');

foreach($input as $line){
    $row = str_split($line);
    foreach($row as $i => $cell){
        $row[$i] = (int)$cell;
    }
    $map[] = $row;
}

$maxRow = count($map) - 1;
$maxCol = count($map[0]) - 1;
$sum = 0;
foreach ($map as $r => $row){
    foreach($row as $c => $number){
        if($number === 9){
            continue;
        }
        if($r !== 0 && $map[$r-1][$c] <= $number){
            continue;
        }
        if($r !== $maxRow && $map[$r+1][$c] <= $number){
            continue;
        }
        if($c !== 0 && $map[$r][$c-1] <= $number){
            continue;
        }
        if($c !== $maxCol && $map[$r][$c+1] <= $number){
            continue;
        }
        $sum += ($map[$r][$c] + 1);
    }
}

outputLine($sum);

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