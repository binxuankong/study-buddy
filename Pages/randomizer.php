<?php

// PHP code to randomize the answer choices.
function shuffle_array($list) 
{
  if (!is_array($list)) 
  {
    return $list;
  }
  $keys = array_keys($list);
  shuffle($keys);
  $random = array();
  foreach ($keys as $key) 
  {
    $random[$key] = $list[$key];
  }
  return $random;
}

?>
