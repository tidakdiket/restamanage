<?php

require_once __DIR__ . "/global/restaurantsModel.php";

$restaurants = getAll();

?>

<!doctype html>
<html lang="id">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="./css/bootstrap.min.css" rel="stylesheet">

    <title>Resta Manage</title>
  </head>
  <body>
    <main class="container my-4">
      <h1 class="mb-4">Restaurant List</h1>
      <div class="list-group">
        <?php foreach ($restaurants as $restaurant): ?>
        <a href="./detail/<?=str_replace(" ", "_", strtolower($restaurant["name"]))?>" class="list-group-item list-group-item-action py-3"><?=$restaurant["name"]?></a>
        <?php endforeach;?>
      </div>
    </main>

    <!-- Bootstrap Bundle with Popper -->
    <script src="./js/bootstrap.bundle.min.js"></script>

  </body>
</html>
