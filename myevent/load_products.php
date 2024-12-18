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

// Search operation based on search form
if (isset($_GET['btnsearch'])) {
    $search = $_GET['search'];
    $searchby = $_GET['searchby'];

    if ($searchby == "name") {
        $sqlloadproducts = "SELECT * FROM `tbl_products` WHERE `product_name` LIKE '%$search%'";
    }
    if ($searchby == "description") {
        $sqlloadproducts = "SELECT * FROM `tbl_products` WHERE `product_description` LIKE '%$search%'";
    }
} else {
    $sqlloadproducts = "SELECT * FROM `tbl_products`";
}

// Pagination setup
$results_per_page = 10;
if (isset($_GET["pageno"])) {
    $pageno = (int) $_GET["pageno"];
    $page_first_result = ($pageno - 1) * $results_per_page;
} else {
    $pageno = 1;
    $page_first_result = 0;
}

// Database connection and data retrieval
include("dbconnect.php"); // database connection

$stmt = $conn->prepare($sqlloadproducts);
$stmt->execute();
$number_of_rows = $stmt->rowCount();
$number_of_page = ceil($number_of_rows / $results_per_page);

// Adjust SQL to include pagination
$sqlloadproducts = $sqlloadproducts . " LIMIT $page_first_result, $results_per_page";
$stmt = $conn->prepare($sqlloadproducts);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Function for truncating text (e.g., description)
function truncate($string, $length, $dots = "...") {
    return strlen($string) > $length
        ? substr($string, 0, $length - strlen($dots)) . $dots
        : $string;
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

        .footer {
            text-align: center;
            padding: 10px;
            background-color: #f1f1f1;
        }

        .product-card {
            padding: 10px;
            margin-bottom: 30px;
            border: 1px solid #ddd;
            border-radius: 10px;
            height: 450px;
        }

        .product-card img {
            width: 100%; /* Adjust this to a fixed width if you prefer */
            height: 200px; /* Set a fixed height for uniformity */
            object-fit: cover; /* Maintain aspect ratio and ensure the image fills the container */
        }
        .product-card .product-description {
            text-align: justify;
            display: -webkit-box;
            -webkit-line-clamp: 4; /* Limit to 4 lines (adjust as necessary) */
            -webkit-box-orient: vertical; /* Ensure the text is shown vertically */
            overflow: hidden; /* Hide content that overflows */
            text-overflow: ellipsis; /* Add "..." for overflowed text */
            min-height: 80px; /* Minimum height to accommodate short descriptions */
            max-height: 120px; /* Maximum height to ensure long descriptions don't overflow */
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
        <h2>Our Products</h2>

        <!-- Search Form -->
        <form action="load_products.php" method="GET">
            <input type="text" name="search" placeholder="Search products..." />
            <select name="searchby">
                <option value="name">Name</option>
                <option value="description">Description</option>
            </select>
            <button type="submit" name="btnsearch">Search</button>
        </form>

        <!-- Product Listing -->
        <div class="w3-row-padding">
            <?php if (count($rows) == 0) { ?>
                <p>No products found.</p>
            <?php } else { ?>
                <?php foreach ($rows as $row) { ?>
                    <div class="w3-third">
                        <div class="product-card">
                            <img src="<?php echo file_exists("uploads/" . $row['product_image']) ? "uploads/" . $row['product_image'] : "uploads/default.jpg"; ?>" 
                                alt="<?php echo htmlspecialchars($row['product_name']); ?>">
                            <h4><?php echo htmlspecialchars($row['product_name']); ?></h4>
                            <div class="product-description">
                                <p><?php echo htmlspecialchars($row['product_description']); ?></p>
                            </div>
                            <p><strong>Price: RM<?php echo htmlspecialchars($row['product_price']); ?></strong></p>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>


        <!-- Pagination -->
        <div class="w3-center">
            <?php if ($pageno > 1) { ?>
                <a href="load_products.php?pageno=<?php echo $pageno - 1; ?>" class="w3-button w3-teal">Previous</a>
            <?php } ?>
            <?php if ($pageno < $number_of_page) { ?>
                <a href="load_products.php?pageno=<?php echo $pageno + 1; ?>" class="w3-button w3-teal">Next</a>
            <?php } ?>
        </div>
    </div>

    <!-- Footer -->
    <footer class="w3-container w3-grey w3-center w3-padding-16">
        <p>&copy; 2023 NAFA Event Sdn Bhd</p>
    </footer>

</body>

</html>

