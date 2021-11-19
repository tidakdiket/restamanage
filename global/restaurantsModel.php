<?php

require_once __DIR__ . "/config.php";

function findById($id)
{
  global $conn;

  $query   = "SELECT * FROM restaurants WHERE id = $id";
  $results = mysqli_query($conn, $query);

  $restaurant = [];
  while ($row = mysqli_fetch_assoc($results)) {
    if (count($restaurant) < 1) {
      $restaurant[] = $row;
    }
  }

  return $restaurant;
}

function getAll()
{
  global $conn;

  $query   = "SELECT * FROM restaurants";
  $results = mysqli_query($conn, $query);

  $restaurants = [];
  while ($restaurant = mysqli_fetch_assoc($results)) {
    $restaurants[] = $restaurant;
  }

  return $restaurants;
}
