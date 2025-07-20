<?php
session_start();
include('includes/header.php');
include('includes/sidebar.php');
include('../middleware/adminMiddleware.php');
include('../server/database.php');
?>

<?php
// Fetch products securely
function getOrders()
{
  global $pdo;
  try {
    $stmt = $pdo->prepare("SELECT * FROM orders WHERE status = 0 ORDER BY id DESC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch as associative array
  } catch (PDOException $e) {
    return []; // Return empty array on failure
  }
}
$orders = getOrders();
?>

<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
  <?php include('includes/navbar.php'); ?>
  <div class="container-fluid py-3">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header bg-primary">
              <h4>Orders
                <a href="orderHistory.php" class="btn btn-warning float-end">Order History</a>
              </h4>
            </div>
            <div class="card-body">
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Tracking No</th>
                    <th>Price</th>
                    <th>Date</th>
                    <th>View</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($orders)): ?>
                    <?php foreach ($orders as $order): ?>
                      <tr>
                        <td><?= htmlspecialchars($order['id']); ?></td>
                        <td><?= htmlspecialchars($order['name']); ?></td>
                        <td><?= htmlspecialchars($order['tracking_no']); ?></td>
                        <td><?= htmlspecialchars($order['total_price']); ?></td>
                        <td><?= htmlspecialchars($order['created_at']); ?></td>
                        <td>
                          <a href="orderDetails.php?tracking_no=<?= htmlspecialchars($order["tracking_no"]); ?>" class="btn btn-primary">View Details</a>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr>
                      <td colspan="5" class="text-center">No orders found</td>
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