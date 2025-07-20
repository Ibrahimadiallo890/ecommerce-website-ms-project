<?php
session_start();
if (!isset($_SESSION['auth'])) {
  $_SESSION['message'] = "You have to login first";
  header('Location: login.php');
  exit();
}
include("includes/header.php");
include("functions/userfunctions.php");

if (isset($_GET['category'])) {
  $category_slug = htmlspecialchars($_GET['category']);

  // Fetch category details
  $category = getCategoryBySlug($category_slug);

  if ($category) {
    $category_id = $category['id'];
    $products = getProductsByCategory($category_id);
  } else {
    echo "<h2 class='text-center mt-5'>Category Not Found</h2>";
    exit();
  }
} else {
  echo "<h2 class='text-center mt-5'>Invalid Category</h2>";
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
      <?= htmlspecialchars($category["name"]); ?>
    </h6>
  </div>
</div>

<div class="py-3">
  <div class="container">
    <h2 class="text-center"><?= htmlspecialchars($category["name"]); ?></h2>
    <hr>
    <div class="row">
      <?php
      if ($products):
        foreach ($products as $product):
      ?>
          <div class="col-md-3 mb-2">
            <div class="card shadow">
              <div class="card-body">
                <img src="uploads/<?= htmlspecialchars($product["image"]); ?>" alt="Product Image" class="w-100 mb-2">
                <h4 class="text-center"><?= htmlspecialchars($product["name"]); ?></h4>
                <p class="text-center">Price: $<?= htmlspecialchars($product["selling_price"]); ?></p>
                <a href="viewProduct.php?product=<?= htmlspecialchars($product["slug"]); ?>" class="btn btn-primary w-100">View Product Details</a>
              </div>
            </div>
          </div>
        <?php
        endforeach;
      else:
        ?>
        <p class="text-center">No products available for this collection.</p>
      <?php endif; ?>
    </div>
  </div>
</div>

<?php include("includes/footer.php"); ?>
