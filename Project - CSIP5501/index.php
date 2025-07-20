<?php
session_start();
if (!isset($_SESSION['auth'])) {
  $_SESSION['message'] = "You have to login first";
  header('Location: login.php');
  exit();
}
include("includes/header.php");
include("includes/slider.php");
include("functions/userfunctions.php");

$trending = getAllTrending();
?>

<!-- Include jQuery & Owl Carousel -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

<div class="py-5">
  <div class="container">
    <h4 class="mb-4 text-uppercase fw-bold" style="color: #ffcc00;">Trending Products</h4>
    <div class="underline mb-2"></div>
    <div class="row">
      <div class="owl-carousel owl-theme">
        <?php if ($trending): ?>
          <?php foreach ($trending as $trendingProduct): ?>
            <div class="item">
              <div class="card product-card border-0 shadow-sm">
                <div class="position-relative">
                  <img src="uploads/<?= htmlspecialchars($trendingProduct["image"]); ?>" alt="Product Image" class="w-100 rounded-top">
                  <span class="badge bg-danger position-absolute top-0 start-0 m-2">Trending</span>
                </div>
                <div class="card-body text-center">
                  <h5 class="fw-bold"> <?= htmlspecialchars($trendingProduct["name"]); ?> </h5>
                  <p class="text-muted mb-2">Price: <span class="text-success fw-bold">$<?= htmlspecialchars($trendingProduct["selling_price"]); ?></span></p>
                  <a href="viewProduct.php?product=<?= htmlspecialchars($trendingProduct["slug"]); ?>" class="btn btn-outline-primary w-100">
                    <i class="bi bi-eye"></i> View Details
                  </a>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="col-12 text-center">
            <p class="text-muted">No trending products available.</p>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<div class="py-5 bg-f2f2f2">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h4 class="text-center mb-4">About Us</h4>
        <div class="underline mb-4 mx-auto" style="width: 100px; height: 3px; background-color: #ffcc00;"></div>
        <p class="text-muted text-center" style="font-size: 1.2rem;">
          <strong>224-UNLIMITED-TRADE</strong> is an e-commerce platform based in the heart of Madina, Conakry, Guinea. Specializing in import-export, the company offers a wide range of food products and essentials through an online store, ensuring convenient access to quality goods for customers across the capital. With a strong role in the local food supply chain, 224-UNLIMITED-TRADE brings the best of global markets directly to your doorstep.
        </p>
        <div class="col-md-12">
          <h4 class="text-center mb-4">Our Mission</h4>
          <div class="underline mb-4 mx-auto" style="width: 100px; height: 3px; background-color: #ffcc00;"></div>
          <p class="text-muted text-center" style="font-size: 1.2rem;">
            Our mission is to provide a seamless online shopping experience, offering a diverse selection of high-quality products at competitive prices. We aim to enhance the lives of our customers by delivering convenience, reliability, and exceptional service.
          </p>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="py-5 bg-dark text-white">
  <div class="container">
    <div class="row">
      <div class="col-md-3">
        <h4 class="text-white">224-UNLIMITED-TRADE</h4>
        <div class="underline mb-2"></div>
        <a href="index.php" class="text-white"><i class="fa fa-angle-right"></i> Home</a> <br>
        <a href="collections.php" class="text-white"><i class="fa fa-angle-right"></i> Collections</a> <br>
        <a href="cart.php" class="text-white"><i class="fa fa-angle-right"></i> Cart</a> <br>
        <a href="my_orders.php" class="text-white"><i class="fa fa-angle-right"></i> Orders</a> <br>
      </div>
      <div class="col-md-3">
        <h4 class="text-white">Address</h4>
        <div class="underline mb-2"></div>
        <p class="text-white">224-UNLIMITED-TRADE<br>
          Niger Road, In Front of the Mosque<br>
          Madina, Conakry<br>
          Guinea
        </p>
        <a href="tel:+224620202020" class="text-white"><i class="fa fa-phone"></i> +224 620-20-20-20</a> <br>
        <a href="mailto:unlimitedtrade@gmail.com" class="text-white"><i class="fa fa-envelope"></i> unlimitedtrade@gmail.com</a>
      </div>
      <div class="col-md-6">
        <h4 class="text-white">Find Us</h4>
        <div class="underline mb-2"></div>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3466.726590133284!2d-13.497252725630172!3d9.70560347803254!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xf02d50cd4a788ed%3A0x1c169d479aa286db!2sMadina%20route%20Niger!5e1!3m2!1sen!2suk!4v1742906937530!5m2!1sen!2suk" class="w-100" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div>
      <div class="col-md-6">
        <h4 class="text-white">Follow Us</h4>
        <div class="underline mb-2"></div>
        <a href="https://www.facebook.com/224UnlimitedTrade" target="_blank" class="text-white me-3"><i class="fa fa-facebook"></i> Facebook</a>
        <a href="https://www.instagram.com/224UnlimitedTrade" target="_blank" class="text-white me-3"><i class="fa fa-instagram"></i> Instagram</a>
        <a href="https://www.twitter.com/224UnlimitedTrade" target="_blank" class="text-white"><i class="fa fa-twitter"></i> Twitter</a>
      </div>
      <div class="col-md-6">
        <h4 class="text-white">Subscribe to Our Newsletter</h4>
        <div class="underline mb-2"></div>
        <form action="subscribe.php" method="POST">
          <input type="email" name="email" class="form-control mb-2" placeholder="Enter your email" required>
          <button type="submit" class="btn btn-primary w-100">Subscribe</button>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="py-3 bg-danger">
  <div class="container text-center">
    <p class="mb-0 text-white">All rights reserved. Copyright @ Ibrahima Diallo - <?= date('Y'); ?></p>
  </div>
</div>


<!-- Styling -->
<style>
  .product-card {
    transition: transform 0.2s ease-in-out;
    border-radius: 15px;
  }

  .product-card:hover {
    transform: scale(1.05);
  }

  .owl-nav button {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(0, 0, 0, 0.5);
    color: white;
    border-radius: 50%;
    padding: 10px;
  }

  .owl-nav .owl-prev {
    left: -30px;
  }

  .owl-nav .owl-next {
    right: -30px;
  }
</style>

<!-- Owl Carousel Script -->
<script>
  $(document).ready(function() {
    $(".owl-carousel").owlCarousel({
      loop: true,
      margin: 10,
      nav: true,
      dots: true,
      autoplay: true,
      autoplayTimeout: 3000,
      autoplayHoverPause: true,
      responsive: {
        0: {
          items: 1
        },
        600: {
          items: 2
        },
        1000: {
          items: 4
        }
      }
    });
  });
</script>

<?php include("includes/footer.php"); ?>
