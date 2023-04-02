<?php session_start() ?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bread and Butter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
  </head>
  <body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>

    <?php 
      require "util.php";
      require "template.php";
      showTemplate('home');
    ?>

    <h1 style="text-align: center;">Bakery</h1>

    <div class="flex" style="display: flex; flex-direction: row; flex-wrap: wrap; margin: auto; width: 1080px; flex-shrink: 2;">
    <?php
      require "connection.php";
      $conn = connect();
      $sql = "SELECT * FROM products";
      $products = mysqli_query($conn, $sql);
      while ($product = mysqli_fetch_assoc($products)) {
        $productId = $product["id"];
        $name = $product["name"];
        $imagePath = $product["imagePath"];
        $priceInPence = $product["priceInPence"];
    ?>

    <div class="card" style="width: 300px; margin: 30px;">
      <img src="<?php echo $imagePath ?>" class="card-img-top">
      <div class="card-body">
        <h5 class="card-title"><?php echo $name ?></h5>
        <p class="card-text"><?php echo penceToPounds($priceInPence) ?></p>
        <form action="onAddItemToCart.php" method="post">
          <input type="number" name="productId" value=<?php echo $productId; ?> hidden>
          <div class="mb-3">
            <label for="amount" class="form-label">Amount</label>
            <input type="number" min="1" class="form-control" name="amount" id="password" required>
          </div>
          <input type="submit" class="btn btn-primary" value="Add to Cart">
        </form>
      </div>
    </div>

    <?php
      }
    ?>
    </div>
  </body>
</html>

