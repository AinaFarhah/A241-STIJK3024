<?php
session_start();

// Check if admin_id exists in session
if (!isset($_SESSION['admin_id'])) {
    // If no session found, redirect to login page
    echo "<script>alert('No session available. Please login.');</script>";
    echo "<script>window.location.replace('login.php');</script>";
    exit(); // Terminate the script to prevent further code execution
}

// Access session variables like admin_id and email
$admin_id = $_SESSION['admin_id'];
$email = $_SESSION['email'];
?>

<!DOCTYPE html>
<html>

<head>
    <title>Main Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="w3.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header class="w3-center w3-padding-32 w3-blue-grey">
        <div class="w3-margin">
            <h1>NAFA Event Sdn Bhd</h1>
            <h3>Expert Event Management Services</h3>
        </div>
    </header>
    
    <div class="w3-container w3-display-container" style="min-height: 60vh;">
        <div class="w3-display-middle w3-light-grey w3-padding-large w3-round-large w3-card-4" style="max-width: 400px;">
            <p>Welcome to the main page of our event management system.</p>
        </div>
    </div>

    <footer class="w3-container w3-blue-grey w3-center">
        <p>&copy; 2023 NAFA Event Sdn Bhd</p>
    </footer>
</body>

</html>
