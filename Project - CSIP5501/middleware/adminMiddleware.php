<?php
session_start();
include ("../functions/myfunctions.php");

// Check if the user is authenticated
if (!isset($_SESSION['auth'])) {
  redirect("../login.php", "You must login first.");
}

// Check if the user has admin role (role_as = 1)
if ($_SESSION['role_as'] != 1) { // Non-admin users
  redirect("../index.php", "You are not authorized to access this page");
}