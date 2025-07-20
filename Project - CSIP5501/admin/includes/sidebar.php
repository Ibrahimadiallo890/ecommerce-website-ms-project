<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-gradient-dark" id="sidenav-main">
  <div class="sidenav-header">
    <a class="navbar-brand m-0" href="dashboard.php">
      <img src="" alt="">
      <span class="ms-1 font-weight-bold text-white">224-UNLIMITED-TRADE</span>
    </a>
  </div>
  <hr class="horizontal light mt-0 mb-2">
  <div class="collapse navbar-collapse w-auto max-height-vh-100" id="sidenav-collapse-main">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link text-white <?= ($current_page == 'index.php') ? 'active bg-gradient-primary' : '' ?>" href="index.php">
          <i class="material-icons opacity-10">Dashboard</i>
          <span class="nav-link-text ms-1"></span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white <?= ($current_page == 'category.php') ? 'active bg-gradient-primary' : '' ?>" href="category.php">
          <i class="material-icons opacity-10">All Categories</i>
          <span class="nav-link-text ms-1"></span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white <?= ($current_page == 'addCategory.php') ? 'active bg-gradient-primary' : '' ?>" href="addCategory.php">
          <i class="material-icons opacity-10">Add Category</i>
          <span class="nav-link-text ms-1"></span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white <?= ($current_page == 'product.php') ? 'active bg-gradient-primary' : '' ?>" href="product.php">
          <i class="material-icons opacity-10">All Products</i>
          <span class="nav-link-text ms-1"></span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white <?= ($current_page == 'addProduct.php') ? 'active bg-gradient-primary' : '' ?>" href="addProduct.php">
          <i class="material-icons opacity-10">Add Product</i>
          <span class="nav-link-text ms-1"></span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white <?= ($current_page == 'orderManagement.php') ? 'active bg-gradient-primary' : '' ?>" href="orderManagement.php">
          <i class="material-icons opacity-10">Orders</i>
          <span class="nav-link-text ms-1"></span>
        </a>
      </li>
    </ul>
  </div>
  <div class="sidenav-footer position-absolute w-100 bottom-0">
    <div class="mx-3">
      <a class="btn bg-gradient-primary mt-4 w-100" href="../logout.php" type="button">Logout</a>
    </div>
  </div>
</aside>