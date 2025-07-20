<?php
session_start();
if (!isset($_SESSION['auth'])) {
  $_SESSION['message'] = "You have to login first";
  header('Location: login.php');
  exit();
}

include("includes/header.php");
include("functions/userfunctions.php");

$orderData = null;
$orderItems = [];

if (isset($_GET['tracking_no'])) {
  $tracking_no = $_GET['tracking_no'];
  $orderData = checkTrackingNoValid($tracking_no);

  if ($orderData) {
    $user_id = (int) $_SESSION['auth_user']['user_id'];
    global $pdo;
    try {
      $stmt = $pdo->prepare("SELECT oi.*, p.name AS product_name, p.image AS product_image 
                                   FROM order_items oi
                                   JOIN products p ON oi.product_id = p.id
                                   JOIN orders o ON oi.order_id = o.id
                                   WHERE o.user_id = ? AND o.tracking_no = ?");
      $stmt->execute([$user_id, $tracking_no]);
      $orderItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      error_log("Database Error: " . $e->getMessage());
      $_SESSION['message'] = "Failed to retrieve order details.";
    }
  }
}
?>

<div class="py-3 bg-primary">
  <div class="container">
    <h6 class="text-white">
      <a class="text-white" href="index.php">Home /</a>
      <a class="text-white" href="my_orders.php">My Orders /</a>
      <a class="text-white" href="#">View Order</a>
    </h6>
  </div>
</div>

<div class="py-5">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="card shadow-sm border-0">
          <div class="card-header bg-dark text-white d-flex align-items-center justify-content-between">
            <h4 class="mb-0"><i class="bi bi-receipt-cutoff"></i> View Order</h4>
            <a href="my_orders.php" class="btn btn-light btn-sm"><i class="bi bi-arrow-left"></i> Back to Orders</a>
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
                            <td><img src="uploads/<?= htmlspecialchars($item['product_image']); ?>" alt="Product" width="50"></td>
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
                  <div class="p-2 border rounded mt-2">
                    <strong>Status:</strong>
                    <?php
                    switch ($orderData['status']) {
                      case 0:
                        echo "Under Process";
                        break;
                      case 1:
                        echo "Completed";
                        break;
                      case 2:
                        echo "Cancelled";
                        break;
                      default:
                        echo "Unknown Status";
                    }
                    ?>
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

<?php include("includes/footer.php"); ?>
