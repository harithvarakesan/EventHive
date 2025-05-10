<?php
session_start();

// Destroy all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect to the home page or login page
header("Location: login.php");
exit();
?>
