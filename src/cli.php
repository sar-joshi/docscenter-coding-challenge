<?php

declare(strict_types=1);

try {
  $args = array_slice($argv, 1);

  var_dump($args); # TODO: remove it later
} catch (Exception $e) {
  echo $e->getMessage() . "";
  exit(1);
}