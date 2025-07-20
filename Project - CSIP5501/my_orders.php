<?php
session_start();
if (!isset($_SESSION['auth'])) {
  $_SESSION['message'] = "You have to login first";
  header('Location: login.php');
  exit();
}
include("includes/header.php");
include("functions/userfunctions.php");

$orders = getOrders();
?>

<div class="py-3 bg-primary">
  <div class="container">
    <h6 class="text-white">
      <a class="text-white" href="index.php" class="text-white">Home /</a>
      <a class="text-white" href="cart.php" class="text-white">Cart /</a>
      <a class="text-white" href="#">My Orders</a>
    </h6>
  </div>
</div>

<div class="py-5">
  <div class="container product-data">
    <div class="row">
      <div class="col-md-12">
        <h1>Your Orders</h1>
        <hr>

        <?php if (!empty($orders)): ?>
          <div class="card shadow ">
            <div class="card-body">
              <table class="table table-bordered text-center align-middle">
                <thead class="table-dark">
                  <tr>
                    <th width="10%">ID</th>
                    <th width="30%">Tracking No</th>
                    <th width="15%">Price</th>
                    <th width="30%">Date</th>
                    <th width="15%">View</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($orders as $order): ?>
                    <tr>
                      <td><?= htmlspecialchars($order["id"]); ?></td>
                      <td><?= htmlspecialchars($order["tracking_no"]); ?></td>
                      <td>£<?= htmlspecialchars($order["total_price"]); ?></td>
                      <td><?= htmlspecialchars($order["created_at"]); ?></td>
                      <td>
                        <a href="viewOrderDetails.php?tracking_no=<?= htmlspecialchars($order["tracking_no"]); ?>" class="btn btn-primary">View Details</a>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        <?php else: ?>
          <p class="text-center">Your order list is empty.</p>
        <?php endif; ?>

      </div>
    </div>
  </div>
</div>

<?php include("includes/footer.php"); ?>