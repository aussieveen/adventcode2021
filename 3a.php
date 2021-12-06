<?php

$input = getInput('3.txt');

$counts = [];
foreach($input as $line){
    foreach(str_split($line) as $pos => $char){
        if(!in_array($char,['0','1'])){
            continue;
        }
        $counts[$pos][$char] = isset($counts[$pos][$char]) ? $counts[$pos][$char]+1 : 1;
    }
}
var_dump($counts);

$g = '';
$e = '';
foreach($counts as $pos => $count){
    if( $counts[$pos]['0'] > $counts[$pos]['1']){
        $g .= '0';
        $e .= '1';
    }else{
        $g .= '1';
        $e .= '0';
    }
}

echo bindec($g) * bindec($e) . PHP_EOL;

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
