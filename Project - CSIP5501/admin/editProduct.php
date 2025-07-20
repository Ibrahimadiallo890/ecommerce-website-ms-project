<?php
session_start();
include('includes/header.php');
include('includes/sidebar.php');
include('../middleware/adminMiddleware.php');
include('../server/database.php');

// Check if ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  redirect("product.php", "Invalid Product ID!");
  exit();
}

$product_id = intval($_GET['id']);

// Fetch product details
try {
  $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?"); // Ensure correct table name
  $stmt->execute([$product_id]);
  $product = $stmt->fetch(PDO::FETCH_ASSOC);

  if (!$product) {
    redirect("product.php", "Product not found!");
    exit();
  }
} catch (PDOException $e) {
  redirect("product.php", "Database error: " . $e->getMessage());
  exit();
}

// Fetch categories (Ensure this is included)
try {
  $stmt = $pdo->prepare("SELECT id, name FROM categories");
  $stmt->execute();
  $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  $categories = [];
}
?>

<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
  <?php include('includes/navbar.php'); ?>
  <div class="container-fluid py-0">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h4>Edit Product
                <a href="product.php" class="btn btn-primary float-end">Back</a>
              </h4>
            </div>
            <div class="card-body">
              <form action="productProcess.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']); ?>">

                <div class="col-md-12">
                  <label class="mb-0" for="category">Select Category</label>
                  <select class="form-select mb-2" id="category" name="category_id">
                    <option selected disabled>Select Category</option>
                    <?php if (!empty($categories)): ?>
                      <?php foreach ($categories as $category): ?>
                        <option value="<?= htmlspecialchars($category['id']) ?>"
                          <?= $product['category_id'] == $category['id'] ? 'selected' : ''; ?>>
                          <?= htmlspecialchars($category['name']) ?>
                        </option>
                      <?php endforeach; ?>
                    <?php else: ?>
                      <option disabled>No categories found</option>
                    <?php endif; ?>
                  </select>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <label class="mb-0" for="">Name</label>
                    <input type="text" class="form-control mb-2" name="name" value="<?= htmlspecialchars($product['name']); ?>" required>
                  </div>

                  <div class="col-md-6">
                    <label class="mb-0" for="">Slug</label>
                    <input type="text" class="form-control mb-2" name="slug" value="<?= htmlspecialchars($product['slug']); ?>" required>
                  </div>

                  <div class="col-md-12">
                    <label class="mb-0" class="mb-0">Small Description</label>
                    <textarea name="small_description" rows="3" class="form-control mb-2" required><?= htmlspecialchars($product['small_description']); ?></textarea>
                  </div>

                  <div class="col-md-12">
                    <label class="mb-0" for="">Description</label>
                    <textarea name="description" rows="3" class="form-control mb-2" required><?= htmlspecialchars($product['description']); ?></textarea>
                  </div>

                  <div class="col-md-6">
                    <label class="mb-0" class="mb-0">Original Price</label>
                    <input type="number" name="original_price" class="form-control mb-2 mb-2" required value="<?= htmlspecialchars($product['original_price']); ?>" placeholder="Enter original price">
                  </div>

                  <div class="col-md-6">
                    <label class="mb-0" class="mb-0">Selling Price</label>
                    <input type="number" name="selling_price" class="form-control mb-2 mb-2" required value="<?= htmlspecialchars($product['selling_price']); ?>" placeholder="Enter selling price">
                  </div>

                  <div class="col-md-12">
                    <label class="mb-0" for="">Current Image</label><br>
                    <img src="../uploads/<?= htmlspecialchars($product['image']); ?>" width="100" height="100" alt="Product Image">
                  </div>

                  <div class="col-md-12">
                    <label class="mb-0" for="">Upload New Image</label>
                    <input type="file" name="image" class="form-control">
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                      <label class="mb-0" class="mb-0">Quantity</label>
                      <input type="number" class="form-control mb-2" name="quantity" value="<?= htmlspecialchars($product['quantity']); ?>" required>
                    </div>

                    <div class="col-md-3">
                      <label class="mb-0" for="">Status</label> <br>
                      <input type="checkbox" name="status" <?= $product['status'] ? 'checked' : ''; ?>>
                    </div>

                    <div class="col-md-3">
                      <label class="mb-0" for="">Trending</label> <br>
                      <input type="checkbox" name="trending" <?= $product['trending'] ? 'checked' : ''; ?>>
                    </div>
                  </div>

                  <div class="col-md-12">
                    <label class="mb-0" for="">Meta Title</label>
                    <input type="text" class="form-control mb-2" name="meta_title" value="<?= htmlspecialchars($product['meta_title']); ?>">
                  </div>

                  <div class="col-md-12">
                    <label class="mb-0" for="">Meta Description</label>
                    <textarea name="meta_description" rows="3" class="form-control mb-2"><?= htmlspecialchars($product['meta_description']); ?></textarea>
                  </div>

                  <div class="col-md-12">
                    <label class="mb-0" for="">Meta Keywords</label>
                    <textarea name="meta_keywords" rows="3" class="form-control mb-2"><?= htmlspecialchars($product['meta_keywords']); ?></textarea>
                  </div>

                  <div class="col-md-12">
                    <button type="submit" class="btn btn-primary" name="edit_product_btn">Update</button>
                    <a href="product.php" class="btn btn-secondary">Cancel</a>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<?php include('includes/footer.php'); ?>