<?php
if ($_SERVER["REQUEST_METHOD"] != "POST"
    || !$_POST['username']
    || !$_POST['password']
    || !$_POST['firstName']
    || !$_POST['lastName']
  ) {
  echo "Bad Request";
  return;
}

require "connection.php";
$conn = connect();

$username = $_POST['username'];
$password = $_POST['password'];
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];

$sql = "SELECT (username) FROM users WHERE username = ?";
// Use prepared SQL statements to prevent SQL injection. 
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $existingUsername);
mysqli_stmt_fetch($stmt);

if ($existingUsername) {
  $conn->close();
  die("Username already exists");
}

// Validate password strength
$hasSpecial = preg_match('@[^\w]@', $password);
$hasNumber = preg_match('@[0-9]@', $password);
$hasUpper = preg_match('@[A-Z]@', $password);

if (!(strlen($password) < 9 && $hasUpper && $hasSpecial && $hasNumber)) {
  mysqli_close($conn);
  die('Invalid password. Your password must have at least one number, one special character, one upper case character, and must be longer than 8 characters');
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO users (username, password, firstName, lastName)
VALUES (?, ?, ?, ?)";
// Clean the data that we are storing.
$username = clean($username);
$firstName = clean($firstName);
$lastName = clean($lastName);
// Use prepared SQL statements to prevent SQL injection. 
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ssss", $username, $hashedPassword, $firstName, $lastName);
$status = mysqli_stmt_execute($stmt);

if ($status)
  header("Location: login.php");
else
  echo "Failed: " . $sql . "<br>" . mysqli_error($conn);

$conn->close();

function clean($input) {
  return trim(stripslashes(htmlspecialchars($input)));
}
?>
