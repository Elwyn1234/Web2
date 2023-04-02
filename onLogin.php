<?php

if ($_SERVER["REQUEST_METHOD"] != "POST"
    || $_POST['username'] == null
    || $_POST['password'] == null
  ) {
  echo "Bad Request";
  return;
}

$username = $_POST['username'];
$password = $_POST['password'];

require "connection.php";
$conn = connect();
$sql = "SELECT password FROM users WHERE username=?";
// Use prepared SQL statements to prevent SQL injection. 
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $storedPassword);
mysqli_stmt_fetch($stmt);

if (!password_verify($password, $storedPassword)) {
  mysqli_close($conn);
  die("Invalid username or password");
}

mysqli_close($conn);
session_start();
$_SESSION['loggedInUser'] = "true";

if (array_key_exists('redirectToCheckout', $_SESSION) && $_SESSION['redirectToCheckout']) {
  unset($_SESSION['redirectToCheckout']);
  header("Location: checkout.php");
}
else {
  header("Location: home.php");
}
?>
