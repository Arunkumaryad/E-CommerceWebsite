<?php
session_start();

// Check if the admin is logged in
if (isset($_SESSION['admin_name'])) {
    // Unset all of the session variables
    session_unset();

    // Destroy the session
    session_destroy();
    
    // Redirect to a specific page after logout (e.g., index.php)
    header("Location: index.php");
    exit();
} else {
    // If the admin is not logged in, redirect to a login page or an appropriate page
    header("Location: admin_login.php");
    exit();
}
?>
