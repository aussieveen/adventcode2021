<?php

$input = getInput('11.txt');
$map = [];
foreach($input as $line){
    $row = [];
    foreach(str_split($line) as $energyLevel){
        $row[] = new Octopus((int)$energyLevel);
    }
    $map[] = $row;
}
outputMap($map);
$step = 0;
$flashCount = 0;
$allFlash = false;
while(!$allFlash) {
    foreach ($map as $row) {
        foreach ($row as $octopus) {
            $octopus->setEnergyLevel($octopus->getEnergyLevel() + 1);
            $octopus->setIncremented(true);
        }
    }
    $noFlash = false;
    while (!$noFlash) {
        $noFlash = true;
        foreach ($map as $r => $row) {
            foreach ($row as $c => $octopus) {
                if (!$octopus->hasFlashed() && $octopus->getEnergyLevel() > 9) {
                    $noFlash = false;
                    $octopus->setFlashed(true);
                    $flashCount++;
                    foreach ([
                                 [-1, -1],
                                 [-1, 0],
                                 [-1, 1],
                                 [0, 1],
                                 [1, 1],
                                 [1, 0],
                                 [1, -1],
                                 [0, -1]
                             ] as $surroundingCoords) {
                        if (isset($map[$r + $surroundingCoords[0]][$c + $surroundingCoords[1]])) {
                            $map[$r + $surroundingCoords[0]][$c + $surroundingCoords[1]]->setEnergyLevel($map[$r + $surroundingCoords[0]][$c + $surroundingCoords[1]]->getEnergyLevel() + 1);
                        }
                    }
                }
            }
        }
    }

    foreach ($map as $r => $row) {
        foreach ($row as $c => $octopus) {
            $octopus->reset();
        }
    }
    $allFlash = true;
    foreach ($map as $r => $row) {
        foreach ($row as $c => $octopus) {
            if($octopus->getEnergyLevel() > 0){
                $allFlash = false;
                break 2;
            }
        }
    }

    $step++;

    outputMap($map);
}
outputLine($step);

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

function outputMap(array $map){
    foreach($map as $row){
        $s = '';
        foreach($row as $octopus){
            $s .= $octopus->getEnergyLevel();
        }
        outputLine($s);
    }
    outputLine('');
}

class Octopus{

    /**
     * @var int
     */
    private $energyLevel;

    /**
     * @var bool
     */
    private $flashed;

    /**
     * @var bool
     */
    private $incremented;

    public function __construct(int $energyLevel){
        $this->energyLevel = $energyLevel;
        $this->flashed = false;
        $this->incremented = false;
    }

    /**
     * @return int
     */
    public function getEnergyLevel(): int
    {
        return $this->energyLevel;
    }

    /**
     * @param int $energyLevel
     */
    public function setEnergyLevel(int $energyLevel): void
    {
        $this->energyLevel = $energyLevel;
    }

    /**
     * @return false
     */
    public function hasFlashed()
    {
        return $this->flashed;
    }

    /**
     * @param false $flashed
     */
    public function setFlashed($flashed): void
    {
        $this->flashed = $flashed;
    }

    /**
     * @return bool
     */
    public function isIncremented(): bool
    {
        return $this->incremented;
    }

    /**
     * @param bool $incremented
     */
    public function setIncremented(bool $incremented): void
    {
        $this->incremented = $incremented;
    }

    public function reset():void
    {
        if($this->flashed){
            $this->setEnergyLevel(0);
        }
        $this->incremented = false;
        $this->flashed = false;
    }
}