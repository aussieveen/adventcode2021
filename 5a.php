<?php

$input = getInput('s5.txt');
$map = [];
foreach($input as $line){
    $coords = preg_split('/([^0-9]+)/', $line);
    foreach($coords as $key => $value){
        $coords[$key] = (int)$value;
    }
    [$x1,$y1,$x2,$y2] = $coords;
    if($x1 === $x2){
        $n1 = $y1;
        $n2 = $y2;
        $u = $x1;
        $asRow = false;
    }else if($y1 === $y2){
        $n1 = $x1;
        $n2 = $x2;
        $u = $y1;
        $asRow = true;
    }else{
        continue;
    }
    $map = processMap($map, $asRow, $n1, $n2, $u);
}
foreach($map as $row){
    ksort($row);
}
ksort($map);
$j = 0;
while($j < 10){
    $i = 0;
    while($i < 10){
        echo isset($map[$j][$i]) ? $map[$j][$i] : ".";
        $i++;
    }
    echo PHP_EOL;
    $j++;
}

echo recursiveArrayCount($map) . PHP_EOL;

function processMap(array $map, bool $asRow, $n1, $n2, $u): array
{
    if($n1 < $n2){
        $start = $n1;
        $end = $n2;
    }else{
        $start = $n2;
        $end = $n1;
    }
    for($i = $start; $i <= $end; $i++){
        if($asRow){
            $map[$u][$i] = !isset($map[$u][$i]) ? 1 : $map[$u][$i]+=1 ;
        }else{
            $map[$i][$u] = !isset($map[$i][$u]) ? 1 : $map[$i][$u]+=1 ;
        }
    }
    return $map;
}

function recursiveArrayCount(array $array){
    $count = 0;
    foreach($array as $key => $value){
        if(is_array($value)){
            $count += recursiveArrayCount($value);
        }else{
            if($value >= 2){
                $count++;
            }
        }
    }
    return $count;
}

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