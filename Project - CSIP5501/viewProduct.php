<?php
session_start();
if (!isset($_SESSION['auth'])) {
  $_SESSION['message'] = "You have to login first";
  header('Location: login.php');
  exit();
}
include("includes/header.php");
include("functions/userfunctions.php");

if (isset($_GET['product'])) {
  $product_slug = htmlspecialchars($_GET['product']);

  // Fetch product details
  $product = getProductBySlug($product_slug);

  if (!$product) {
    echo "<h2 class='text-center mt-5'>Product Not Found</h2>";
    exit();
  }
} else {
  echo "<h2 class='text-center mt-5'>Invalid Product</h2>";
  exit();
}
?>

<div class="py-3 bg-primary">
  <div class="container">
    <h6 class="text-white">
      <a class="text-white" href="index.php">
        Home /
      </a>
      <a class="text-white" href="collections.php">
        Collections /
      </a>
      <?= htmlspecialchars($product["name"]); ?>
    </h6>
  </div>
</div>

<div class="bg-light py-4">
  <div class="container product-data mt-3">
    <div class="row">
      <div class="col-md-4">
        <div class="shadow">
          <img src="uploads/<?= htmlspecialchars($product["image"]); ?>" alt="Product Image" class="w-100">
        </div>
      </div>
      <div class="col-md-8">
        <h4 class="fw-bold"><?= htmlspecialchars($product["name"]); ?>
          <span class="float-end text-danger"><?php if ($product['trending']) {echo "Trending";} ?></span>
        </h4>

        <hr>
        <p><?= htmlspecialchars($product["small_description"]); ?></p>

        <div class="row">
          <div class="col-md-6">
            <h5>Selling Price: <span class="text-success fw-bold">$<?= htmlspecialchars($product["selling_price"]); ?></span></h5>
          </div>
          <div class="col-md-6">
            <h5>Original Price: <s class="text-danger">$<?= htmlspecialchars($product["original_price"]); ?></s></h5>
          </div>
        </div>

        <div class="row">
          <div class="col-md-4">
            <div class="input-group mb-3" style="width: 130px;">
              <button class="input-group-text decrement-btn">-</button>
              <input type="text" class="form-control product-quantity text-center bg-white" disabled value="1">
              <button class="input-group-text increment-btn">+</button>
            </div>
          </div>
        </div>

        <div class="row mt-3">
          <div class="col-md-6">
            <button class="btn btn-primary px-4 addToCartBtn" value="<?= htmlspecialchars($product["id"]); ?>"><i class="fa fa-shopping-cart me-2">Add to Cart</i></button>
          </div>
          <div class="col-md-6">
            <button class="btn btn-danger px-4"><i class="fa fa-heart me-2">Add to Wishlist</i></button>
          </div>
        </div>

        <hr>

        <h6>Product Description</h6>
        <p><?= htmlspecialchars($product["description"]); ?></p>
        <hr>
      </div>
    </div>
  </div>
</div>

<?php include("includes/footer.php"); ?>