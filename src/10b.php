<?php

$input = getInput('10.txt');

$pairs = [
    '(' => ')',
    '[' => ']',
    '{' => '}',
    '<' => '>'
];
$values = [
    ')' => 1,
    ']' => 2,
    '}' => 3,
    '>' => 4
];
$errors = [];
$scores = [];
foreach($input as $line){
    $closures = [];
    foreach(str_split($line) as $char){
        if(isset($pairs[$char])){ //is opening
            $closures[] = $pairs[$char];
        }elseif(end($closures) !== $char){ //is corrupted
            $errors[] = $char;
            continue 2;
        }else{
            array_pop($closures);
        }
    }
    $score = 0;
    $closures = array_reverse($closures);
    foreach($closures as $closure){
        $score = ($score * 5) + $values[$closure];
    }
    $scores[] = $score;
}
sort($scores);
outputLine($scores[floor(count($scores)/2)]);
die();

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