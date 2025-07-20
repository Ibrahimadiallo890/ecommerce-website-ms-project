<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
include("../server/database.php");

// Function to handle redirection with messages
function redirect($url, $message)
{
  $_SESSION['message'] = $message;
  header("Location: " . $url);
  exit();
}

// Check tracking details
function checkTrackingNoValid($trackingNo)
{
  global $pdo;

  try {
    $stmt = $pdo->prepare("SELECT * FROM orders WHERE tracking_no = ?");
    $stmt->execute([$trackingNo]);
    return $stmt->fetch(PDO::FETCH_ASSOC); // Fetch a single row
  } catch (PDOException $e) {
    error_log("Database Error: " . $e->getMessage());
    return null; // Return null on failure
  }
}

// Function to get number of users, products, orders, categories.
function getCount($tableName)
{
  $allowedTables = ['users', 'products', 'categories', 'orders', 'carts'];
  if (!in_array($tableName, $allowedTables)) {
    throw new Exception("Invalid table name");
  }

  $sql = "SELECT COUNT(*) AS number FROM $tableName";
  $req = $GLOBALS['pdo']->prepare($sql);
  $req->execute();

  return $req->fetch(PDO::FETCH_ASSOC);
}
