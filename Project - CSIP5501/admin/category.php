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
  <div class="container-fluid py-3">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h4>Categories</h4>
            </div>
            <div class="card-body">
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Status</th>
                    <th>Edit</th>
                    <th>Delete</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($categories)): ?>
                    <?php foreach ($categories as $category): ?>
                      <tr>
                        <td><?= htmlspecialchars($category['id']); ?></td>
                        <td><?= htmlspecialchars($category['name']); ?></td>
                        <td>
                          <img src="../uploads/<?= htmlspecialchars($category['image']); ?>" width="50" height="50" alt="Category Image">
                        </td>
                        <td><?= $category['status'] ? 'Visible' : 'Hidden'; ?></td>
                        <td>
                          <a href="editCategory.php?id=<?= $category['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                        </td>
                        <td>
                          <button type="button" class="btn btn-sm btn-danger delete_category_btn" data-id="<?= $category['id']; ?>">
                            Delete
                          </button>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr>
                      <td colspan="5" class="text-center">No categories found</td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<?php include('includes/footer.php'); ?>
