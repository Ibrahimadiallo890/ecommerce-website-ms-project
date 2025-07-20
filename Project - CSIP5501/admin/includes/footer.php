<footer class="footer pt-10">
  <div class="container-fluid pt-10">
    <div class="row align-items-center justify-content-lg-between pt-8">
      <div class="col-lg-12 pt-8">
        <ul class="nav nav-footer justify-content-center justify-content-lg-end">
          <li class="nav-item">
            <a href="" class="nav-link pe-0 text-muted" target="_blank">About Us</a>
          </li>
          <li class="nav-item">
            <a href="" class="nav-link pe-0 text-muted" target="_blank">Features</a>
          </li>
          <li class="nav-item">
            <a href="" class="nav-link pe-0 text-muted" target="_blank">Services</a>
          </li>
          <li class="nav-item">
            <a href="" class="nav-link pe-0 text-muted" target="_blank">Contact Us</a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</footer>

<!-- Core JS Files -->
 <script src="assets/js/jquery-3.7.1.min.js"></script>
 <script src="assets/js/custom.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/perfect-scrollbar.min.js"></script>
<script src="assets/js/material-dashboard.min.js?v=3.0.0"></script>

<!-- sweet alert -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<!-- Alertify js -->
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/alertify.min.js"></script>
</body>
<script>
  <?php if (isset($_SESSION['message'])) { ?>
    alertify.set('notifier', 'position', 'top-right');
    alertify.success('<?= $_SESSION['message'] ?>');
  <?php
    unset($_SESSION['message']);
  } ?>
</script>
</html>