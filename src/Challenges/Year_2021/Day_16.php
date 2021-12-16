<?php

namespace Joky\AdventOfCode\Challenges\Year_2021;

use Joky\AdventOfCode\Challenges\ChallengeBase;

class Packet {
  
  public const TYPE_SUM = 0;
  public const TYPE_PRODUCT = 1;
  public const TYPE_MINIMUM = 2;
  public const TYPE_MAXIMUM = 3;
  public const TYPE_LITTERAL = 4;
  public const TYPE_GREATER_THAN = 5;
  public const TYPE_LESS_THAN = 6;
  public const TYPE_EQUAL = 7;
  
  private string $id;
  private string $packet;
  
  private int $version;
  private int $type;
  private int $litteral = 0;

  private array $subPackets = [];

  private string $leftOver;

  
  public static function fromHexa($hexa, $parent = null): Packet {
    $binary = '';
    foreach(str_split($hexa) as $letter) {
      $binary .= str_pad(base_convert($letter, 16, 2), 4, '0', STR_PAD_LEFT);
    }
    
    return new self($binary, $parent);
  }

  public static function fromBinary($binary, $parent = null): Packet {
    return new self($binary, $parent);
  }
  
  public function __construct($binary, $parent = null) {
    $this->id = bin2hex(random_bytes(4));
    $this->packet = $binary;
    
    $this->version = (int) bindec(substr($this->packet, 0, 3));
    $this->type = (int) bindec(substr($this->packet, 3, 3));
    
    echo PHP_EOL;
    
    echo 'ID = ' . $this->id . PHP_EOL;

    if($parent)
      echo 'Parent = ' . $parent . PHP_EOL;

    echo 'Packet = ' . $this->packet . PHP_EOL;
    echo 'Version = ' . $this->getVersion() . PHP_EOL;
    echo 'Type = ' . $this->getType() . PHP_EOL;
    
    if($this->getType() === self::TYPE_LITTERAL) {
      $this->calculateLitteral();

      echo 'Litteral = ' . $this->getLitteral() . PHP_EOL;
      echo 'LeftOver = ' . $this->getLeftOver() . PHP_EOL;
    }
    else {
      $lengthTypeId = (int) bindec(substr($this->packet, 6, 1));
      //0 -> 15 -> total length in bits of the sub-packets contained by this packet.
      //1 -> 11 -> number of sub-packets immediately contained by this packet.
      
      $length = ($lengthTypeId === 0) ? 15 : 11;
      
      $sizeSubPacket = (int) bindec(substr($this->packet, 7, $length));

      $this->leftOver = substr($this->packet, 7 + $length);
      
      echo 'Length Type ID = ' . $lengthTypeId . PHP_EOL;
      
      if($lengthTypeId === 0) {
        echo 'Size of subpackets : ' . $sizeSubPacket . PHP_EOL;
        echo 'Create recursive packet with left over' . PHP_EOL;
        
        $this->leftOver = substr($this->packet, 7 + $length + $sizeSubPacket);
        
        $this->createSubPackets(substr($this->packet, 7 + $length, $sizeSubPacket));
      }
      
      if($lengthTypeId === 1) {
        echo 'Number of sub-packets = ' . $sizeSubPacket . PHP_EOL;
        echo 'Create fixed number of sub packet : ' . $sizeSubPacket . PHP_EOL;
        $this->createSubPackets(substr($this->packet, 7 + $length), $sizeSubPacket);
      }
    }
  }

  public function getVersion(): int {
    return $this->version;
  }
  
  public function getTotalVersion(): int {
    $score = $this->getVersion();
    
    foreach ($this->subPackets as $packet) {
      $score += $packet->getTotalVersion();
    }
    
    return $score;
  }

  public function getType(): int {
    return $this->type;
  }

  public function getLitteral(): int {
    return $this->litteral;
  }
  
  private function calculateLitteral() {
    $hasMoreByte = true;
    $offset = 6;
    $value = '';

    while($hasMoreByte) {
      $hasMoreByte = substr($this->packet, $offset, 1) == '1';
      $value .= substr($this->packet, $offset + 1 , 4);
      $offset += 5;
    }
    
    //echo $this->packet  .PHP_EOL;
    $this->leftOver = substr($this->packet, $offset);
    $this->litteral = (int) bindec($value);
  }

  private function createSubPackets(string $substr, $count = -1) {

    if(!str_contains($substr, '1')) {
      return;
    }
    
    $packet = self::fromBinary($substr, $this->id);
    
//      echo 'sub-packet version : ' . $packet->getVersion() . PHP_EOL;
//      echo 'sub-packet type : ' . $packet->getType() . PHP_EOL;
//      echo 'sub-packet lit : ' . $packet->getLitteral() . PHP_EOL;
//      echo 'sub-packet leftover : ' . $packet->getLeftOver() . PHP_EOL;
    

    $this->subPackets[] = $packet;
    
    if($count - 1 != 0) {
      $this->createSubPackets($packet->getLeftOver(), $count - 1);
    }

    if($count == 1) {
      $this->leftOver = $packet->getLeftOver();
    }
  }

  /**
   * @return string
   */
  public function getLeftOver(): string {
    return $this->leftOver;
  }

  public function evaluate() {
    switch ($this->getType()) {
      case self::TYPE_SUM:
        return array_reduce($this->subPackets, function($c, $i) { return $c + $i->evaluate(); });
      case self::TYPE_PRODUCT:
        return array_reduce($this->subPackets, function($c, $i) { return $c * $i->evaluate(); }, 1);
      case self::TYPE_MINIMUM:
        return array_reduce($this->subPackets, function($c, $i) { return min($c, $i->evaluate()); }, PHP_INT_MAX);
      case self::TYPE_MAXIMUM:
        return array_reduce($this->subPackets, function($c, $i) { return max($c, $i->evaluate()); }, PHP_INT_MIN);
      case self::TYPE_LITTERAL:
        return $this->getLitteral();
      case self::TYPE_GREATER_THAN:
        return $this->subPackets[0]->evaluate() > $this->subPackets[1]->evaluate() ? 1 : 0;
      case self::TYPE_LESS_THAN:
        echo 'less ';
        return $this->subPackets[0]->evaluate() < $this->subPackets[1]->evaluate() ? 1 : 0;
      case self::TYPE_EQUAL:
        return $this->subPackets[0]->evaluate() == $this->subPackets[1]->evaluate() ? 1 : 0;
    }
    return 0;
  }


}

class Day_16 extends ChallengeBase {

  public const TYPE_LITTERAL = 4;
  
  public function part1(): string {
    
    $hexa = array_shift($this->lines);
    $mainPacket = Packet::fromHexa($hexa); 
    
    return $mainPacket->getTotalVersion();
  }
  
  public function part2(): string {
    $hexa = array_shift($this->lines);
    $mainPacket = Packet::fromHexa($hexa);

    return $mainPacket->evaluate();
  }

}