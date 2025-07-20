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
      <a class="text-white" href="index.php">Home</a> /
      <a class="text-white" href="cart.php">Cart</a> /
      <a class="text-white" href="#">Checkout</a>
    </h6>
  </div>
</div>

<div class="py-5">
  <div class="container">
    <div class="card shadow">
      <div class="card-body">
        <div class="row">

          <div class="col-md-7">
            <h5 class="mb-3 fw-bold">Billing Details</h5>
            <div class="card shadow-sm border-0 rounded-3">
              <div class="card-body">
                <form action="functions/place_order.php" method="POST">
                  <div class="row">
                    <div class="col-md-6 mb-3">
                      <label class="fw-bold">Full Name</label>
                      <input type="text" name="name" id="name" class="form-control rounded" placeholder="John Doe" required>
                      <small class="text-danger name"></small>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label class="fw-bold">Email Address</label>
                      <input type="email" name="email" id="email" class="form-control rounded" placeholder="john@example.com" required>
                      <small class="text-danger email"></small>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label class="fw-bold">Phone Number</label>
                      <input type="tel" name="phone_number" id="phone_number" class="form-control rounded" placeholder="+44 7123 456789" required>
                      <small class="text-danger phone_number"></small>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label class="fw-bold">Postal Code</label>
                      <input type="text" name="postal_code" id="postal_code" class="form-control rounded" placeholder="LE1 1AB" required>
                      <small class="text-danger postal_code"></small>
                    </div>
                    <div class="col-md-12 mb-3">
                      <label class="fw-bold">Address</label>
                      <textarea name="address" id="address" class="form-control rounded" rows="3" placeholder="123 Main Street, Leicester" required></textarea>
                      <small class="text-danger address"></small>
                    </div>
                  </div>
              </div>
            </div>
          </div>

          <div class="col-md-5">
            <h5 class="mb-3 fw-bold">Order Summary</h5>
            <div class="card shadow-sm border-0 rounded-3">
              <div class="card-body">
                <?php if (!empty($carts)): ?>
                  <div class="table-responsive">
                    <table class="table align-middle">
                      <thead class="bg-light text-center">
                        <tr>
                          <th>Image</th>
                          <th>Product Name</th>
                          <th>Qty</th>
                          <th>Subtotal</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $total = 0; ?>
                        <?php foreach ($carts as $cart): ?>
                          <tr>
                            <td class="text-center">
                              <img src="uploads/<?= htmlspecialchars($cart["image"]); ?>" alt="Product Image" class="img-fluid rounded" style="width: 60px; height: 60px;">
                            </td>
                            <td class="text-center"><?= htmlspecialchars($cart["name"]); ?></td>
                            <td class="text-center"><?= htmlspecialchars($cart["product_quantity"]); ?></td>
                            <td class="text-end">£<?= number_format($cart["selling_price"] * $cart["product_quantity"], 2); ?></td>
                          </tr>
                          <?php $total += $cart["selling_price"] * $cart["product_quantity"]; ?>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                  <hr>
                  <h5 class="text-end fw-bold">Total: £<?= number_format($total, 2); ?></h5>
                  <input type="hidden" name="payment_mode" value="COD">
                  <button type="submit" name="placeOrderBtn" class="btn btn-primary btn-lg w-100 mt-3">Place Order</button>
                  <div id="paypal-button-container" class="mt-3"></div>
                <?php else: ?>
                  <p class="text-center text-muted">Your cart is empty.</p>
                <?php endif; ?>
              </div>
            </div>
          </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include("includes/footer.php"); ?>

<?php if (!empty($carts)): ?>
  <script src="https://www.paypal.com/sdk/js?client-id=ARVQdJePqbP0De-VV2cgXuwV1lEmb3DpDeWy3ffJkllaDyUmj1r2mux2-pJKJpUDtyAJaWB3CHD8ZYAp&currency=GBP"></script>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const getFieldValue = (selector) => document.querySelector(selector)?.value.trim();
      const showError = (selector, message) => {
        const el = document.querySelector(selector);
        if (el) el.textContent = message;
      };
      const clearErrors = () => {
        ['.name', '.email', '.phone_number', '.postal_code', '.address'].forEach(cls => {
          const el = document.querySelector(cls);
          if (el) el.textContent = '';
        });
      };

      paypal.Buttons({
        createOrder: function(data, actions) {
          clearErrors();

          const name = getFieldValue('input[name="name"]');
          const email = getFieldValue('input[name="email"]');
          const phone = getFieldValue('input[name="phone_number"]');
          const postal = getFieldValue('input[name="postal_code"]');
          const address = getFieldValue('textarea[name="address"]');

          let valid = true;

          if (!name) {
            showError('.name', 'Full name is required.');
            valid = false;
          }
          if (!email) {
            showError('.email', 'Email address is required.');
            valid = false;
          }
          if (!phone) {
            showError('.phone_number', 'Phone number is required.');
            valid = false;
          }
          if (!postal) {
            showError('.postal_code', 'Postal code is required.');
            valid = false;
          }
          if (!address) {
            showError('.address', 'Address is required.');
            valid = false;
          }

          if (!valid) {
            return actions.reject(); // Prevent PayPal popup
          }

          // All inputs valid, create PayPal order
          return actions.order.create({
            purchase_units: [{
              amount: {
                value: '<?= number_format($total, 2, ".", ""); ?>'
              }
            }]
          });
        },

        onApprove: function(data, actions) {
          return actions.order.capture().then(function(details) {
            // Gather user input again
            const payload = {
              payment_mode: "Paid by PayPal",
              payment_id: details.id,
              name: getFieldValue('input[name="name"]'),
              email: getFieldValue('input[name="email"]'),
              phone_number: getFieldValue('input[name="phone_number"]'),
              postal_code: getFieldValue('input[name="postal_code"]'),
              address: getFieldValue('textarea[name="address"]')
            };

            // Send order to server
            fetch('functions/place_order.php', {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/json'
                },
                body: JSON.stringify(payload)
              })
              .then(res => res.json())
              .then(response => {
                alert("Payment successful! Redirecting...");
                window.location.href = "my_orders.php";
              })
              .catch(err => {
                console.error("Order submission failed:", err);
                alert("There was an error placing your order. Please contact support.");
              });
          });
        },

        onError: function(err) {
          console.error("PayPal error:", err);
          alert("An error occurred with PayPal. Please try again later.");
        }
      }).render('#paypal-button-container');
    });
  </script>
<?php endif; ?>
