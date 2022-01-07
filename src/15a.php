<?php

$input = getInput('15.txt');
$map = [];
foreach($input as $line){
    $row = [];
    foreach(str_split($line) as $char) {
        $row[] = (int)$char;
    }
    $map[] = $row;
}
$mx = count($map[0]) - 1;
$my = count($map) - 1;
outputMap($map);

$priorityQueue = [];

$found = false;
while(!$found){

}

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

function outputMap(array $map){
    foreach($map as $row){
        $s = '';
        foreach($row as $cell){
            $s .= $cell;
        }
        outputLine($s);
    }
    outputLine('');
}