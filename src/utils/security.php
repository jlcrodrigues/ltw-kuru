<?php declare(strict_types = 1); ?>

<?php
function valid_input(string $input) : bool { 
  return preg_match("/^[,.:@a-zA-Z0-9\-\' ]+$/", $input) == 1;
} ?>

<?php
function valid_input_list(array $input) : bool { 
  foreach($input as $i) {
    if (!valid_input($i)) return false;
  }
  return true;
} ?>