<?php
session_start();
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session
echo "<script>alert('You have been logged out.');</script>";
echo "<script>window.location.replace('login.php');</script>";
exit();
?>
