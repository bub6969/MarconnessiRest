<?php
session_start(); // Start the session to access and destroy it.

// Unset all of the session variables.
$_SESSION = array();

// Destroy the session (clears data from the server).
session_destroy();

// --- Handle "Remember Me" cookie (if you have one) ---
// IMPORTANT: If you use a "remember_me" cookie, you MUST expire it here.
// The path "/" ensures the cookie is deleted across the entire domain.
if (isset($_COOKIE["remember_me"])) {
    setcookie("remember_me", "", time() - 3600, "/"); // Set expiration to the past.
}

// Redirect to the login page.
// The correct path depends on where this logout.php file is located
// relative to your login page.
//
// OPTION 1: If logout.php is in 'marconnessi/pages/' and login.php is in 'marconnessi/pages/Login/'
header("Location: pages/Login/login.php");

// OPTION 2: If logout.php is directly in 'marconnessi/' and login.php is in 'marconnessi/pages/Login/'
// header("Location: pages/Login/login.php");

// OPTION 3: If login.php is at the root 'marconnessi/login.php' (less likely based on your structure)
// header("Location: ../login.php"); // Assuming logout is in pages/

exit; // Essential to stop script execution after redirect.
?>