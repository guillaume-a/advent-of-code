<?php

namespace Joky\AdventOfCode\Challenges\Year2021;

use Joky\AdventOfCode\Challenges\ChallengeBase;

/*
class Node {
  const SIZE_BIG = 'big';
  const SIZE_SMALL = 'small';
  
  private $size = '';
  
  public function __construct($name) {
    $this->size = preg_match('/[^A-Z]/', $name) ? self::SIZE_SMALL : self::SIZE_BIG;
  }
  
  public function isBig() {
    return $this->size;
  }
  
  public function hasBeenVisited() {
    return $this->visited;
  }
  
  public function visit() {
    $this->visited = true;
  }

}
*/

class Day12 extends ChallengeBase {
  
  private array $nodes = [];
  private array $paths = [];

  /**
   * @var int[]|string[]
   */
  private array $smallCaves;

  private function findPathsPart1($cave, $path = []) {
    $path[$cave] = 1;
    
    if($cave === 'end') {
      echo implode(',', array_keys($path)) . PHP_EOL;
      $this->paths[] = $path;
    }

    foreach($this->nodes[$cave] as $neighboor) {
      if(preg_match('/[^A-Z]/', $neighboor) && array_key_exists($neighboor, $path)) {
        continue;
      }

      $this->findPathsPart1($neighboor, $path);
      
      unset($path[$neighboor]);
    }
  }
  
  public function partOne(): string {
    foreach($this->lines as $line) {
      [$start, $end] = explode('-', $line);
      
      if(!array_key_exists($start, $this->nodes)) $this->nodes[$start] = [];
      if(!array_key_exists($end, $this->nodes)) $this->nodes[$end] = [];

      $this->nodes[$start][] = $end;
      $this->nodes[$end][] = $start;
    }

    $this->findPathsPart1('start');
    return count($this->paths);
  }

  private function isSmall($cave) {
    return preg_match('/[^A-Z]/', $cave);
  }
  
  private function visitCave($cave, $path = []) {
    //add cave to current path
    $path[] = $cave;

    //'end' cave ends visit
    if($cave === 'end') {
      $this->paths[] = $path;
      //echo 'DONE : ' . implode(',', $path) . PHP_EOL;
      return;
    }
    
    $canVisitSmallCaveAgain = true;
    foreach ($this->smallCaves as $smallCave) {
      if(count(array_filter($path, function ($cave) use ($smallCave) { return $cave == $smallCave; })) == 2) {
        $canVisitSmallCaveAgain = false;
      }
    }
    
    foreach($this->nodes[$cave] as $neighboor) {
      //Dont visit start twice
      if($neighboor === 'start') {
        continue;
      }
      
      //Dont visit small more than 2
      if(
        $this->isSmall($neighboor)
        && in_array($neighboor, $path)
        && !$canVisitSmallCaveAgain 
      ) {
        continue;
      }

      $this->visitCave($neighboor, $path);
    }
  }
  
  public function partTwo(): string {
    foreach($this->lines as $line) {
      [$start, $end] = explode('-', $line);

      if(!array_key_exists($start, $this->nodes)) $this->nodes[$start] = [];
      if(!array_key_exists($end, $this->nodes)) $this->nodes[$end] = [];

      $this->nodes[$start][] = $end;
      $this->nodes[$end][] = $start;
    }
    
    $this->smallCaves = array_filter(array_keys($this->nodes), function($cave) {return $this->isSmall($cave);});

    $this->visitCave('start');
    return count($this->paths);
  }

}