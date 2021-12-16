<?php
global $x,$y;
set_error_handler("myErrorHandler", E_NOTICE);
$input = getInput('6.txt');
$spawnSum = [];
foreach($input as $line) {
    $spawn = explode(',', $line);
}
foreach($spawn as $k => $v){
    $spawn[$k] = (int)$v;
}
foreach($spawn as $k => $v){
    $spawnSum[$v] = isset($spawnSum[$v]) ? $spawnSum[$v]+1 : 1;
}

ksort($spawnSum);
$day = 0;
while($day < 256){
    $nextDay = [];
    foreach($spawnSum as $k => $v){
        if($k === 0){
            $nextDay[6] = $v;
            $nextDay[8] = $v;
        }else if($k === 7){
            $nextDay[6] = isset($nextDay[6]) ? $nextDay[6] + $v : $v;
        }else{
            $x = $v;
            $y = $k;
            $nextDay[$k-1] = $v;
        }
    }
    ksort($nextDay);
    $spawnSum = $nextDay;
    $day++;
}

echo array_sum($spawnSum) . PHP_EOL;

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

function myErrorHandler($errno, $errstr, $errfile, $errline)
{
    global $x, $y;
    var_dump($x, $y);
    if ($errno == E_NOTICE) {
        die ("Fatal notice");
    }else {
        return false; // Leave everything else to PHP's error handling
    }
}