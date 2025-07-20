<?php
session_start();
include('includes/header.php');
include('includes/sidebar.php');
include('../middleware/adminMiddleware.php');
?>

<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
  <?php include('includes/navbar.php'); ?>
  <div class="container-fluid py-0">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h4>Add Category</h4>
            </div>
            <div class="card-body">
              <form action="categoryProcess.php" method="POST" enctype="multipart/form-data">
                <div class="row">
                  <div class="col-md-6">
                    <label for="">Name</label>
                    <input type="text" class="form-control" name="name" id="" placeholder="Enter Category Name" required>
                  </div>

                  <div class="col-md-6">
                    <label for="">Slug</label>
                    <input type="text" class="form-control" name="slug" id="" placeholder="Enter slug" required>
                  </div>

                  <div class="col-md-12">
                    <label for="">Description</label>
                    <textarea name="description" rows="3" class="form-control" id="" placeholder="Enter description" required></textarea>
                  </div>

                  <div class="col-md-12">
                    <label for="">Upload Image</label>
                    <input type="file" name="image" class="form-control">
                  </div>

                  <div class="col-md-12">
                    <label for="">Meta Tittle</label>
                    <input type="text" class="form-control" name="meta_title" id="" placeholder="Enter meta tittle">
                  </div>

                  <div class="col-md-12">
                    <label for="">Meta Description</label>
                    <textarea name="meta_description" rows="3" class="form-control" id="" placeholder="Enter meta description"></textarea>
                  </div>

                  <div class="col-md-12">
                    <label for="">Meta Keywords</label>
                    <textarea name="meta_keywords" rows="3" class="form-control" id="" placeholder="Enter meta keywords"></textarea>
                  </div>

                  <div class="col-md-6">
                    <label for="">Status</label>
                    <input type="checkbox" name="status">
                  </div>

                  <div class="col-md-6">
                    <label for="">Popular</label>
                    <input type="checkbox" name="popular">
                  </div>

                  <div class="col-md-12">
                    <button type="submit" class="btn btn-primary" name="add_category_btn">Save</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<?php include('includes/footer.php'); ?>