<?php

if (isset($_POST['submit'])) {
    $email = $_POST['useremail'];
    $password = sha1($_POST['password']);
    $sqlregister = "INSERT INTO tbl_admins(admin_email, admin_password) VALUES ('$email','$password')";
    
    try{
        include("dbconnect.php"); // database connection
        $conn->query($sqlregister);
        echo "<script>alert('Success')</script>";
        echo "<script>window.location.replace('login.php')</script>";
    }catch(PDOException $e){
        echo "<script>alert('Failed!!!')</script>";
    }
}

?>

<html>

<head>
    <title>Registration</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="https://www.w3schools.com/w3css/4/w3.css">
</head>

<body>
    <header class="w3-center w3-padding-32 w3-blue-grey">
        <div class="w3-margin">
            <h1>NAFA Event Sdn Bhd</h1>
            <h3>Expert Event Manager</h3>
        </div>
    </header>
    <div class="w3-hide-small" style="height:100px">
    </div>
    <div class="w3-container" style="max-width: 600px;margin:auto">
        <h1>Register</h1>
        <form action="register.php" method="post">
            <input class="w3-input w3-round w3-border" type="text" id="useremailid" name="useremail"
                placeholder="Enter Email" required><br>
            <input class="w3-input w3-round w3-border" type="password" id="passwordid" name="password"
                placeholder="Enter Password" required><br>
            <input class="w3-input w3-round w3-button w3-blue-grey" type="submit" name="submit" value="Register">
        </form>
    </div>
    <div class="w3-center w3-container">
        <a href="login.php">Login</a>
    </div>
    <div class="" style="height:200px">
    </div>
    <footer class="w3-container w3-grey">
        <p style="text-align: center">
            Copyright &copy; 2023 NAFA Event Sdn Bhd
        </p>
    </footer>
</body>

</html>