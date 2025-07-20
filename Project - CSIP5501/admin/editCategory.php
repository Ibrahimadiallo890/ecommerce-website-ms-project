<?php
session_start();
include('includes/header.php');
include('includes/sidebar.php');
include('../middleware/adminMiddleware.php');
include('../server/database.php');

// Check if ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  redirect("category.php", "Invalid Category ID!");
  exit();
}

$category_id = intval($_GET['id']);

// Fetch category details
try {
  $stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
  $stmt->execute([$category_id]);
  $category = $stmt->fetch(PDO::FETCH_ASSOC);

  if (!$category) {
    redirect("category.php", "Category not found!");
    exit();
  }
} catch (PDOException $e) {
  redirect("category.php", "Database error: " . $e->getMessage());
  exit();
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
              <h4>Edit Category
                <a href="category.php" class="btn btn-primary float-end">Back</a>
              </h4>
            </div>
            <div class="card-body">
              <form action="categoryProcess.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="category_id" value="<?= htmlspecialchars($category['id']); ?>">

                <div class="row">
                  <div class="col-md-6">
                    <label for="">Name</label>
                    <input type="text" class="form-control" name="name" value="<?= htmlspecialchars($category['name']); ?>" required>
                  </div>

                  <div class="col-md-6">
                    <label for="">Slug</label>
                    <input type="text" class="form-control" name="slug" value="<?= htmlspecialchars($category['slug']); ?>" required>
                  </div>

                  <div class="col-md-12">
                    <label for="">Description</label>
                    <textarea name="description" rows="3" class="form-control" required><?= htmlspecialchars($category['description']); ?></textarea>
                  </div>

                  <div class="col-md-12">
                    <label for="">Current Image</label><br>
                    <img src="../uploads/<?= htmlspecialchars($category['image']); ?>" width="100" height="100" alt="Category Image">
                  </div>

                  <div class="col-md-12">
                    <label for="">Upload New Image</label>
                    <input type="file" name="image" class="form-control">
                  </div>

                  <div class="col-md-12">
                    <label for="">Meta Title</label>
                    <input type="text" class="form-control" name="meta_title" value="<?= htmlspecialchars($category['meta_title']); ?>">
                  </div>

                  <div class="col-md-12">
                    <label for="">Meta Description</label>
                    <textarea name="meta_description" rows="3" class="form-control"><?= htmlspecialchars($category['meta_description']); ?></textarea>
                  </div>

                  <div class="col-md-12">
                    <label for="">Meta Keywords</label>
                    <textarea name="meta_keywords" rows="3" class="form-control"><?= htmlspecialchars($category['meta_keywords']); ?></textarea>
                  </div>

                  <div class="col-md-6">
                    <label for="">Status</label>
                    <input type="checkbox" name="status" <?= $category['status'] ? 'checked' : ''; ?>>
                  </div>

                  <div class="col-md-6">
                    <label for="">Popular</label>
                    <input type="checkbox" name="popular" <?= $category['popular'] ? 'checked' : ''; ?>>
                  </div>

                  <div class="col-md-12">
                    <button type="submit" class="btn btn-primary" name="edit_category_btn">Update</button>
                    <a href="category.php" class="btn btn-secondary">Cancel</a>
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