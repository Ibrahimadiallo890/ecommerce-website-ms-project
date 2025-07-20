<?php
session_start();
include("../server/database.php");
include("userfunctions.php");

if (isset($_POST['placeOrderBtn'])) {
  $name = htmlspecialchars(trim($_POST['name']));
  $email = htmlspecialchars(trim($_POST['email']));
  $phone = htmlspecialchars(trim($_POST['phone_number']));
  $postalCode = htmlspecialchars(trim($_POST['postal_code']));
  $address = htmlspecialchars(trim($_POST['address'])); // Fixed issue here
  $paymentMode = htmlspecialchars(trim($_POST['payment_mode']));
  $paymentId = htmlspecialchars(trim($_POST['payment_id']));

  if (empty($name) || empty($email) || empty($phone) || empty($postalCode) || empty($address)) {
    redirect("../checkout.php", "All fields are mandatory.");
    exit();
  }

  // Generate a unique tracking number
  $tracking_no = "TRADE-" . strtoupper(bin2hex(random_bytes(4))) . "-" . time();

  // Ensure user ID is retrieved correctly
  $user_id = intval($_SESSION['auth_user']['user_id']);

  // Calculate total price
  $carts = getCartItems();
  $total = 0;
  foreach ($carts as $cart) {
    $total += $cart["selling_price"] * $cart["product_quantity"];
  }

  try {
    // Ensure tracking number is unique
    do {
      $check_stmt = $pdo->prepare("SELECT COUNT(*) FROM orders WHERE tracking_no = ?");
      $check_stmt->execute([$tracking_no]);
      $count = $check_stmt->fetchColumn();
      if ($count > 0) {
        $tracking_no = "224-UNLIMITED-TRADE" . rand(1111, 9999) . substr($phone, 2); // Regenerate if exists
      }
    } while ($count > 0);

    // Insert order into database
    $stmt = $pdo->prepare("INSERT INTO orders (tracking_no, user_id, name, email, phone_number, address, postal_code, total_price, payment_mode, payment_id) 
                               VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $orderInserted = $stmt->execute([$tracking_no, $user_id, $name, $email, $phone, $address, $postalCode, $total, $paymentMode, $paymentId]);

    if ($orderInserted) {
      $order_id = $pdo->lastInsertId(); // Get the last inserted order ID

      $insert_items_query = $pdo->prepare("INSERT INTO order_items (order_id, product_id, product_quantity, price) VALUES (?, ?, ?, ?)");

      foreach ($carts as $cart) {
        $product_id = $cart['product_id'];
        $quantity = $cart['product_quantity']; // Fixed incorrect variable name
        $price = $cart['selling_price'];

        if ($insert_items_query->execute([$order_id, $product_id, $quantity, $price])) {
          // Remove items from the cart after order placement
          $deleteCart = $pdo->prepare("DELETE FROM carts WHERE user_id = ? AND product_id = ?");
          $deleteCart->execute([$user_id, $product_id]); // Fixed incorrect execution
        }

        // Fetch current product quantity
        $fetch_query = $pdo->prepare("SELECT quantity FROM products WHERE id = ? LIMIT 1");
        $fetch_query->execute([$product_id]);
        $product = $fetch_query->fetch(PDO::FETCH_ASSOC);

        if ($product) {
          $new_quantity = $product['quantity'] - $quantity;

          // Ensure quantity doesn't go negative
          if ($new_quantity < 0) {
            $new_quantity = 0;
          }

          // Update product quantity in the database
          $update_query = $pdo->prepare("UPDATE products SET quantity = ? WHERE id = ?");
          $update_query->execute([$new_quantity, $product_id]);
        }
      }

      redirect("../my_orders.php", "Order placed successfully!");
      exit();
    } else {
      redirect("../checkout.php", "Failed to place order. Please try again.");
      exit();
    }
  } catch (PDOException $e) {
    redirect("../checkout.php", "Database error: " . $e->getMessage());
    exit();
  }
} else {
  header("Location: ../index.php");
  exit();
}
