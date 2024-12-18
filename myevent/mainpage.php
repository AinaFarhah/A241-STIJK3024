<?php
session_start();
if (isset($_SESSION['sessionid'])) {
    $adminemail = $_SESSION['adminemail'];
    $adminpass = $_SESSION['adminpass'];
    $adminid = $_SESSION['adminid'];
}else{
    echo "<script>alert('No session available. Please login.');</script>";
    echo "<script>window.location.replace('login.php')</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <style>
        .navbar {
            background-color: #009688; /* Teal color */
        }

        .navbar a {
            color: white;
        }

        .content {
            padding: 20px;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header class="w3-center w3-padding-32 w3-blue-grey">
        <div class="w3-margin">
            <h1>NAFA Event Sdn Bhd</h1>
            <h3>Expert Event Manager</h3>
        </div>
    </header>
    <!-- Navbar -->
    <div class="w3-bar w3-teal navbar">
        <a href="mainpage.php" class="w3-bar-item w3-button">Home</a>
        <a href="load_products.php" class="w3-bar-item w3-button">Products</a>
        <a href="logout.php" class="w3-bar-item w3-button w3-right w3-red">Logout</a>
    </div>

    <!-- Content -->
    <div class="content w3-container">
        <h2>Welcome to Our Company</h2>
            <p>At NAFA Event Sdn Bhd, we specialize in providing expert event management services. With years of experience in organizing corporate events, weddings, conferences, and other special events, we ensure a seamless and unforgettable experience for all our clients.</p>
            
            <h3>Our Mission</h3>
            <p>Our mission is to deliver exceptional event planning and execution, ensuring every detail exceeds our clients' expectations. We are committed to professionalism, creativity, and innovation in every event we manage.</p>

            <h3>Why Choose Us?</h3>
            <ul>
                <li>Professional and experienced team</li>
                <li>Customized event planning to fit every need</li>
                <li>High-quality service with attention to detail</li>
                <li>Affordable and competitive pricing</li>
            </ul>

            <h3>Our Values</h3>
            <p>We value integrity, creativity, and customer satisfaction. We believe in building lasting relationships with our clients based on trust and mutual respect.</p>
    </div>

    <!-- Footer -->
    <footer class="w3-container w3-grey w3-center w3-padding-16">
        <p>&copy; 2023 NAFA Event Sdn Bhd</p>
    </footer>
</body>

</html>
