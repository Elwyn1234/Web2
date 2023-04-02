<?php

if ($_SERVER["REQUEST_METHOD"] != "POST"
    || $_POST['productId'] == null
  ) {
  echo "Bad Request";
  return;
}

session_start();
$productId = $_POST['productId'];

if (array_key_exists($productId, $_SESSION['cart']))
  unset($_SESSION['cart']["$productId"]);

header("Location: cart.php");
?>
