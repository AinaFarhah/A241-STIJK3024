<?php
session_start();
if (isset($_SESSION['sessionid'])) {
    $adminemail = $_SESSION['adminemail'];
    $adminpass = $_SESSION['adminpass'];
    $adminid = $_SESSION['adminid'];
} else {
    echo "<script>alert('No session available. Please login.');</script>";
    echo "<script>window.location.replace('login.php');</script>";
}

// Include database connection
include("dbconnect.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $eventTitle = htmlspecialchars(trim($_POST['eventTitle']));
    $eventDescription = htmlspecialchars(trim($_POST['eventDescription']));
    $eventType = htmlspecialchars(trim($_POST['eventType']));
    $location = htmlspecialchars(trim($_POST['location']));
    $dateFrom = htmlspecialchars(trim($_POST['dateFrom']));
    $dateTo = htmlspecialchars(trim($_POST['dateTo']));
    $numDays = (int)$_POST['numDays'];

    // Server-side validation
    if (empty($eventTitle) || empty($eventDescription) || empty($eventType) || empty($location) || empty($dateFrom) || empty($dateTo)) {
        echo "<script>alert('All fields are required.');</script>";
    } elseif (strtotime($dateTo) < strtotime($dateFrom)) {
        echo "<script>alert('Invalid date range.');</script>";
    } else {
        try {
            // Insert data into the database
            $stmt = $conn->prepare("INSERT INTO tbl_events_request (event_title, event_description, event_type, location, date_from, date_to, num_days) 
                                    VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$eventTitle, $eventDescription, $eventType, $location, $dateFrom, $dateTo, $numDays]);

            echo "<script>alert('Event registration request submitted successfully!');</script>";
        } catch (PDOException $e) {
            echo "<script>alert('Failed to submit event request: " . $e->getMessage() . "');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
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

        .form-container {
            max-width: 600px;
            margin: auto;
            margin-bottom: 50px; /* Adds space below the form */
        }

        /* Tooltip styling */
        select option[title]:hover {
            background-color: #f1f1f1;
            cursor: help;
        }

        .footer {
            text-align: center;
            padding: 10px;
            background-color: #f1f1f1;
        }  
    </style>
    <script>
        // Function to calculate the number of days between two dates
        function calculateDays() {
            const dateFrom = new Date(document.getElementById("dateFrom").value);
            const dateTo = new Date(document.getElementById("dateTo").value);

            if (dateFrom && dateTo && dateTo >= dateFrom) {
                const timeDifference = dateTo - dateFrom;
                const days = timeDifference / (1000 * 60 * 60 * 24) + 1;
                document.getElementById("numDays").value = days;
            } else {
                document.getElementById("numDays").value = "Invalid dates";
            }
        }

        // Client-side validation
        function validateForm() {
            const title = document.getElementById("eventTitle").value.trim();
            const description = document.getElementById("eventDescription").value.trim();
            const eventType = document.getElementById("eventType").value;
            const location = document.getElementById("location").value.trim();
            const dateFrom = document.getElementById("dateFrom").value;
            const dateTo = document.getElementById("dateTo").value;

            if (!title || !description || !eventType || !location || !dateFrom || !dateTo) {
                alert("All fields are required.");
                return false;
            }

            if (new Date(dateTo) < new Date(dateFrom)) {
                alert("'Date To' must not be earlier than 'Date From'.");
                return false;
            }

            return true;
        }
    </script>
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
        <a href="event_form.php" class="w3-bar-item w3-button">Event Register</a>
        <a href="logout.php" class="w3-bar-item w3-button w3-right w3-red">Logout</a>
    </div>
    
    <!-- Form -->
    <div class="content w3-center">
        <h2>Event Registration Form</h2>
    </div>
    <div class="w3-container" style="max-width: 600px; margin: auto; margin-bottom: 50px;">
        <form method="POST" class="w3-container w3-card-4 w3-padding" onsubmit="return validateForm()">
            <label for="eventTitle">Event Title:</label>
            <input class="w3-input w3-border" type="text" id="eventTitle" name="eventTitle" required>

            <label for="eventDescription">Event Description:</label>
            <textarea class="w3-input w3-border" id="eventDescription" name="eventDescription" rows="4" required></textarea>

            <label for="eventType">Event Type:</label>
            <select class="w3-select w3-border" id="eventType" name="eventType" required>
                <option value="" disabled selected>Choose event type</option>
                <option value="Conference" title="Professional meetings or business events">Conference</option>
                <option value="Wedding" title="Wedding ceremonies and receptions">Wedding</option>
                <option value="Birthday" title="Birthday celebrations">Birthday</option>
                <option value="Workshop" title="Educational or hands-on activities">Workshop</option>
            </select>

            <label for="location">Location:</label>
            <input class="w3-input w3-border" type="text" id="location" name="location" required>

            <label for="dateFrom">Date From:</label>
            <input class="w3-input w3-border" type="date" id="dateFrom" name="dateFrom" required onchange="calculateDays()">

            <label for="dateTo">Date To:</label>
            <input class="w3-input w3-border" type="date" id="dateTo" name="dateTo" required onchange="calculateDays()">

            <label for="numDays">Number of Days:</label>
            <input class="w3-input w3-border" type="text" id="numDays" name="numDays" readonly>

            <button class="w3-button w3-teal w3-margin-top" type="submit">Submit</button>
        </form>
    </div>

    <!-- Footer -->
    <footer class="w3-container w3-grey w3-center w3-padding-16">
        <p>&copy; 2023 NAFA Event Sdn Bhd</p>
    </footer>

</body>

</html>