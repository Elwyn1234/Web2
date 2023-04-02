<?php
function showTemplate($currentPage) {
  if (session_status() != PHP_SESSION_ACTIVE)
    session_start();
?>

<h2 style="margin: 20px;">Bread & Butter</h2>

<nav class="navbar navbar-expand-lg bg-light">
  <div class="container-fluid">
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-link <?php if ($currentPage === "home") echo 'active" aria-current="page"' ?>" href="home.php">Home</a>
        <a class="nav-link <?php if ($currentPage === "cart") echo 'active" aria-current="page"' ?>" href="cart.php">Cart</a>
        <?php if (array_key_exists('loggedInUser', $_SESSION)) { ?>
        <a class="nav-link" href="onLogout.php">Logout</a>
        <?php } else { ?>
        <a class="nav-link <?php if ($currentPage === "login") echo 'active" aria-current="page"' ?>" href="login.php">Login</a>
        <a class="nav-link <?php if ($currentPage === "register") echo 'active" aria-current="page"' ?>" href="register.php">Register</a>
        <?php } ?>
      </div>
    </div>
  </div>
</nav>

<?php
}
?>
