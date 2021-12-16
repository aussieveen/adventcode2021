<?php

$input = getInput('10.txt');

$pairs = [
    '(' => ')',
    '[' => ']',
    '{' => '}',
    '<' => '>'
];
$values = [
    ')' => 3,
    ']' => 57,
    '}' => 1197,
    '>' => 25137
];
$errors = [];
foreach($input as $line){
    $closures = [];
    foreach(str_split($line) as $char){
        if(isset($pairs[$char])){ //is opening
            $closures[] = $pairs[$char];
        }elseif(end($closures) !== $char){ //is corrupted
            $errors[] = $char;
            break;
        }else{
            array_pop($closures);
        }
    }
}
$sum = 0;
foreach($errors as $error){
    $sum += $values[$error];
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