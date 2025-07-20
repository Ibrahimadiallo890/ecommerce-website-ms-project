$(document).ready(function () {
  alertify.set("notifier", "position", "top-right"); // Set alert position

  // Increment and Decrement Process for Cart Page
  $(".updateQuantity").click(function (e) {
    e.preventDefault();

    var $row = $(this).closest("tr"); // Get the cart row
    var $qtyInput = $row.find(".product-quantity");
    var product_id = $row.find(".productId").val(); // Product ID from hidden input
    var currentQty = parseInt($qtyInput.val());
    var action = $(this).data("action");

    if (isNaN(currentQty) || currentQty < 1) {
      alertify.error("Invalid quantity");
      return;
    }

    if (action === "increment" && currentQty < 10) {
      $qtyInput.val(currentQty + 1);
    } else if (action === "decrement" && currentQty > 1) {
      $qtyInput.val(currentQty - 1);
    }

    // Send AJAX request to update cart
    $.ajax({
      method: "POST",
      url: "functions/handleCart.php",
      data: {
        product_id: product_id,
        product_quantity: $qtyInput.val(),
        scope: "update",
      },
      dataType: "json",
      success: function (response) {
        if (response.status === 200) {
          alertify.success(response.message || "Cart updated successfully");
        } else {
          alertify.error(response.message || "Error updating cart");
        }
      },
      error: function () {
        alertify.error("Error processing request. Please try again.");
      },
    });
  });

  // Remove item from cart
  $(".deleteCartItem").click(function (e) {
    e.preventDefault();

    var $row = $(this).closest("tr");
    var product_id = $row.find(".productId").val();

    $.ajax({
      method: "POST",
      url: "functions/handleCart.php",
      data: { product_id: product_id, scope: "delete" },
      dataType: "json",
      success: function (response) {
        if (response.status === 200) {
          alertify.success(response.message || "Product removed from cart");
          $row.fadeOut(500, function () {
            $(this).remove(); // Remove row from table
          });
        } else {
          alertify.error(response.message || "Error removing product");
        }
      },
      error: function (xhr) {
        console.error("AJAX Error:", xhr.responseText);
        alertify.error("Error processing request. Please try again.");
      },
    });
  });

  // Increment and Decrement Process for Product View
  $(".increment-btn").click(function (e) {
    e.preventDefault();

    var $qtyInput = $(this).closest(".input-group").find(".product-quantity");
    var currentQty = parseInt($qtyInput.val());

    if (!isNaN(currentQty) && currentQty < 10) {
      $qtyInput.val(currentQty + 1);
    }
  });

  $(".decrement-btn").click(function (e) {
    e.preventDefault();

    var $qtyInput = $(this).closest(".input-group").find(".product-quantity");
    var currentQty = parseInt($qtyInput.val());

    if (!isNaN(currentQty) && currentQty > 1) {
      $qtyInput.val(currentQty - 1);
    }
  });

  // Add to Cart Process
  $(".addToCartBtn").click(function (e) {
    e.preventDefault();

    var $productData = $(this).closest(".product-data");
    var quantity = $productData.find(".product-quantity").val();
    var product_id = $(this).val();

    if (isNaN(quantity) || quantity < 1) {
      alertify.error("Invalid quantity");
      return;
    }

    $.ajax({
      method: "POST",
      url: "functions/handleCart.php",
      data: {
        product_id: product_id,
        product_quantity: quantity,
        scope: "add",
      },
      dataType: "json",
      success: function (response) {
        if (response.status === 201) {
          alertify.success(response.message || "Product added to cart");
        } else if (response.status === "existing") {
          alertify.error(response.message || "Product already in cart");
        } else {
          alertify.error(response.message || "Error adding product");
        }
      },
      error: function (xhr) {
        console.error("AJAX Error:", xhr.responseText);
        alertify.error("Error processing request. Please try again.");
      },
    });
  });
});
