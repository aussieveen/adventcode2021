<?php

$input = getInput('9.txt');

foreach($input as $line){
    $row = str_split($line);
    foreach($row as $i => $cell){
        $row[$i] = (int)$cell;
    }
    $map[] = $row;
}
global $maxRow;
global $maxCol;
$maxRow = count($map) - 1;
$maxCol = count($map[0]) - 1;
$basins = [];

foreach ($map as $r => $row){
    foreach($row as $c => $number){
        if($number === 9){
            continue;
        }
        if($r !== 0 && $map[$r-1][$c] <= $number){
            continue;
        }
        if($r !== $maxRow && $map[$r+1][$c] <= $number){
            continue;
        }
        if($c !== 0 && $map[$r][$c-1] <= $number){
            continue;
        }
        if($c !== $maxCol && $map[$r][$c+1] <= $number){
            continue;
        }
        $size = array_sum(array_map("count", (scanBasin($r, $c))));
        if(count($basins) !== 3){
            $basins[] = $size;
        }else{
            $l = $basins[0];
            $k = 0;
            foreach([1,2] as $key){
                if($basins[$key] < $l){
                    $k = $key;
                    $l = $basins[$key];
                }
            }
            if($basins[$k] < $size){
                $basins[$k] = $size;
            }
        }
    }
}

outputLine($basins[0] * $basins[1] * $basins[2]);

function scanBasin($row, $col, array $scanned = []){
    global $map;
    global $maxRow;
    global $maxCol;
    $scanned[$row][$col] = true;
    if($row !== 0 && ($map[$row - 1][$col] !== 9  && !isset($scanned[$row-1][$col]))){
        $scanned = scanBasin($row-1, $col, $scanned);
    }

    if($col !== $maxCol && ($map[$row][$col + 1] !== 9  && !isset($scanned[$row][$col + 1]))){
        $scanned = scanBasin($row, $col + 1, $scanned);
    }

    if($row !== $maxRow && ($map[$row + 1][$col] !== 9  && !isset($scanned[$row + 1][$col]))){
        $scanned = scanBasin($row + 1, $col, $scanned);
    }

    if($col !== 0 && ($map[$row][$col - 1] !== 9  && !isset($scanned[$row][$col - 1]))){
        $scanned = scanBasin($row, $col - 1, $scanned);
    }

    return $scanned;
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