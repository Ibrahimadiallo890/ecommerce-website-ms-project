$(document).ready(function () {
  // Product Delete Process
  $(".delete_product_btn").click(function (e) {
    e.preventDefault();

    var id = $(this).data("id"); // Fetch product ID from data-id attribute
    //alert(id);

    swal({
      title: "Are you sure?",
      text: "Once deleted, you will not be able to recover this product data!",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    }).then((willDelete) => {
      if (willDelete) {
        $.ajax({
          method: "POST",
          url: "productProcess.php",
          data: {
            product_id: id,
            delete_product_btn: true,
          },
          success: function (response) {
            swal("Success!", response, "success").then(() => {
              location.reload();
            });
          },
          error: function () {
            swal("Error!", "Something went wrong!", "error");
          },
        });
      } else {
        swal("Your product is safe!");
      }
    });
  });

  // Category Delete Process
  $(".delete_category_btn").click(function (e) {
    e.preventDefault();

    var id = $(this).data("id"); // Fetch product ID from data-id attribute
    //alert(id);

    swal({
      title: "Are you sure?",
      text: "Once deleted, you will not be able to recover this category data!",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    }).then((willDelete) => {
      if (willDelete) {
        $.ajax({
          method: "POST",
          url: "categoryProcess.php",
          data: {
            category_id: id,
            delete_category_btn: true,
          },
          success: function (response) {
            swal("Success!", response, "success").then(() => {
              location.reload();
            });
          },
          error: function () {
            swal("Error!", "Something went wrong!", "error");
          },
        });
      } else {
        swal("Your category is safe!");
      }
    });
  });
});

