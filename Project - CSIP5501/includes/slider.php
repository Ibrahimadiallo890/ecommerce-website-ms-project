<style>
  /* Add a dark overlay for better text readability */
  .carousel-item::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5); /* Dark overlay */
      z-index: 1;
  }
  .carousel-caption {
      z-index: 2;
  }

  /* Style the caption text */
  .carousel-caption h5 {
      font-size: 2rem;
      font-weight: bold;
      color: #ffcc00; /* Bright color */
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
  }
  .carousel-caption p {
      font-size: 1.2rem;
      color: #ffffff;
      background: rgba(0, 0, 0, 0.6);
      padding: 10px;
      border-radius: 5px;
      display: inline-block;
  }

  /* Style the carousel navigation buttons */
  .carousel-control-prev-icon,
  .carousel-control-next-icon {
      background-color: rgba(255, 204, 0, 0.7); /* Yellow semi-transparent */
      padding: 15px;
      border-radius: 50%;
  }
  .carousel-control-prev-icon:hover,
  .carousel-control-next-icon:hover {
      background-color: rgba(255, 204, 0, 1); /* Bright yellow */
  }

  /* Custom carousel indicators */
  .carousel-indicators button {
      background-color: white;
      width: 12px;
      height: 12px;
      border-radius: 50%;
      opacity: 0.5;
  }
  .carousel-indicators .active {
      background-color: #ffcc00;
      opacity: 1;
  }

  /* Smooth slide transition */
  .carousel-item {
      transition: transform 1s ease-in-out, opacity 1s ease-in-out;
  }
</style>

<div id="carouselExampleCaptions" class="carousel slide">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="assets/images/slider-1.png" class="d-block w-100" alt="iPhone 14">
      <div class="carousel-caption d-none d-md-block">
        <h5>iPhone 14</h5>
        <p>Experience the future with the iPhone 14's cutting-edge technology.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="assets/images/slider-2.png" class="d-block w-100" alt="iPhone 15">
      <div class="carousel-caption d-none d-md-block">
        <h5>iPhone 15</h5>
        <p>Discover the power of innovation with the iPhone 15.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="assets/images/slider-3.png" class="d-block w-100" alt="iPhone 16">
      <div class="carousel-caption d-none d-md-block">
        <h5>iPhone 16</h5>
        <p>Unmatched performance and design in the all-new iPhone 16.</p>
      </div>
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>
