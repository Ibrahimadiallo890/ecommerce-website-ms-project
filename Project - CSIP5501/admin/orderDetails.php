<?php
session_start();
include('includes/header.php');
include('includes/sidebar.php');
include('../middleware/adminMiddleware.php');
include('../server/database.php');
?>

<?php
$orderData = null;
$orderItems = [];

if (isset($_GET['tracking_no'])) {
  $tracking_no = $_GET['tracking_no'];
  $orderData = checkTrackingNoValid($tracking_no);

  if ($orderData) {
    global $pdo;
    try {
      $stmt = $pdo->prepare("SELECT oi.*, p.name AS product_name, p.image AS product_image FROM order_items oi JOIN products p ON oi.product_id = p.id JOIN orders o ON oi.order_id = o.id WHERE o.tracking_no = ?");
      $stmt->execute([$tracking_no]); // Only pass tracking_no
      $orderItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      error_log("Database Error: " . $e->getMessage());
      $_SESSION['message'] = "Failed to retrieve order details.";
    }
  }
}
?>


<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
  <?php include('includes/navbar.php'); ?>
  <div class="container-fluid py-3">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
              <h4 class="text-white mb-0"><i></i> View Order</h4>
              <a href="orderManagement.php" class="btn btn-warning"><i class="bi bi-arrow-left"></i> Back to Orders</a>
            </div>
            <div class="card-body">
              <?php if ($orderData) : ?>
                <div class="row">
                  <div class="col-md-6">
                    <div class="card shadow-sm border-0">
                      <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="bi bi-truck"></i> Delivery Details</h5>
                      </div>
                      <div class="card-body">
                        <ul class="list-group list-group-flush">
                          <li class="list-group-item"><strong>Name:</strong> <?= htmlspecialchars($orderData['name'] ?? 'N/A'); ?></li>
                          <li class="list-group-item"><strong>Email:</strong> <?= htmlspecialchars($orderData['email'] ?? 'N/A'); ?></li>
                          <li class="list-group-item"><strong>Phone:</strong> <?= htmlspecialchars($orderData['phone_number'] ?? 'N/A'); ?></li>
                          <li class="list-group-item"><strong>Tracking Number:</strong> <?= htmlspecialchars($orderData['tracking_no'] ?? 'N/A'); ?></li>
                          <li class="list-group-item"><strong>Address:</strong> <?= htmlspecialchars($orderData['address'] ?? 'N/A'); ?></li>
                          <li class="list-group-item"><strong>Postal Code:</strong> <?= htmlspecialchars($orderData['postal_code'] ?? 'N/A'); ?></li>
                        </ul>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="table-responsive">
                      <table class="table table-bordered text-center">
                        <thead class="bg-light">
                          <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($orderItems as $item) : ?>
                            <tr>
                              <td><img src="../uploads/<?= htmlspecialchars($item['product_image']); ?>" alt="Product" width="50"></td>
                              <td><?= htmlspecialchars($item['product_name']); ?></td>
                              <td><?= htmlspecialchars($item['product_quantity']); ?></td>
                              <td>£<?= htmlspecialchars(number_format($item['price'], 2)); ?></td>
                            </tr>
                          <?php endforeach; ?>
                        </tbody>
                      </table>
                    </div>
                    <h4 class="text-end mt-3">Total Price: <span class="fw-bold">£<?= htmlspecialchars(number_format($orderData['total_price'] ?? 0, 2)); ?></span></h4>
                    <hr>
                    <div class="p-2 border rounded">
                      <strong>Payment Mode:</strong> <?= htmlspecialchars($orderData['payment_mode']); ?>
                    </div>
                    <div class="p-4 border rounded mt-3 bg-white shadow-sm">
                      <form action="updateOrderStatus.php" method="POST">
                        <input type="hidden" name="tracking_no" value="<?= htmlspecialchars($orderData['tracking_no']); ?>">

                        <label for="order_status" class="form-label fw-bold text-dark d-flex align-items-center">
                          <i class="bi bi-info-circle me-2"></i> Order Status:
                        </label>

                        <select name="order_status" id="order_status" class="form-select shadow-sm mb-3">
                          <option value="0" <?= $orderData['status'] == 0 ? "selected" : "" ?>>🟠 Under Process</option>
                          <option value="1" <?= $orderData['status'] == 1 ? "selected" : "" ?>>✅ Completed</option>
                          <option value="2" <?= $orderData['status'] == 2 ? "selected" : "" ?>>❌ Cancelled</option>
                        </select>

                        <div class="text-end">
                          <button type="submit" name="updateOrderBtn" class="btn btn-primary shadow-sm">
                            <i class="bi bi-check-circle"></i> Update Status
                          </button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              <?php else : ?>
                <h4 class="text-danger">Invalid Tracking Number</h4>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

<?php include('includes/footer.php'); ?>