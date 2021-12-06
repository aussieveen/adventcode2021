<?php

$input = getInput('4.txt');
$boards = [];
$boardCount = 0;
foreach($input as $lineNumber => $line){
    if($line === PHP_EOL){
        $boardCount++;
        continue;
    }

    if($lineNumber === 0){
        $numbers = explode(',', $line);
        continue;
    }

    preg_match_all('/[0-9]+/', $line, $match);
    $boards[$boardCount][] = $match[0];
}

foreach($numbers as $n => $number){
    foreach($boards as $b => $board){
        foreach($board as $r => $row){
            if(false !== $c = array_search($number, $row)){
                $boards[$b][$r][$c] = 'x';
                if (checkBingo($boards[$b])) {
                    $winningBoard = $boards[$b];
                    unset($boards[$b]);
                    if(count($boards) === 0){
                        var_dump($winningBoard);
                        break 3;
                    }
                    break 1;
                }
            }
        }
    }
}

$sum = 0;
foreach($winningBoard as $i => $values){
    if(!empty($values)) {
        foreach ($values as $j => $value) {
            if($value !== 'x') {
                $sum += (int)$value;
            }
        }
    }
}
echo $sum * (int)$number . PHP_EOL;

function checkBingo(array $board):bool
{
    foreach($board as $r => $row){
        $xCount = 0;
        foreach($row as $cell){
            if($cell !== 'x'){
                $xCount = 0;
                continue;
            }
            $xCount++;
            if($xCount === 5){
                return true;
            }
        }
        $xCount = 0;
        for($c = 0; $c < 5; $c++){
            if($board[$c][$r] !== 'x'){
                $xCount = 0;
                continue;
            }
            $xCount++;
            if($xCount === 5){
                return true;
            }
        }
    }
    return false;
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