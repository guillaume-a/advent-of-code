<?php

namespace Joky\AdventOfCode\Challenges\Year_2022;

use Joky\AdventOfCode\Challenges\ChallengeBase;

class Day_07 extends ChallengeBase {

  private $tree = [
    /*
    '/' => [
      'dir' => [],
      'files' => [],
    ]*/
  ];
  
  public function part1(): string {
    // remove first "cd /"
    //array_shift($this->lines);
    $current = [];
    $sizes = [];
    
    foreach($this->lines as $line) {

      if(str_starts_with($line, '$ ')) {
        $line = substr($line, 2);

        //command
        if(!str_starts_with($line, 'cd')) {
          continue;
        }
        
        // cd
        [, $dir] = explode(' ', $line);

        //var_dump($line);

        if($dir === '..') {
          array_pop($current);
        } else {
          $current[] = $dir;
        }

        $pwd = implode('/', $current);
        var_dump($pwd);
        
        if(!array_key_exists($pwd, $sizes)) {
          $sizes[$pwd] = 0;
        }
        
        continue;
      } 
      
      //ls info
      [$data] = explode(' ', $line);
      
      if($data === 'dir') {
        // new dir
        continue;
      }

      //$dirs = $current;
      //while(count($dirs) > 0) {
        $pwd = implode('/', $current);
        $sizes[$pwd] += (int) $data;
        //array_pop($dirs);
      //}
      
//      var_dump($current);
    }
    
    var_dump($sizes);
    
    
    
    return '0';
  }

  public function part2(): string {
    return '0';
  }
}