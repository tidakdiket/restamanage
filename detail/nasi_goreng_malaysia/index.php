<?php

require_once __DIR__ . "/../../global/menusModel.php";
require_once __DIR__ . "/../../global/restaurantsModel.php";

$restaurantId = 1;

$restaurant = findById($restaurantId);
if (count($restaurant) === 0) {
  echo "Restaurant Tidak Ditemukan!";
  exit;
}

$menus = all($restaurantId);

$uniqueMenusCategory = unique_multidim_array($menus, "category");
$category            = [];
foreach ($uniqueMenusCategory as $menu) {
  $category[] = $menu["category"];
}

$filteredMenus = [];
for ($i = 0; $i < count($category); $i++) {
  $filteredMenus[$category[$i]] = array_filter($menus, function ($menu) {
    global $i, $category;
    return $menu["category"] === $category[$i];
  });
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
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <title><?=$restaurant[0]["name"]?> | Resta Manage</title>
</head>

<body>
  <main class="container py-4">
    <div class="d-none restaurant-id"><?=$restaurantId?></div>
    <h1 class="mb-5"><?=$restaurant[0]["name"]?></h1>
    <div class="mb-5">
      <label for="pin" class="h5 mb-3">No Nota</label>
      <input type="number" class="form-control form-control-lg no-receipt" id="pin" autocomplete="off">
    </div>
    <div class="mb-5">
      <?php foreach ($filteredMenus as $key => $value): ?>
      <div class="mb-4">
        <h2 class="h5 mb-3"><?=ucwords($key);?></h2>
        <ul class="list-group">
          <?php foreach ($value as $menu): ?>
          <li class="list-group-item order-id" id="<?=$menu["id"]?>">
            <div class="row align-items-center">
              <div class="col">
                <div class="order-category d-none"><?=$menu["category"]?></div>
                <div class="d-flex flex-column">
                  <h4 class="h6 m-0 order-name"><?=$menu["name"]?></h4>
                  <p class="m-0 text-muted small">Rp <span class="order-price"><?=$menu["price"];?></span></p>
                </div>
                <button class="btn btn-link btn-sm p-0 add-note">Tambahkan catatan</button>
                <textarea class="form-control form-control-sm order-note d-none" rows="2"></textarea>
                <button class="btn btn-link btn-sm p-0 delete-note d-none">Hapus catatan</button>
              </div>
              <div class="input-group col-auto w-auto">
                <button class="btn btn-outline-secondary btn-sm reduce-quantity" type="button"><span class="material-icons">remove</span></button>
                <button class="btn btn-outline-secondary btn-sm text-black order-quantity" type="button" disabled>0</button>
                <button class="btn btn-outline-secondary btn-sm add-quantity" type="button"><span class="material-icons">add</span></button>
              </div>
            </div>
          </li>
          <?php endforeach;?>
        </ul>
      </div>
      <?php endforeach;?>
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
    <button type="button" class="btn btn-primary w-100 mb-2 save-order">Simpan</button>
    <button type="button" class="btn btn-success w-100 mb-5 see-receipt">Lihat Nota</button>
    <button type="button" class="btn btn-danger w-100 mb-2 reset-order">Reset</button>
    <a href="../../" class="btn btn-secondary w-100">Kembali</a>
  </main>
  <!-- Bootstrap Bundle with Popper -->
  <script src="../../js/bootstrap.bundle.min.js"></script>
  <script src="../../js/script.js"></script>
</body>

</html>
