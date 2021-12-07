<?php

$grid = [];
$overlap = 0;

$max_x = 0;
$max_y = 0;

//debug helper
function draw($grid, $w, $h) {
  for($y=0;$y<=$h;$y++) {
    for($x=0;$x<=$w;$x++) {
      if(!isset($grid[$y]) || !isset($grid[$y][$x])) {
        echo '.';
      } else {
        echo $grid[$y][$x];
      }
    }

    echo PHP_EOL;
  }
  echo PHP_EOL;
}

foreach($lines as $coords) {
  list($start, $end) = explode(' -> ', $coords);
  list($x1, $y1) = explode(',', $start);
  list($x2, $y2) = explode(',', $end);

  // not vertical nor horizontal
  if($x1 != $x2 && $y1 != $y2) {
    continue;
  }

  // from low to high
  if($x2 < $x1) {
    $tmp = $x1;
    $x1 = $x2;
    $x2 = $tmp;
  }

  if($y2 < $y1) {
    $tmp = $y1;
    $y1 = $y2;
    $y2 = $tmp;
  }

  if($x2 > $max_x) {
    $max_x = $x2;
  }

  if($y2 > $max_y) {
    $max_y = $y2;
  }

  for($y = $y1; $y <= $y2; $y++) {
    for($x = $x1; $x <= $x2; $x++) {
      // create grid
      if(!array_key_exists($y, $grid)) {
        $grid[$y] = [];
      }
      if(!array_key_exists($x, $grid[$y])) {
        $grid[$y][$x] = 0;
      }

      //
      $grid[$y][$x]++;

      if($grid[$y][$x] == 2) {
        $overlap++;
      }
    }
  }
}

//draw($grid, $max_x, $max_y);

return $overlap;