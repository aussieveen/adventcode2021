<?php

$input = getInput('s13.txt');
$paper = [];
$hY = 0;
$hX = 0;
foreach($input as $line){
    preg_match('/([0-9]+),([0-9]+)/', $line, $coord);
    preg_match('/([x,y]{1})=([0-9]+)/', $line, $instruction);
    if(!empty($coord)){
        $paper[$coord[2]][$coord[1]] = '#';
        if($coord[2] > $hY){
            $hY = $coord[2];
        }
        if($coord[1] > $hX){
            $hX = $coord[1];
        }
    }
    if(!empty($instruction)){
        $axis = $instruction[1];
        $number = (int)$instruction[2];
        if($axis === 'x'){
            foreach($paper as $y => $row){
                for($x = $number + 1; $x <= $hX; $x++){
                    if(!isset($paper[$y][$x])){
                        continue;
                    }
                    $nX = foldEquation($x, $number);
                    if(isset($paper[$y][$x]) && $paper[$y][$x] === '#') {
                        $paper[$y][$nX] = $paper[$y][$x];
                        unset($paper[$y][$x]);
                    }
                }
            }
            $hX = $hX - $number;
        }
        if($axis === 'y'){
            unset($paper[$number]);
            for($y = $number + 1; $y <= $hY; $y++){
                if(!isset($paper[$y])){
                    continue;
                }
                $nY = foldEquation($y, $number);

                for($x = 0; $x <= $hX; $x++){
                    if(isset($paper[$y][$x]) && $paper[$y][$x] === '#') {
                        $paper[$nY][$x] = $paper[$y][$x];
                    }
                }
                unset($paper[$y]);
            }
            $hY = $hY - $number;
        }
    }
    if($line === ''){
//        outputMap($paper, $hY, $hX);
    }
}
outputMap($paper,$hY, $hX);
$sum = 0;
foreach($paper as $row){
    foreach($row as $cell){
        if($cell === '#'){
            $sum++;
        }
    }
}
outputLine($sum);

function foldEquation(int $r, int $n):int
{
    return $r - (2*($r-$n));
}

function outputMap(array $map, $hY, $hX){
    $y = 0;
    while($y <= $hY){
        $x = 0;
        while($x <= $hX){
            if(!isset($map[$y][$x])){
                $map[$y][$x] = '.';
            }
            $x++;
        }
        ksort($map[$y]);
        $y++;
    }
    ksort($map);
    foreach($map as $row){
        outputLine(implode('', $row));
    }
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