<?php
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $passwordraw = $_POST['password'];
    $password = sha1($passwordraw);

    // Directly include variables in the SQL query (without parameter binding)
    $sqllogin = "SELECT `admin_id`, `email`, `password` FROM `tbl_admins` WHERE `email` = '$email' AND `password` = '$password'";

    try {
        include("db.php"); // Include the database connection file
        $stmt = $conn->query($sqllogin); // Execute the query without prepared statements

        // Check if any rows were returned
        $number_of_rows = $stmt->rowCount();
        if ($number_of_rows > 0) {
            // Fetch the admin data including admin_id
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);

            // Start a session and set session variables
            session_start();
            $_SESSION['admin_id'] = $admin['admin_id']; // Store admin_id in session
            $_SESSION['email'] = $email;
            $_SESSION['pass'] = $passwordraw;

            echo "<script>alert('Success')</script>";
            echo "<script>window.location.replace('mainpage.php')</script>";
        } else {
            echo "<script>alert('Failed: Incorrect email or password')</script>";
        }
    } catch (PDOException $e) {
        // Catch any exceptions and display a generic error message
        echo "<script>alert('Failed!!!')</script>";
    }
}
?>


<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="w3.css">
    <link rel="stylesheet" href="style.css">
</head>

<body onload="loadData()">
    <header class="w3-center w3-padding-32 w3-blue-grey">
        <div class="w3-margin">
            <h1>NAFA Event Sdn Bhd</h1>
            <h3>Expert Event Management Services</h3>
        </div>
    </header>
    
    <div class="w3-container w3-display-container" style="min-height: 60vh;">
        <div class="w3-display-middle w3-light-grey w3-padding-large w3-round-large w3-card-4" style="max-width: 400px;">
            <h2 class="w3-center">Login</h2>
            <form id="loginForm" action="login.php" method="POST">
                <div class="w3-section">
                    <label for="email"><b>Email</b></label>
                    <input type="email" class="w3-input w3-border w3-round" id="email" name="email" required>
                </div>
                <div class="w3-section">
                    <label for="password"><b>Password</b></label>
                    <input type="password" class="w3-input w3-border w3-round" id="password" name="password" required>
                </div>
                <div class="w3-section w3-center">
                    <input type="checkbox" id="checkboxid"> Remember Me
                </div>
                <button type="submit" name="submit" class="w3-button w3-block w3-blue w3-round-large w3-padding">Login</button>
            </form>
            <p id="errorMessage" class="w3-text-red w3-center"></p>
            <div class="w3-center w3-margin-top">
                <p>Don't have an account? <a href="registration.php" class="w3-button w3-green w3-round-large">Register</a></p>
            </div>
        </div>
    </div>

    <footer class="w3-container w3-blue-grey w3-center">
        <p>&copy; 2023 NAFA Event Sdn Bhd</p>
    </footer>

    <script>
    function rememberMe() {
        if (document.getElementById('checkboxid').checked) {
            var useremail = document.getElementById('useremailid').value;
            var password = document.getElementById('passwordid').value;
            var remember = document.getElementById('checkboxid').value;
            localStorage.setItem('useremail', useremail);
            localStorage.setItem('password', password);
            localStorage.setItem('remember', remember);
            alert('Success');
        } else {
            localStorage.removeItem('useremail');
            localStorage.removeItem('password');
            localStorage.removeItem('remember');
            document.getElementById('useremailid').value = '';
            document.getElementById('passwordid').value = '';
            document.getElementById('checkboxid').checked = false;
            alert('Removed')
        }
    }

    function loadData() {
        document.getElementById('useremailid').value = localStorage.getItem('useremail');
        document.getElementById('passwordid').value = localStorage.getItem('password');
        document.getElementById('checkboxid').checked = localStorage.getItem('remember');
    }
    </script>

</body>
</html>