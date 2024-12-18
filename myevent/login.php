<?php
if (isset($_POST['submit'])) {
    $email = $_POST['useremail'];
    $passwordraw = $_POST['password'];
    $password = sha1($passwordraw);
    $sqllogin = "SELECT  * FROM tbl_admins WHERE admin_email = '$email' AND admin_password = '$password'";
    
    try{
        include("dbconnect.php"); // database connection
        $stmt = $conn->prepare($sqllogin);
        $result = $stmt->execute();
        $number_of_rows = $stmt->rowCount();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($number_of_rows > 0) {
            $userid  = $row['admin_id'];
            session_start();
            $_SESSION['sessionid'] = session_id();
            $_SESSION['adminid'] = $userid;
            $_SESSION['adminemail'] = $email;
            $_SESSION['adminpass'] = $passwordraw;
            echo "<script>alert('Success')</script>";
            echo "<script>window.location.replace('mainpage.php')</script>";
        }else{
            echo "<script>alert('Failed')</script>";
        }
    }catch(PDOException $e){
        echo "<script>alert('Failed!!!')</script>";
    }
}
?>

<html>

<head>
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="https://www.w3schools.com/w3css/4/w3.css">
</head>

<body onload="loadData()">
    <header class="w3-center w3-padding-32 w3-blue-grey">
        <div class="w3-margin">
            <h1>NAFA Event Sdn Bhd</h1>
            <h3>Expert Event Manager</h3>
        </div>
    </header>
    <div class="w3-hide-small" style="height:100px">
    </div>
    <div class="w3-container" style="max-width: 600px;margin:auto">
    <!-- <div class="w3-display-middle w3-light-grey w3-padding-large w3-round-large w3-card-4" style="max-width: 400px;"> -->
        <h1>Login</h1>
        <form action="login.php" method="post">
            <input class="w3-input w3-round w3-border" type="text" id="useremailid" name="useremail"
                placeholder="Enter Email" required><br>
            <input class="w3-input w3-round w3-border" type="password" id="passwordid" name="password"
                placeholder="Enter Password" required><br>
            <p class="">Remember Me &nbsp;&nbsp;&nbsp;
                <input type="checkbox" name="rememberme" id="checkboxid" onclick="rememberMe()">
            </p>
            <input class="w3-input w3-round w3-button w3-blue-grey" type="submit" name="submit" value="Login">
        </form>
    </div>
    <div class="w3-center w3-container">
        <a href="register.php">Register</a>
    </div>
    <div class="" style="height:200px">
    </div>
    <footer class="w3-container w3-grey">
        <p style="text-align: center">
            Copyright &copy; 2023 NAFA Event Sdn Bhd
        </p>
    </footer>
</body>

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

</html>