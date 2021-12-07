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
        if($grid[$y][$x] == 0) {
          echo '.';
        } else {
          echo $grid[$y][$x];
        }
      }
    }

    echo PHP_EOL;
  }
  echo PHP_EOL;
}

foreach($lines as $coords) {
  // For debug inputs, line starting with # will be ignored
  if(substr($coords, 0, 1) === '#') {
    continue;
  }

  list($start, $end) = explode(' -> ', $coords);
  list($x1, $y1) = explode(',', $start);
  list($x2, $y2) = explode(',', $end);

  // For debug draw
  $max_x = max($max_x, $x1, $x2);
  $max_y = max($max_y, $y1, $y2);

  // Direction
  if($x1 == $x2) {
    $overlap += drawVertical($grid, $x1, min($y1, $y2), max($y1, $y2));
  }
  elseif($y1 == $y2) {
    $overlap += drawHorizontal($grid, $y1, min($x1, $x2), max($x1, $x2));
  }
  else {
    $overlap += drawDiagonal($grid, $x1, $y1, $x2, $y2);
  }
}

function drawVertical(&$grid, $x, $y1, $y2) {
  $overlap = 0;
  for($y = $y1; $y <= $y2; $y++) {

    if(!array_key_exists($y, $grid)) {
      $grid[$y] = [];
    }
    if(!array_key_exists($x, $grid[$y])) {
      $grid[$y][$x] = 0;
    }

    $grid[$y][$x]++;

    if($grid[$y][$x] == 2) {
      $overlap++;
    }

  }

  return $overlap;

}

function drawHorizontal(&$grid, $y, $x1, $x2) {

  $overlap = 0;
  for($x = $x1; $x <= $x2; $x++) {

    if(!array_key_exists($y, $grid)) {
      $grid[$y] = [];
    }
    if(!array_key_exists($x, $grid[$y])) {
      $grid[$y][$x] = 0;
    }

    $grid[$y][$x]++;

    if($grid[$y][$x] == 2) {
      $overlap++;
    }
  }

  return $overlap;

}

function drawDiagonal(&$grid, $x1, $y1, $x2, $y2) {
  $overlap = 0;

  $draw = true;
  $step_y = ($y1 < $y2) ? 1 : -1;
  $step_x = ($x1 < $x2) ? 1 : -1;

  while($draw) {
    if(!array_key_exists($y1, $grid)) {
      $grid[$y1] = [];
    }
    if(!array_key_exists($x1, $grid[$y1])) {
      $grid[$y1][$x1] = 0;
    }

    $grid[$y1][$x1]++;

    if($grid[$y1][$x1] == 2) {
      $overlap++;
    }

    if($y1 == $y2) {
      $draw = false;
    }

    $y1 += $step_y;
    $x1 += $step_x;
  }

  return $overlap;

}

//draw($grid, $max_x, $max_y);

return $overlap;