<?php

if ($_SERVER["REQUEST_METHOD"] != "POST"
    || $_POST['productId'] == null
    || $_POST['amount'] == null
  ) {
  echo "Bad Request";
  return;
}

session_start();
if (!$_SESSION['cart'])
  $_SESSION['cart'] = array();
$productId = $_POST['productId'];
$amount = $_POST['amount'];

$_SESSION['cart']["$productId"] = $amount;

if (array_key_exists('redirectToCart', $_POST))
  header("Location: cart.php");
else
  header("Location: home.php");
?>
