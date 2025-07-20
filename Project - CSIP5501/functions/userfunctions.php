<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
include("server/database.php");

// Secure function to fetch all rows from a table
function getALLActive($table)
{
  global $pdo;

  // Validate table name to prevent SQL injection
  $allowed_tables = ['categories', 'users', 'products', 'carts']; // Add only allowed tables
  if (!in_array($table, $allowed_tables)) {
    return []; // Return empty if table is not allowed
  }

  try {
    $stmt = $pdo->prepare("SELECT * FROM `$table` WHERE status = 1"); // Use integer for status
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch as an associative array
  } catch (PDOException $e) {
    error_log("Database Error: " . $e->getMessage()); // Log error for debugging
    return []; // Return empty on failure
  }
}

// Function to handle redirection with messages
function redirect($url, $message)
{
  $_SESSION['message'] = $message;
  header("Location: " . $url);
  exit();
}

// Fetch category details by slug
function getCategoryBySlug($slug)
{
  global $pdo;
  try {
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE slug = ? AND status = 1");
    $stmt->execute([$slug]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    error_log("Database Error: " . $e->getMessage());
    return null;
  }
}

// Fetch products belonging to a category
function getProductsByCategory($category_id)
{
  global $pdo;
  try {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE category_id = ? AND status = 1");
    $stmt->execute([$category_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    error_log("Database Error: " . $e->getMessage());
    return [];
  }
}

// Fetch product details by slug
function getProductBySlug($slug)
{
  global $pdo;
  try {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE slug = ? AND status = 1");
    $stmt->execute([$slug]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    error_log("Database Error: " . $e->getMessage());
    return null;
  }
}

// Fetch carts details
function getCartItems()
{
  global $pdo;

  if (!isset($_SESSION['auth_user']['user_id'])) {
    return [];
  }

  $user_id = $_SESSION['auth_user']['user_id'];

  try {
    $stmt = $pdo->prepare("SELECT 
        c.id as cart_id, c.product_id, c.product_quantity, 
        p.id as pid, p.name, p.image, p.selling_price 
      FROM carts c 
      JOIN products p ON c.product_id = p.id 
      WHERE c.user_id = ? 
      ORDER BY c.id DESC");

    $stmt->execute([$user_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch multiple rows
  } catch (PDOException $e) {
    error_log("Database Error: " . $e->getMessage());
    return [];
  }
}

// Fetch order details
function getOrders()
{
  global $pdo;

  if (!isset($_SESSION['auth_user']['user_id'])) {
    return [];
  }

  $user_id = (int) $_SESSION['auth_user']['user_id']; // Ensure it's an integer

  try {
    $stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
    $stmt->execute([$user_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch multiple rows
  } catch (PDOException $e) {
    error_log("Database Error: " . $e->getMessage());
    return false; // Return false to indicate failure
  }
}

// Check tracking details
function checkTrackingNoValid($trackingNo)
{
  global $pdo;

  if (!isset($_SESSION['auth_user']['user_id'])) {
    return null; // Return null if user is not authenticated
  }

  $user_id = (int) $_SESSION['auth_user']['user_id']; // Ensure it's an integer
  $trackingNo = trim($trackingNo); // Remove spaces

  try {
    $stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = ? AND tracking_no = ?");
    $stmt->execute([$user_id, $trackingNo]);
    return $stmt->fetch(PDO::FETCH_ASSOC); // Fetch a single row
  } catch (PDOException $e) {
    error_log("Database Error: " . $e->getMessage());
    return null; // Return null on failure
  }
}

// Fetch all trending products
function getAllTrending()
{
  global $pdo;
  try {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE trending = 1");
    $stmt->execute(); // No arguments needed
    return $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all trending products
  } catch (PDOException $e) {
    error_log("Database Error: " . $e->getMessage());
    return []; // Return empty array instead of null for consistency
  }
}


