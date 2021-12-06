<?php

$input = getInput('input.txt');

$h = 0;
$d = 0;

foreach($input as $line){
    $p = explode(' ', $line);
    switch($p[0][0]){
        case('f'):
            $h += (int)$p[1];
            break;
        case('d'):
            $d += (int)$p[1];
            break;
        case('u'):
            $d -= (int)$p[1];
            break;
    }
}
echo $h * $d . PHP_EOL;

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