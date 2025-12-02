<?php

namespace Joky\AdventOfCode\Challenges\Year2021;

use Joky\AdventOfCode\Challenges\ChallengeBase;

class Day14 extends ChallengeBase {
  
  public function partOne(): string {
    
    $pairs = [];
    $template = array_shift($this->lines);
    
    //empty line
    array_shift($this->lines);
    
    foreach($this->lines as $insertions) {
      list($pair, $insert) = explode(' -> ', $insertions);
      $pairs[$pair] = $insert;
    }
    
    $step = 0;
    $steps = 10;

    echo 'Template: ' . $template . PHP_EOL;
    
    while($steps > $step) {

      $newTemplate = '';
      $previous = '';
      
      $split = str_split($template);
      
      foreach($split as $chr) {

        $pair = $previous . $chr;
        
        //echo 'PAIR : ' . $pair . PHP_EOL;
        $insert = $chr;
        
        if(array_key_exists($pair, $pairs)) {
          //echo 'FIND MATHING PAIR : ' . $pairs[$pair] . PHP_EOL;
          $insert = $pairs[$pair] . $insert;
        }
        
        $newTemplate .= $insert;

        $previous = $chr;
      }

      $template = $newTemplate;
      //$template = preg_replace(array_keys($pairs), array_values($pairs), $template);
      
      $step++;
      echo 'After step ' . $step . ': ' . $template . PHP_EOL;
    } 
    
    //counting
    $count = [];
    $split = str_split($template);

    foreach($split as $chr) {
      if(!array_key_exists($chr, $count)) {
        $count[$chr] = 0;
      }

      $count[$chr]++;
    }
    
    sort($count);
    
    $most = array_pop($count);
    $least = array_shift($count);
    
    return $most - $least;
  }
  
  public function partTwo(): string {
    $mutations = [];
    $counter = [];

    $template = array_shift($this->lines);
    
    //empty line
    array_shift($this->lines);
    
    //Possible mutations
    foreach($this->lines as $insertions) {
      list($pair, $insert) = explode(' -> ', $insertions);
      $mutations[$pair] = $insert;
    }
    
    //Initial state
    for($i = 0; $i < strlen($template) -1 ;$i++) {
      $pair = substr($template, $i, 2);
      $counter[$pair] = 1;
    }

    var_dump($counter);
    
    //Iterate
    $step = 0;
    $steps = 40;

    while($steps > $step) {
      
      $newCounter = [];
      
      foreach($mutations as $pair => $add) {
        if(!isset($counter[$pair])) {
          continue;
        }
        
        $chain = str_split($pair);
        
        $prefix = $chain[0] . $add;
        $sufix = $add . $chain[1];

        if(!isset($newCounter[$prefix])) $newCounter[$prefix] = 0;
        if(!isset($newCounter[$sufix])) $newCounter[$sufix] = 0;
        
        $newCounter[$prefix] += $counter[$pair];
        $newCounter[$sufix] += $counter[$pair];
      }
      
      $step++;
      echo 'After step ' . $step . PHP_EOL;

      $counter = $newCounter;
      
      //var_dump($counter);
    }

    //counting
    $scores = [];
    
    /*
    $counter = [
      'NB' => 1,
      'BC' => 1,
    ];
    */
    
    foreach($counter as $pair => $count) {
      $chain = str_split($pair);

      if(!isset($scores[$chain[0]])) $scores[$chain[0]] = 0;
      if(!isset($scores[$chain[1]])) $scores[$chain[1]] = 0;

      $scores[$chain[0]]+=$count;
      $scores[$chain[1]]+=$count;
    }

    var_dump($scores);
    
    foreach($scores as &$count) {
      $count = (int) ($count / 2) + $count % 2;
    }

    var_dump($scores);
    
    sort($scores);
    
    $most = array_pop($scores);
    $least = array_shift($scores);

    return $most - $least;
  }

}