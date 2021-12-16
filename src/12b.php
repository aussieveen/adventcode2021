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
    $queue[] = [false,'start',$child];
}
$validPaths = [];
while(!empty($queue)){
    outputLine(count($queue));
    $path = array_shift($queue);
    $prevNode = end($path);
    if($prevNode === 'end'){
        $validPaths[] = $path;
        continue;
    }

    $children = $nodes[$prevNode];
    foreach($children as $i => $child){

        if($child === 'end' || ctype_upper($child)){
            $queue[] = array_merge($path, [$child]);
            continue;
        }
        if($child === 'start'){
            continue;
        }
        if($path[0] === false || !in_array($child,$path,true)){

            $p = array_merge($path,[$child]);
            if($p[0] === false){
                $l = [];
                foreach($p as $n){
                    if(in_array($n, $l,true) && !ctype_upper($n)){
                        $p[0] = true;
                        break;
                    }
                    $l[] = $n;
                }
            }
            $queue[] = $p;
        }
    }
}
//foreach($validPaths as $path){
//    unset($path[0]);
//    outputLine(implode(',',$path));
//}
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
