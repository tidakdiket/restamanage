<?php

require_once __DIR__ . "/../../global/orderCachesModel.php";

if (isset($_GET["restaurant_id"])) {
  $orderCaches = get($_GET["restaurant_id"]);
  echo json_encode(["results" => $orderCaches]);
  exit;
}

echo json_encode(["message" => "You must pass restaurant id"]);
exit;
