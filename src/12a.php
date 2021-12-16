<?php

$input = getInput('12.txt');
$nodes = [];
foreach($input as $line){
    $n = explode('-', $line);

    foreach($n as $node){
        if(!isset($nodes[$node])){
            $nodes[$node] = [];
        }
    }
    if(!in_array($n[1], $nodes[$n[0]])){
        $nodes[$n[0]][] = $n[1];
    }
    if(!in_array($n[0], $nodes[$n[1]])){
        $nodes[$n[1]][] = $n[0];
    }
}

$queue = [];
foreach($nodes['start'] as $child){
    $queue[] = ['start',$child];
}
$validPaths = [];
while(!empty($queue)){
    $path = array_shift($queue);
    $prevNode = end($path);
    if($prevNode === 'end'){
        $validPaths[] = $path;
    }
    $children = $nodes[$prevNode];
    foreach($children as $child){
        if(ctype_upper($child) || !in_array($child, $path)){
            $queue[] = array_merge($path,[$child]);
        }
    }
}
outputLine(count($validPaths));



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
