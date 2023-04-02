<?php 
  session_start();
if (!key_exists('loggedInUser', $_SESSION)) {
  $_SESSION['redirectToCheckout'] = true;
  header("Location: login.php");
}
?>

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
      showTemplate('');
    ?>

    <h1 style="text-align: center;">Checkout</h1>

    <?php

      if (array_key_exists('cart', $_SESSION) && count($_SESSION['cart'])) show();
      else echo "<p style='text-align: center;'>No items in cart. Please add items to the cart before checking out.</p>";
    ?>

  </body>
</html>

<?php
function show() {
?>
<div style="margin: auto; margin-top: 60px; width: 1080px;">
    <table class="table">
      <thead>
        <tr>
          <th scope="col">Product</th>
          <th scope="col">Amount</th>
          <th scope="col">Price</th>
        </tr>
      </thead>
      <tbody>
  <?php
      
    require "connection.php";
    $conn = connect();
    $cart = $_SESSION['cart'];
    $total = 0;
    foreach ($cart as $productId => $amount) {
      $sql = "SELECT * FROM products WHERE id=$productId";
      $products = mysqli_query($conn, $sql);
      $product = mysqli_fetch_assoc($products);
      $name = $product["name"];
      $priceInPenceForProduct = $product["priceInPence"];
      $totalPriceInPenceForProduct = $priceInPenceForProduct * $amount;
      $total += $totalPriceInPenceForProduct;
  ?>

    <tr>
      <th scope="row"><?php echo $name ?></th>
      <td><?php echo $amount ?></td>
      <td><?php echo penceToPounds($totalPriceInPenceForProduct) ?></td>
    </tr>

  <?php
    }
  ?>
    </tbody>
  </table>
  <a role="button" href="orderConfirmation.php" class="btn btn-primary">Buy Now</a>
</div>
  <?php
}
?>

