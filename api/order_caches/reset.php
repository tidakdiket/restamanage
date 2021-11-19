<?php

require_once __DIR__ . "/../../global/orderCachesModel.php";

if (isset($_GET["restaurant_id"])) {
  $deleteSuccess = delete($_GET["restaurant_id"]) > 0;

  if ($deleteSuccess) {
    echo json_encode(["message" => "Reset berhasil!"]);
    exit;
  }
}

echo json_encode(["message" => "Reset gagal!"]);
exit;
