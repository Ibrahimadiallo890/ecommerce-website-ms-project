<?php session_start(); 
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
?>

<nav class="navbar navbar-expand-lg sticky-top bg-dark shadow">
  <div class="container">
    <a class="navbar-brand text-white" href="index.php">224-UNLIMITED-TRADE</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link text-white active" aria-current="page" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="collections.php">Collections</a>
        </li>

        <?php if (isset($_SESSION['auth']) && !empty($_SESSION['auth_user'])): ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <?= htmlspecialchars($_SESSION['auth_user']['name']); ?>
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="cart.php">Cart</a></li>
              <li><a class="dropdown-item" href="my_orders.php">Orders</a></li>
              <li><a class="dropdown-item" href="settings.php">Settings</a></li>
              <li><a class="dropdown-item" href="logout.php">Logout</a></li>
            </ul>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <a class="nav-link text-white" href="register.php">Register</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="login.php">Login</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
