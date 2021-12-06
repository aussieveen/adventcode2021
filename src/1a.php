<?php

$inputFile = fopen('input.txt', 'r');
$inputs = [];
while (($line = fgets($inputFile)) !== false) {
    $inputs[] = $line;
}
$prev = null;
$increase = 0;
foreach($inputs as $input){
    if ($prev !== null){
        if ($prev < (int)$input){
            $increase++;
        }
    }
    $prev = (int)$input;
}
echo $increase . PHP_EOL;

