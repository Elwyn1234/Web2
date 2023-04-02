<?php

if ($_SERVER["REQUEST_METHOD"] != "POST"
    || $_POST['productId'] == null
  ) {
  echo "Bad Request";
  return;
}

class CartEntry {
  public $productId;
  public $quantity;
}

session_start();
if (!$_SESSION['cart'])
  $_SESSION['cart'] = array();
$productId = $_POST['productId'];

if (array_key_exists($productId, $_SESSION['cart']))
  $_SESSION['cart']["$productId"]++;
else
  $_SESSION['cart']["$productId"] = 1;
echo count($_SESSION['cart']);

header("Location: home.php");
?>
