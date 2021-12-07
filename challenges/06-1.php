<?php

class Lanternfish {

  private $timer;

  public function __construct($timer) {
    $this->timer = $timer;
  }

  public function tick() {
    $this->timer--;
  }

  public function reset() {
    if($this->timer === 0) {
      $this->timer = 7;
      return true;
    }

    return false;
  }

  public function __toString() {
    return (string) $this->timer;
  }

}

/*
echo "How many days ? : ";
$handle = fopen ("php://stdin","r");
$daysToCount = (int) fgets($handle);
*/
$daysToCount = 80;


$line = reset($lines);
echo 'Initial state:  ' . $line . PHP_EOL;
$initValues = explode(',', $line);

$fishes = [];

foreach($initValues as $value) {
  array_push($fishes, new Lanternfish($value));
}

$currentDay = 0;

while($currentDay < $daysToCount) {
  array_map(function(Lanternfish $fish) {return $fish->tick();}, $fishes);

  $currentDay++;

  //echo 'After day ' . $currentDay . ':  ' . implode(',', $fishes) . PHP_EOL;

  $fishToReset = array_filter($fishes, function(Lanternfish $fish) {return $fish->reset();});

  if($currentDay === $daysToCount) {
    break;
  }

  //var_dump(count($fishAtZero));
  $newFishes = count($fishToReset);

  for($i = 0; $i < $newFishes; $i++) {
    array_push($fishes, new Lanternfish(9));
  }
}

return count($fishes);
