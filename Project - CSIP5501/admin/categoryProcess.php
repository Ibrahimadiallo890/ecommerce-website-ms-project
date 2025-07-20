<?php
session_start();
include("../server/database.php");
include("../functions/myfunctions.php");

if (isset($_POST['add_category_btn']) || isset($_POST['edit_category_btn'])) {
  $name = htmlspecialchars(trim($_POST['name']));
  $slug = htmlspecialchars(trim($_POST['slug']));
  $description = htmlspecialchars(trim($_POST['description']));
  $meta_title = htmlspecialchars(trim($_POST['meta_title']));
  $meta_description = htmlspecialchars(trim($_POST['meta_description']));
  $meta_keywords = htmlspecialchars(trim($_POST['meta_keywords']));
  $status = isset($_POST['status']) ? 1 : 0;
  $popular = isset($_POST['popular']) ? 1 : 0;

  $upload_dir = "../uploads";
  $fileName = null;

  // Image Upload Handling
  if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
    $image = $_FILES['image']['name'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_extension = strtolower(pathinfo($image, PATHINFO_EXTENSION));
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'webp'];

    if (!in_array($image_extension, $allowed_extensions)) {
      redirect("addCategory.php", "Invalid image format! Use JPG, JPEG, PNG, or WEBP.");
      exit();
    }

    if (!is_dir($upload_dir)) {
      mkdir($upload_dir, 0755, true);
    }

    $fileName = time() . '.' . $image_extension;
    $destination = $upload_dir . '/' . $fileName;

    if (!move_uploaded_file($image_tmp_name, $destination)) {
      redirect("addCategory.php", "Failed to upload image! Check folder permissions.");
      exit();
    }
  }

  // Validation Checks
  if (empty($name) || empty($slug) || empty($description)) {
    redirect("addCategory.php", "Name, Slug, and Description are required!");
    exit();
  }

  try {
    if (isset($_POST['edit_category_btn']) && isset($_POST['category_id'])) {
      // Update existing category
      $category_id = intval($_POST['category_id']);

      // Fetch the current image if no new image is uploaded
      $stmt = $pdo->prepare("SELECT image FROM categories WHERE id = ?");
      $stmt->execute([$category_id]);
      $existingCategory = $stmt->fetch(PDO::FETCH_ASSOC);
      $currentImage = $existingCategory['image'];

      $update_query = "UPDATE categories SET name=?, slug=?, description=?, meta_title=?, meta_description=?, meta_keywords=?, status=?, popular=?";
      $params = [$name, $slug, $description, $meta_title, $meta_description, $meta_keywords, $status, $popular];

      // Only update image if a new one is uploaded
      if ($fileName) {
        $update_query .= ", image=?";
        $params[] = $fileName;

        // Delete the old image if a new one is uploaded
        if (!empty($currentImage) && file_exists("../uploads/" . $currentImage)) {
          unlink("../uploads/" . $currentImage);
        }
      }

      $update_query .= " WHERE id=?";
      $params[] = $category_id;

      $stmt = $pdo->prepare($update_query);
      $result = $stmt->execute($params);

      if ($result) {
        redirect("editCategory.php?id=$category_id", "Category updated successfully!");
      } else {
        redirect("editCategory.php?id=$category_id", "Failed to update category!");
      }
    } else {
      // Insert new category
      $check_stmt = $pdo->prepare("SELECT COUNT(*) FROM categories WHERE slug = ?");
      $check_stmt->execute([$slug]);
      if ($check_stmt->fetchColumn() > 0) {
        redirect("addCategory.php", "Category with this slug already exists!");
        exit();
      }

      $stmt = $pdo->prepare("INSERT INTO categories (name, slug, description, image, meta_title, meta_description, meta_keywords, status, popular) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
      $result = $stmt->execute([$name, $slug, $description, $fileName, $meta_title, $meta_description, $meta_keywords, $status, $popular]);

      if ($result) {
        redirect("addCategory.php", "Category added successfully!");
      } else {
        redirect("addCategory.php", "Failed to add category!");
      }
    }
  } catch (PDOException $e) {
    redirect("addCategory.php", "Database error: " . $e->getMessage());
  }
}

// DELETE CATEGORY PROCESS
if (isset($_POST['delete_category_btn']) && isset($_POST['category_id'])) {
  $category_id = intval($_POST['category_id']);

  try {
    $stmt = $pdo->prepare("SELECT image FROM categories WHERE id = ?");
    $stmt->execute([$category_id]);
    $category = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($category) {
      $imagePath = "../uploads/" . $category['image'];

      $deleteStmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
      $result = $deleteStmt->execute([$category_id]);

      if ($result) {
        if (!empty($category['image']) && file_exists($imagePath)) {
          unlink($imagePath);
        }
        redirect("category.php", "Category deleted successfully!");
      } else {
        redirect("category.php", "Failed to delete category!");
      }
    } else {
      redirect("category.php", "Category not found!");
    }
  } catch (PDOException $e) {
    redirect("category.php", "Database error: " . $e->getMessage());
  }
} else {
  redirect("category.php", "Invalid request!");
}