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

function get($restaurantId)
{
  global $conn;

  $query   = "SELECT * FROM order_caches WHERE restaurant_id = $restaurantId";
  $results = mysqli_query($conn, $query);

  $orderCaches = [];
  while ($orderCache = mysqli_fetch_assoc($results)) {
    $orderCaches[] = $orderCache;
  }

  return $orderCaches;
}

function set($orderCache)
{
  $currentOrderCache = findByRestaurantId($orderCache["restaurant_id"]);

  if (count($currentOrderCache)) {
    $updateResult = update($orderCache);
    return $updateResult;
  }
  $saveResult = save($orderCache);
  return $saveResult;
}

function findByRestaurantId($restaurantId)
{
  global $conn;

  $query   = "SELECT * FROM order_caches WHERE restaurant_id = $restaurantId";
  $results = mysqli_query($conn, $query);

  $orderCache = [];
  while ($row = mysqli_fetch_assoc($results)) {
    if (count($orderCache) < 1) {
      $orderCache[] = $row;
    }
  }

  return $orderCache;
}

function save($orderCache)
{
  global $conn;
  $orderedJson = json_encode($orderCache["ordered"]);

  if ($orderCache["no_receipt"] === null) {
    $query = "INSERT INTO order_caches VALUES
            ('', {$orderCache['restaurant_id']}, '$orderedJson', null)";
  } else {
    $query = "INSERT INTO order_caches VALUES
            ('', {$orderCache['restaurant_id']}, '$orderedJson', {$orderCache['no_receipt']})";
  }
  mysqli_query($conn, $query);

  return mysqli_affected_rows($conn);
}

function update($orderCache)
{
  global $conn;
  $oldOrderCache = findByRestaurantId($orderCache["restaurant_id"]);
  $orderedJson   = json_encode($orderCache["ordered"]);

  if ($orderCache["no_receipt"] === $oldOrderCache[0]["no_receipt"]) {
    $query = "UPDATE order_caches SET
            ordered = '$orderedJson'
            WHERE restaurant_id = {$orderCache['restaurant_id']}
            ";
  } else if ($orderCache["no_receipt"] === null) {
    $query = "UPDATE order_caches SET
            ordered = '$orderedJson',
            no_receipt = null
            WHERE restaurant_id = {$orderCache['restaurant_id']}
            ";
  } else {
    $query = "UPDATE order_caches SET
            ordered = '$orderedJson',
            no_receipt = {$orderCache['no_receipt']}
            WHERE restaurant_id = {$orderCache['restaurant_id']}
            ";
  }
  mysqli_query($conn, $query);

  return mysqli_affected_rows($conn);
}

function delete($restaurantId)
{
  global $conn;
  $ordered     = [];
  $orderedJson = json_encode($ordered);

  // $query = "DELETE FROM order_caches WHERE restaurant_id = {$restaurantId}";
  $query = "UPDATE order_caches SET
            ordered = '[]',
            no_receipt = null
            WHERE restaurant_id = $restaurantId
            ";
  mysqli_query($conn, $query);

  return mysqli_affected_rows($conn);
}
