<?php

require_once __DIR__ . "/../../global/orderCachesModel.php";
require_once __DIR__ . "/../../global/restaurantsModel.php";

$restaurantId = 1;

$restaurant = findById($restaurantId);
if (count($restaurant) === 0) {
  echo "Restaurant Tidak Ditemukan!";
  exit;
}

$orderCache = get($restaurantId);
if (count($orderCache) !== 0) {
  $ordered = json_decode($orderCache[0]["ordered"], true);

  $uniqueOrderedCategory = unique_multidim_array($ordered, "category");
  $category              = [];
  foreach ($uniqueOrderedCategory as $order) {
    $category[] = $order["category"];
  }

  $filteredOrder = [];
  for ($i = 0; $i < count($category); $i++) {
    $filteredOrder[$category[$i]] = array_filter($ordered, function ($order) {
      global $i, $category;
      return $order["category"] === $category[$i];
    });
  }
} else {
  $filteredOrder = [];
}

?>

<!doctype html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap CSS -->
  <link href="../../css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../../css/style.css">
  <title><?=$restaurant[0]["name"]?> Receipt | Resta Manage</title>
</head>

<body>
  <main class="container py-4">
    <div class="d-none restaurant-id"><?=$restaurantId?></div>
    <div class="mb-5">
      <label for="pin" class="h5 mb-3">No Nota</label>
      <input type="text" class="form-control form-control-lg no-receipt" id="pin" autocomplete="off" disabled value="<?=$orderCache[0]["no_receipt"]?>">
    </div>
    <div class="mb-5">
      <div class="mb-4">
        <ul class="list-group">
          <?php foreach ($filteredOrder as $key => $value): ?>
          <?php foreach ($value as $order): ?>
          <li class="list-group-item order-id" id="<?=$order["id"]?>">
            <div class="row align-items-center">
              <div class="col">
                <div class="order-category d-none"><?=$order["category"]?></div>
                <div class="d-flex flex-column">
                  <h4 class="h6 m-0 order-name"><span class="order-quantity"><?=$order["quantity"]?>x</span> <?=$order["name"]?></h4>
                  <p class="m-0 text-muted small">Rp <span class="order-price"><?=$order["price"];?></span></p>
                  <textarea class="form-control form-control-sm order-note <?=($order["note"] === "") ? "d-none" : ""?>" rows="2" disabled><?=$order["note"]?></textarea>
                </div>
              </div>
              <div class="col-auto">
                <p class="m-0">Rp <span class="order-sub-total"><?=$order["price"] * $order["quantity"]?></span></p>
              </div>
            </div>
          </li>
          <?php endforeach;?>
          <?php endforeach;?>
        </ul>
      </div>
    </div>
    <div class="mb-5">
      <h2 class="h5 mb-3">Detail Transaksi</h2>
      <ul class="list-group">
        <li class="list-group-item">
          <div class="row align-items-center">
            <div class="col">
              <p class="m-0">Jumlah item dipesan</p>
            </div>
            <div class="col-auto">
              <p class="m-0 total-order-quantity">0</p>
            </div>
          </div>
        </li>
        <li class="list-group-item">
          <div class="row align-items-center">
            <div class="col">
              <p class="m-0 fw-bold">Total</p>
            </div>
            <div class="col-auto">
              <p class="m-0 fw-bold">Rp <span class="total-order-price">0</span></p>
            </div>
          </div>
        </li>
      </ul>
    </div>
    <a href="./" class="btn btn-danger w-100">Kembali</a>
  </main>
  <!-- Bootstrap Bundle with Popper -->
  <script src="../../js/bootstrap.bundle.min.js"></script>
  <script src="../../js/receipt.js"></script>
</body>

</html>
