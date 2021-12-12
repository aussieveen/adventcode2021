<?php

$input = getInput('s1.txt');

foreach($input as $line){
    echo $line . PHP_EOL;
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