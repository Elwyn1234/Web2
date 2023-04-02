<?php
function connect() {
  $host = "localhost";
  $username = "ejohn";
  $password = "P@ssw0rd12";
  $dbname = "ejohn_web2";

  $conn = new mysqli($host, $username, $password, $dbname);

  if ($conn->connect_error)
    throw new Exception("Connection failed: " . $conn->connect_error);

  return $conn;
}
?>
