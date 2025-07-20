<?php
session_start();
include("../server/database.php");
include("../functions/myfunctions.php");

if (isset($_POST['add_product_btn']) || isset($_POST['edit_product_btn'])) {
  $category_id = htmlspecialchars(trim($_POST['category_id']));
  $name = htmlspecialchars(trim($_POST['name']));
  $slug = htmlspecialchars(trim($_POST['slug']));
  $small_description = htmlspecialchars(trim($_POST['small_description']));
  $description = htmlspecialchars(trim($_POST['description']));
  $original_price = htmlspecialchars(trim($_POST['original_price']));
  $selling_price = htmlspecialchars(trim($_POST['selling_price']));
  $quantity = htmlspecialchars(trim($_POST['quantity']));
  $meta_title = htmlspecialchars(trim($_POST['meta_title']));
  $meta_description = htmlspecialchars(trim($_POST['meta_description']));
  $meta_keywords = htmlspecialchars(trim($_POST['meta_keywords']));
  $status = isset($_POST['status']) ? 1 : 0;
  $trending = isset($_POST['trending']) ? 1 : 0;

  $upload_dir = "../uploads";
  $fileName = null;

  // Image Upload Handling
  if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
    $image = $_FILES['image']['name'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_extension = strtolower(pathinfo($image, PATHINFO_EXTENSION));
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'webp'];

    if (!in_array($image_extension, $allowed_extensions)) {
      redirect("addProduct.php", "Invalid image format! Use JPG, JPEG, PNG, or WEBP.");
      exit();
    }

    if (!is_dir($upload_dir)) {
      mkdir($upload_dir, 0755, true);
    }

    $fileName = time() . '_' . bin2hex(random_bytes(5)) . '.' . $image_extension;
    $destination = $upload_dir . '/' . $fileName;

    if (!move_uploaded_file($image_tmp_name, $destination)) {
      redirect("addProduct.php", "Failed to upload image! Check folder permissions.");
      exit();
    }
  }

  // Validation Checks
  if (empty($name) || empty($slug) || empty($description)) {
    redirect("addProduct.php", "Name, Slug, and Description are required!");
    exit();
  }

  try {
    if (isset($_POST['edit_product_btn']) && isset($_POST['product_id'])) {
      $product_id = intval($_POST['product_id']);

      $stmt = $pdo->prepare("SELECT image FROM products WHERE id = ?");
      $stmt->execute([$product_id]);
      $existingProduct = $stmt->fetch(PDO::FETCH_ASSOC);
      $currentImage = $existingProduct['image'];

      $update_query = "UPDATE products SET category_id=?, name=?, slug=?, small_description=?, description=?, original_price=?, selling_price=?, quantity=?, meta_title=?, meta_description=?, meta_keywords=?, status=?, trending=?";
      $params = [$category_id, $name, $slug, $small_description, $description, $original_price, $selling_price, $quantity, $meta_title, $meta_description, $meta_keywords, $status, $trending];

      if ($fileName) {
        $update_query .= ", image=?";
        $params[] = $fileName;

        if (!empty($currentImage) && file_exists("../uploads/" . $currentImage)) {
          unlink("../uploads/" . $currentImage);
        }
      }

      $update_query .= " WHERE id=?";
      $params[] = $product_id;

      $stmt = $pdo->prepare($update_query);
      $result = $stmt->execute($params);

      redirect("editProduct.php?id=$product_id", $result ? "Product updated successfully!" : "Failed to update product!");
    } else {
      $check_stmt = $pdo->prepare("SELECT COUNT(*) FROM products WHERE slug = ?");
      $check_stmt->execute([$slug]);
      if ($check_stmt->fetchColumn() > 0) {
        redirect("addProduct.php", "Product with this slug already exists!");
        exit();
      }

      $stmt = $pdo->prepare("INSERT INTO products (category_id, name, slug, small_description, description, image, original_price, selling_price, quantity, meta_title, meta_description, meta_keywords, status, trending) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
      $result = $stmt->execute([$category_id, $name, $slug, $small_description, $description, $fileName, $original_price, $selling_price, $quantity, $meta_title, $meta_description, $meta_keywords, $status, $trending]);

      redirect("addProduct.php", $result ? "Product added successfully!" : "Failed to add product!");
    }
  } catch (PDOException $e) {
    redirect("addProduct.php", "Database error: " . $e->getMessage());
  }
}

// DELETE Product PROCESS
if (isset($_POST['delete_product_btn']) && isset($_POST['product_id'])) {
  $product_id = intval($_POST['product_id']);

  try {
    $stmt = $pdo->prepare("SELECT image FROM products WHERE id = ?");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
      $imagePath = "../uploads/" . $product['image'];

      $deleteStmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
      $result = $deleteStmt->execute([$product_id]);

      if ($result) {
        if (!empty($product['image']) && file_exists($imagePath)) {
          unlink($imagePath);
        }
        redirect("product.php", "Product deleted successfully!");
      } else {
        redirect("product.php", "Failed to delete product!");
      }
    } else {
      redirect("product.php", "Product not found!");
    }
  } catch (PDOException $e) {
    redirect("product.php", "Database error: " . $e->getMessage());
  }
} else {
  redirect("product.php", "Invalid request!");
}

