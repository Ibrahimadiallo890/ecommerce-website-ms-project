<?php
session_start();
include("includes/header.php");
include("functions/userfunctions.php");
?>

<div class="py-3 bg-primary">
  <div class="container">
    <h6 class="text-white">
      <a class="text-white" href="index.php">
        Home /
      </a>
      Collections
    </h6>
  </div>
</div>

<div class="py-5">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h1>Our Collections</h1>
        <hr>
        <div class="row">
          <?php
          $categories = getALLActive("categories");
          if ($categories):
            foreach ($categories as $category):
          ?>
              <div class="col-md-3 mb-2">
                <a href="products.php?category=<?= htmlspecialchars($category["slug"]); ?>">
                  <div class="card shadow">
                    <div class="card-body">
                      <img src="uploads/<?= htmlspecialchars($category["image"]); ?>" alt="Category Image" class="w-100 mb-2">
                      <h4 class="text-center"><?= htmlspecialchars($category["name"]); ?></h4>
                    </div>
                  </div>
                </a>
              </div>
            <?php
            endforeach;
          else:
            ?>
            <p>No categories found.</p>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include("includes/footer.php"); ?>