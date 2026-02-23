<?php
session_start();

// Remove all session variables
session_unset();

// Destroy the session completely
session_destroy();

// Redirect to kitchen login page
header("Location: kitchen_login.php");
exit();
?>
