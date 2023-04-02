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
      showTemplate('cart');
    ?>

    <h1 style="text-align: center;">Cart</h1>

    <?php

      if (array_key_exists('cart', $_SESSION) && count($_SESSION['cart'])) show();
      else echo "<p style='text-align: center;'>No items in cart.</p>";
    ?>

  </body>
</html>

<?php
function show() {
?>
<div style="margin: auto; width: 1080px;">
  <a role="button" href="checkout.php" class="btn btn-primary" style="margin-left: 30px;">Proceed to Checkout</a>
  <div class="flex" style="display: flex; flex-direction: row; flex-wrap: wrap; flex-shrink: 2;">
  <?php
      
    require "connection.php";
    $conn = connect();
    $cart = $_SESSION['cart'];
    foreach ($cart as $productId => $amount) {
      $sql = "SELECT * FROM products WHERE id=$productId";
      $products = mysqli_query($conn, $sql);
      $product = mysqli_fetch_assoc($products);
      $name = $product["name"] . ' x' . $amount;
      $imagePath = $product["imagePath"];
      $priceInPenceForProduct = $product["priceInPence"];
      $totalPriceInPence = $priceInPenceForProduct * $amount;
  ?>

      <div class="card" style="width: 300px; margin: 30px;">
        <img src="<?php echo $imagePath ?>" class="card-img-top">
        <div class="card-body">
          <h5 class="card-title"><?php echo $name ?></h5>
          <p class="card-text"><?php echo penceToPounds($totalPriceInPence) ?></p>
          <form action="onRemoveItemFromCart.php" method="post">
            <div class="mb-3">
              <input type="number" name="productId" value=<?php echo $productId; ?> hidden>
              <input type="submit" class="btn btn-primary" value="Remove">
            </div>
          </form>
          <form action="onAddItemToCart.php" method="post">
            <input type="number" name="productId" value=<?php echo $productId; ?> hidden>
            <input type="number" name="redirectToCart" value="1" hidden>
            <div class="mb-3">
              <label for="amount" class="form-label">Amount</label>
              <input type="number" min="1" class="form-control" name="amount" id="amount" value="<?php echo $amount ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update amount</button>
          </form>
        </div>
      </div>

  <?php
    }
  ?>
  </div>
  <a role="button" href="checkout.php" class="btn btn-primary" style="margin-left: 30px;">Proceed to Checkout</a>
</div>
  <?php
}
?>

