<?php
session_start();
if (!isset($_SESSION['auth'])) {
  $_SESSION['message'] = "You have to login first";
  header('Location: login.php');
  exit();
}

include("includes/header.php");
include("functions/userfunctions.php");

$carts = getCartItems();
?>

<div class="py-3 bg-primary">
  <div class="container">
    <h6 class="text-white">
      <a class="text-white" href="index.php" class="text-white">Home /</a>
      <a class="text-white" href="cart.php">Cart /</a>
    </h6>
  </div>
</div>

<div class="py-5">
  <div class="container product-data">
    <div class="row">
      <div class="col-md-12">
        <h1 class="mb-4">Your Cart</h1>
        <hr>

        <?php if (!empty($carts)): ?>
          <div class="card shadow ">
            <div class="card-body">
              <table class="table table-bordered text-center align-middle">
                <thead class="table-dark">
                  <tr>
                    <th width="15%">Image</th>
                    <th width="30%">Product Name</th>
                    <th width="15%">Quantity</th>
                    <th width="15%">Price</th>
                    <th width="10%">Remove</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($carts as $cart): ?>
                    <tr>
                      <td>
                        <img src="uploads/<?= htmlspecialchars($cart["image"]); ?>" alt="Product Image" class="img-fluid rounded" style="width: 80px; height: 80px;">
                      </td>
                      <td><?= htmlspecialchars($cart["name"]); ?></td>
                      <td>
                        <input type="hidden" class="productId" value="<?= htmlspecialchars($cart["product_id"]); ?>">
                        <div class="input-group mx-auto" style="width: 130px;">
                          <button class="input-group-text updateQuantity" data-action="decrement">-</button>
                          <input type="text" class="form-control text-center bg-white product-quantity" disabled value="<?= htmlspecialchars($cart["product_quantity"]); ?>">
                          <button class="input-group-text updateQuantity" data-action="increment">+</button>
                        </div>
                      </td>
                      <td>£<?= number_format($cart["selling_price"], 2); ?></td>
                      <td>
                        <input type="hidden" class="productId" value="<?= htmlspecialchars($cart["product_id"]); ?>">
                        <button class="btn btn-danger btn-sm deleteCartItem">
                          <i class="fa fa-trash"></i> Remove
                        </button>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="float-end mt-3">
            <a href="checkout.php" class="btn btn-outline-primary">Proceed to Checkout</a>
          </div>
        <?php else: ?>
          <p class="text-center">Your cart is empty.</p>
        <?php endif; ?>

      </div>
    </div>
  </div>
</div>

<?php include("includes/footer.php"); ?>