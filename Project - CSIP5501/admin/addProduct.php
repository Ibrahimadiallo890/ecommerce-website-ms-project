<?php
session_start();
include('includes/header.php');
include('includes/sidebar.php');
include('../middleware/adminMiddleware.php');
include('../server/database.php');
?>

<?php
// Fetch categories securely
function getCategories()
{
  global $pdo;
  try {
    $stmt = $pdo->prepare("SELECT * FROM categories ORDER BY id DESC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch as associative array
  } catch (PDOException $e) {
    return []; // Return empty array on failure
  }
}
$categories = getCategories();
?>

<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
  <?php include('includes/navbar.php'); ?>
  <div class="container-fluid py-0">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h4>Add Products</h4>
            </div>
            <div class="card-body">
              <form action="productProcess.php" method="POST" enctype="multipart/form-data">
                <div class="row">
                  <div class="col-md-12">
                    <label class="mb-0" for="category">Select Category</label>
                    <select class="form-select mb-2" id="category" name="category_id">
                      <option selected disabled>Select Category</option>
                      <?php if (!empty($categories)): ?>
                        <?php foreach ($categories as $category): ?>
                          <option value="<?= htmlspecialchars($category['id']) ?>">
                            <?= htmlspecialchars($category['name']) ?>
                          </option>
                        <?php endforeach; ?>
                      <?php else: ?>
                        <option disabled>No categories found</option>
                      <?php endif; ?>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label class="mb-0">Name</label>
                    <input type="text" class="form-control mb-2" name="name" id="" placeholder="Enter Product Name" required>
                  </div>

                  <div class="col-md-6">
                    <label class="mb-0">Slug</label>
                    <input type="text" class="form-control mb-2" name="slug" id="" placeholder="Enter slug" required>
                  </div>

                  <div class="col-md-12">
                    <label class="mb-0">Small Description</label>
                    <textarea name="small_description" rows="3" class="form-control mb-2" id="" placeholder="Enter small description" required></textarea>
                  </div>

                  <div class="col-md-12">
                    <label class="mb-0">Description</label>
                    <textarea name="description" rows="3" class="form-control mb-2" id="" placeholder="Enter description" required></textarea>
                  </div>

                  <div class="col-md-6">
                    <label class="mb-0">Original Price</label>
                    <input type="number" class="form-control mb-2" name="original_price" id="" placeholder="Enter original price" required>
                  </div>

                  <div class="col-md-6">
                    <label class="mb-0">Selling Price</label>
                    <input type="number" class="form-control mb-2" name="selling_price" id="" placeholder="Enter selling price" required>
                  </div>

                  <div class="col-md-12">
                    <label class="mb-0">Upload Image</label>
                    <input type="file" name="image" class="form-control mb-2">
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                      <label class="mb-0">Quantity</label>
                      <input type="number" class="form-control mb-2" name="quantity" id="" placeholder="Enter Quantity" required>
                    </div>

                    <div class="col-md-3">
                      <label class="mb-0">Status</label> <br>
                      <input type="checkbox" name="status">
                    </div>

                    <div class="col-md-3">
                      <label class="mb-0">Trending</label> <br>
                      <input type="checkbox" name="trending">
                    </div>
                  </div>

                  <div class="col-md-12">
                    <label class="mb-0">Meta Tittle</label>
                    <input type="text" class="form-control mb-2" name="meta_title" id="" placeholder="Enter meta tittle">
                  </div>

                  <div class="col-md-12">
                    <label class="mb-0">Meta Description</label>
                    <textarea name="meta_description" rows="3" class="form-control mb-2" id="" placeholder="Enter meta description"></textarea>
                  </div>

                  <div class="col-md-12">
                    <label class="mb-0">Meta Keywords</label>
                    <textarea name="meta_keywords" rows="3" class="form-control mb-2" id="" placeholder="Enter meta keywords"></textarea>
                  </div>

                  <div class="col-md-12">
                    <button type="submit" class="btn btn-primary" name="add_product_btn">Save</button>
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