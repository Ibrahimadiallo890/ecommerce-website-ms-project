<?php
session_start();
include("../server/database.php");
include("../functions/myfunctions.php");

if (isset($_POST['updateOrderBtn'])) {
  $tracking_no = htmlspecialchars(trim($_POST['tracking_no']));
  $order_status = intval($_POST['order_status']); // Convert status to an integer

  // Validate if tracking number exists
  $stmt = $pdo->prepare("SELECT id FROM orders WHERE tracking_no = ?");
  $stmt->execute([$tracking_no]);
  $order = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($order) {
    try {
      // Update order status
      $updateStmt = $pdo->prepare("UPDATE orders SET status = ? WHERE tracking_no = ?");
      $updateStmt->execute([$order_status, $tracking_no]);

      redirect("orderHistory.php", "Order status updated successfully!");
      exit();
    } catch (PDOException $e) {
      redirect("orderDetails.php", "Database error: " . $e->getMessage());
    }
  } else {
    redirect("orderDetails.php", "Invalid tracking number.");
    exit();
  }
}