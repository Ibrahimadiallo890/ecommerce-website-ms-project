<?php
session_start();
include("../server/database.php");

header('Content-Type: application/json'); // Ensure JSON response

if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
  echo json_encode(["status" => 401, "message" => "Login to continue"]);
  exit();
}

if (!isset($_POST['scope'], $_POST['product_id'])) {
  echo json_encode(["status" => 400, "message" => "Missing required data"]);
  exit();
}

$scope = $_POST['scope'];
$product_id = intval($_POST['product_id']);
$user_id = intval($_SESSION['auth_user']['user_id']); // Ensure correct user_id
$product_quantity = isset($_POST['product_quantity']) ? intval($_POST['product_quantity']) : 1;

try {
  // Check if the product exists in the cart
  $check_stmt = $pdo->prepare("SELECT id FROM carts WHERE product_id = ? AND user_id = ?");
  $check_stmt->execute([$product_id, $user_id]);
  $cart_item = $check_stmt->fetch();

  if ($scope === 'add') {
    if ($cart_item) {
      echo json_encode(["status" => "existing", "message" => "Product already in cart"]);
      exit();
    }

    // Insert new product into the cart
    $stmt = $pdo->prepare("INSERT INTO carts (user_id, product_id, product_quantity) VALUES (?, ?, ?)");
    if ($stmt->execute([$user_id, $product_id, $product_quantity])) {
      echo json_encode(["status" => 201, "message" => "Product added to cart"]);
    } else {
      echo json_encode(["status" => 500, "message" => "Failed to insert into database"]);
    }
    exit();
  }

  if ($scope === 'update') {
    if (!$cart_item) {
      echo json_encode(["status" => 404, "message" => "Product not found in cart"]);
      exit();
    }

    if ($product_quantity < 1) {
      echo json_encode(["status" => 400, "message" => "Invalid quantity"]);
      exit();
    }

    // Update product quantity in the cart
    $update_stmt = $pdo->prepare("UPDATE carts SET product_quantity = ? WHERE product_id = ? AND user_id = ?");
    $update_stmt->execute([$product_quantity, $product_id, $user_id]);

    echo json_encode(["status" => 200, "message" => "Cart updated successfully"]);
    exit();
  }

  if ($scope === 'delete') {
    if (!$cart_item) {
      echo json_encode(["status" => 404, "message" => "Product not found in cart"]);
      exit();
    }

    // Delete the item from the cart
    $stmt = $pdo->prepare("DELETE FROM carts WHERE user_id = ? AND product_id = ?");
    if ($stmt->execute([$user_id, $product_id])) {
      echo json_encode(["status" => 200, "message" => "Product removed from cart"]);
    } else {
      echo json_encode(["status" => 500, "message" => "Failed to remove item"]);
    }
    exit();
  }

  echo json_encode(["status" => 400, "message" => "Invalid request"]);
  exit();
} catch (PDOException $e) {
  error_log("Database error: " . $e->getMessage()); // Log error
  echo json_encode(["status" => 500, "message" => "Database error. Try again later."]);
  exit();
}
