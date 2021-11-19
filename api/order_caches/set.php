<?php

require_once __DIR__ . "/../../global/orderCachesModel.php";

$orderCacheJson = file_get_contents("php://input");
$orderCache     = json_decode($orderCacheJson, true);
$setSuccess     = set($orderCache) > 0;

if ($setSuccess) {
  $fallback = ["message" => "Pesanan berhasil disimpan!"];
  echo json_encode($fallback);
  exit;
}

$fallback = ["message" => "Pesanan gagal disimpan!"];
echo json_encode($fallback);
exit;
