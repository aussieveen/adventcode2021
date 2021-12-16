<?php

$input = getInput('8.txt');
global $dictionary;
$dictionary = [
    0 => [0,1,2,4,5,6],
    1 => [2,5],
    2 => [0,2,3,4,6],
    3 => [0,2,3,5,6],
    4 => [1,2,3,5],
    5 => [0,1,3,5,6],
    6 => [0,1,3,4,5,6],
    7 => [0,2,5],
    8 => [0,1,2,3,4,5,6],
    9 => [0,1,2,3,5,6]
];

$sum = 0;
foreach($input as $line){
    $parts = explode(' | ', $line);
    $signalDecoded = getDecodedSignal(explode(' ', $parts[0]));
    $translatedDictionary = translateDictionary($dictionary, $signalDecoded);
    $sum += getNumber($translatedDictionary, $parts[1]);
}
outputLine($sum);

function getNumber(array $translatedDictionary, string $numbers):int {
    $numbers = explode(' ', $numbers);
    $n = '';
    foreach($numbers as $number){
        foreach($translatedDictionary as $key => $entry){
            if(count($entry) === strlen($number)){
                $diff = array_diff($entry, str_split($number));
                if(count($diff) === 0){
                    $n .= $key;
                    continue 2;
                }
            }
        }
    }
    return (int)$n;
}

function translateDictionary(array $dictionary, array $signalDecoded){
    foreach($dictionary as $number => $entry){
        foreach($entry as $k => $pos){
            $dictionary[$number][$k] = $signalDecoded[$pos];
        }
    }
    return $dictionary;
}

function getDecodedSignal(array $signals):array
{
    $groupedSignals = [];
    foreach($signals as $signal){
        $groupedSignals[strlen($signal)][] = $signal;
    }
    ksort($groupedSignals);
    $deduced = [];

    $diff = array_diff(str_split($groupedSignals[3][0]), str_split($groupedSignals[2][0]));
    $deduced[0] = array_shift($diff);

    foreach($groupedSignals[5] as $k => $v){
        if(count(array_diff(str_split($groupedSignals[5][$k]), str_split($groupedSignals[3][0]))) === 2){
            $three = $v;
            unset($groupedSignals[5][$k]);
            break;
        }
    }

    foreach($groupedSignals[5] as $k => $v){
        $diff = array_diff(str_split($groupedSignals[4][0]), str_split($groupedSignals[5][$k]));
        if(count($diff) === 1){
            $five = $v;
            unset($groupedSignals[5][$k]);
            $deduced[2] = array_shift($diff);
            break;
        }
    }

    $diff = array_diff(str_split($groupedSignals[4][0]), str_split($three));
    $deduced[1] = array_shift($diff);

    $diff = array_diff(str_split($groupedSignals[2][0]), [$deduced[2]]);
    $deduced[5] = array_shift($diff);

    $diff = array_diff(str_split($groupedSignals[4][0]), $deduced);
    $deduced[3] = array_shift($diff);

    $diff = array_diff(str_split($five), $deduced);
    $deduced[6] = array_shift($diff);

    $diff = array_diff(str_split('abcdefg'), $deduced);
    $deduced[4] = array_shift($diff);

    return $deduced;
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