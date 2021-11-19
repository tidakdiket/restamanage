<?php

require_once __DIR__ . "/config.php";

function unique_multidim_array($array, $key)
{
  $temp_array = array();
  $i          = 0;
  $key_array  = array();

  foreach ($array as $val) {
    if (!in_array($val[$key], $key_array)) {
      $key_array[$i]  = $val[$key];
      $temp_array[$i] = $val;
    }
    $i++;
  }
  return $temp_array;
}

function all($restaurantId)
{
  global $conn;

  $query   = "SELECT * FROM menus WHERE restaurant_id = $restaurantId";
  $results = mysqli_query($conn, $query);
  $menus   = [];

  while ($menu = mysqli_fetch_assoc($results)) {
    $menus[] = $menu;
  }

  return $menus;
}
