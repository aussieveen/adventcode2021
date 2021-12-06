<?php

$input = getInput('input.txt');

$increase = 0;
foreach($input as $line => $value){
    if ($line === 0){
        $readings[0][] = $value;
    }elseif ($line === 1){
        $readings[0][] = $value;
        $readings[1][] = $value;
    }else{
        for ($i = 0; $i < 4; $i++){
            if($i !== (($line + 1) % 4)){
                $readings[$i][] = $value;
            }
        }
        if($line >= 3){
            if(array_sum($readings[($line - 3) % 4]) < array_sum($readings[($line - 2) % 4])){
                $increase++;
            }
            unset($readings[($line - 3) % 4]);
        }
    }
}
echo $increase . PHP_EOL;

function getInput(string $filename): array
{
    $inputFile = fopen($filename, 'r');
    $inputs = [];
    while (($line = fgets($inputFile)) !== false) {
        $inputs[] = (int)$line;
    }
    fclose($inputFile);
    return $inputs;
}
