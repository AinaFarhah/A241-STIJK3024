<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'db.php';

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $phone_number = $_POST['phone_number'];
    $address = $_POST['address'];

    try {
        // Prepare the statement
        $stmt = $conn->prepare("INSERT INTO tbl_admins (name, email, password, phone_number, address) VALUES (?, ?, ?, ?, ?)");
        // Execute the statement with the input parameters
        $stmt->execute([$name, $email, $password, $phone_number, $address]);

        echo "<script>alert('Registration Successful');</script>";
        echo "<script>window.location.href = 'login.php';</script>";
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) { // Integrity constraint violation (e.g., duplicate email)
            echo "Error: Email already registered!";
        } else {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>


<!DOCTYPE html>
<html>

<head>
    <title>Registration</title>
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

    <main class="w3-container" style="min-height: 60vh; display: flex; align-items: center; justify-content: center;">
        <div class="w3-light-grey w3-padding-large w3-round-large w3-card-4" style="max-width: 400px;">
            <h2 class="w3-center">Registration</h2>
            <form id="registrationForm" action="registration.php" method="POST" onsubmit="return validateRegistration()">
                <div class="w3-section">
                    <label for="name"><b>Name</b></label>
                    <input type="text" class="w3-input w3-border w3-round" id="name" name="name" required>
                </div>
                <div class="w3-section">
                    <label for="email"><b>Email</b></label>
                    <input type="email" class="w3-input w3-border w3-round" id="email" name="email" required>
                </div>
                <div class="w3-section">
                    <label for="password"><b>Password</b></label>
                    <input type="password" class="w3-input w3-border w3-round" id="password" name="password" required>
                </div>
                <div class="w3-section">
                    <label for="phone_number"><b>Phone Number</b></label>
                    <input type="tel" class="w3-input w3-border w3-round" id="phone_number" name="phone_number" required>
                </div>
                <div class="w3-section">
                    <label for="address"><b>Address</b></label>
                    <textarea class="w3-input w3-border w3-round" id="address" name="address" required></textarea>
                </div>
                <button type="submit" name="submit" class="w3-button w3-block w3-green w3-round-large w3-padding">Register</button>
            </form>
            <p id="errorMessage" class="w3-text-red w3-center"></p>
            <div class="w3-center w3-margin-top">
                <p>Already have an account? <a href="login.php" class="w3-button w3-blue w3-round-large">Login</a></p>
            </div>
        </div>
    </main>

    <footer class="w3-container w3-blue-grey w3-center">
        <p>&copy; 2023 NAFA Event Sdn Bhd</p>
    </footer>

    <script>
        function validateRegistration() {
        let name = document.getElementById("name").value;
        let email = document.getElementById("email").value;
        let password = document.getElementById("password").value;
        let phone = document.getElementById("phone_number").value;
        let address = document.getElementById("address").value;
        let errorMessage = document.getElementById("errorMessage");

        if (!name || !email || !password || !phone || !address) {
            errorMessage.textContent = "All fields are required.";
            return false;
        }

        if (password.length < 6) {
            errorMessage.textContent = "Password must be at least 6 characters long.";
            return false;
        }

        return true;
    }
    </script>
</body>

</html>