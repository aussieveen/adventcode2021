<?php

$input = getInput('3.txt');


foreach($input as $line){
    $oxygenList = getBinaryList($input, 0, true);
    $co2List = getBinaryList($input, 0, false);
}

$oPos = 1;
$cPos = 1;
while (count($oxygenList) !== 1){
    $oxygenList = getBinaryList($oxygenList, $oPos++, true);
}
while (count($co2List) !== 1){
    $co2List = getBinaryList($co2List, $cPos++, false);
}

echo bindec($oxygenList[0]) * bindec($co2List[0]) . PHP_EOL;

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


function getBinaryList(array $list, int $pos, bool $mostCommon){
    $zero = [];
    $one = [];
    foreach($list as $item){
        if(!in_array($item[$pos],['0','1'])){
            continue;
        }
        if ($item[$pos] === '0'){
            $zero[] = $item;
        }else{
            $one[] = $item;
        }
    }
    if (count($zero) === count($one)){
        return $mostCommon ? $one : $zero;
    }

    if($mostCommon){
        return count($zero) > count($one) ? $zero : $one;
    }else{
        return count($zero) > count($one) ? $one : $zero;
    }
}