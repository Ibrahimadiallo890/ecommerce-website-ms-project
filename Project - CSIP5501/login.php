<?php
include("includes/header.php");
session_start();
if (isset($_SESSION['auth'])) {
  $_SESSION['message'] = "You are already logged In";
  header('location: index.php');
  exit();
}
?>
<div class="py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">

        <?php if (isset($_SESSION['message'])) { ?>
          <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Hey!</strong> <?= $_SESSION['message']; ?>.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php
          unset($_SESSION['message']);
        }
        ?>

        <div class="card">
          <div class="card-header">
            <h4>Login Form</h4>
          </div>
          <div class="card-body">
            <form action="./functions/authcode.php" method="POST">
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" placeholder="Enter your email" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Enter password" required>
              </div>
              <!-- Hidden field for role_as (1 for Admin) -->
              <input type="hidden" name="role_as" value="1">
              <button type="submit" name="login_btn" class="btn btn-primary">Login</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include("includes/footer.php") ?>