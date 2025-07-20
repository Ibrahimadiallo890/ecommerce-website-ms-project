<?php
session_start();
include("../server/database.php");
include("myfunctions.php");

if (isset($_POST['register_btn'])) {
  $name = htmlspecialchars(trim($_POST['name']));
  $phone = htmlspecialchars(trim($_POST['phone']));
  $email = htmlspecialchars(trim($_POST['email']));
  $password = trim($_POST['password']);
  $confirmPassword = trim($_POST['confirmPassword']);

  // Validation checks
  if (empty($name) || empty($phone) || empty($email) || empty($password) || empty($confirmPassword)) {
    redirect("../register.php", "All fields are required!");
    exit();
  }

  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    redirect("../register.php", "Invalid email format!");
    exit();
  }

  if ($password !== $confirmPassword) {
    redirect("../register.php", "Passwords do not match!");
    exit();
  }

  // Hash the password before storing it
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

  try {
    // Check if the email already exists
    $check_stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
    $check_stmt->execute([$email]);

    if ($check_stmt->fetchColumn() > 0) {
      redirect("../register.php", "Email already exists. Please use a different one.");
      exit();
    }

    // Insert new user into the database
    $stmt = $pdo->prepare("INSERT INTO users (name, phone, email, password) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$name, $phone, $email, $hashedPassword])) {
      // Retrieve the last inserted user_id
      $user_id = $pdo->lastInsertId();

      if ($user_id) {
        $_SESSION['auth'] = true;
        $_SESSION['auth_user'] = [
          'user_id' => $user_id,
          'name' => $name,
          'email' => $email
        ];

        // Set default role_as (modify if needed)
        $_SESSION['role_as'] = 0;

        redirect("../login.php", "Registered successfully. You can now log in.");
        exit();
      } else {
        redirect("../register.php", "User registration failed. Try again.");
        exit();
      }
    } else {
      redirect("../register.php", "Something went wrong while registering!");
      exit();
    }
  } catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage()); // Log error
    redirect("../register.php", "Database error. Please try again later.");
    exit();
  }
}

if (isset($_POST['login_btn'])) {
  $email = htmlspecialchars(trim($_POST['email']));
  $password = trim($_POST['password']);

  if (empty($email) || empty($password)) {
    redirect("../login.php", "Email and Password are required!");
    exit();
  }

  try {
    // Fetch user from the database based on email
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verify password and login
    if ($user && password_verify($password, $user['password'])) {
      $_SESSION['auth'] = true;
      $_SESSION['auth_user'] = [
        'user_id' => $user['user_id'],
        'name' => $user['name'],
        'email' => $user['email']
      ];

      // Store role_as in session
      $_SESSION['role_as'] = $user['role_as'];

      // Redirect to the appropriate dashboard
      if ($_SESSION['role_as'] == 1) { // Admin check
        redirect("../admin/index.php", "Welcome to Admin Dashboard!");
        exit();
      } else {
        redirect("../index.php", "Login successful!");
        exit();
      }
    } else {
      redirect("../login.php", "Invalid email or password!");
      exit();
    }
  } catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage()); // Log error
    redirect("../login.php", "Database error. Please try again later.");
    exit();
  }
}