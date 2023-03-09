<?php 
include('/var/www/d0018e_js/php/f_login.php');
//include('/var/www/d0018e_js/php/adminaccountinfo.php');

if (!isAdmin()) {
	$_SESSION['msg'] = "You must log in first";
	header('location: adminlogin.php');
}

if (isset($_GET['logout'])) {
	session_destroy();
	unset($_SESSION['user']);
	header("location: index.php");
}
$admin_id = $_SESSION['admin_id'];
$sql = "SELECT * FROM admin WHERE id = '$admin_id'";
$result = $db->query($sql);

// Check if any results were returned
if ($result->num_rows > 0) {
    // Loop through each row and output the data
    while($row = $result->fetch_assoc()) {
    // Get the attributes of the billing record
    $username = $row["username"];
        
    }
} else {
    //echo "0 results";
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Shop Homepage</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/style.css" rel="stylesheet" />
        <link href="css/checkout.css" rel="stylesheet" />
    </head>
    <body>
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href="admin.php">Muggle</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                       <!-- <li class="nav-item"><a class="nav-link active" aria-current="page" href="shop.php">Home</a></li> -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="" role="button" data-bs-toggle="dropdown" aria-expanded="false">Admin account</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <?php if(isLoggedIn()) : ?>
                                <!-- Change here -->
                                <li><a class="dropdown-item" href="adminaccountinfo.php">Account information</a></li>
                                <li><a class="dropdown-item" href="createadmin.php">Create admin</a></li>
                                <li><hr class="dropdown-divider" /></li>
                                <form method="post" action="index.php">
                                <button type="submit" class="button" name="logout_btn" value="<?php echo $logout_btn; ?>">Logout</button>
                                </form>
                                <?php else : ?>
                                <li><a class="dropdown-item" href="adminlogin.php">Login</a></li>
                                <?php endif; ?>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="" role="button" data-bs-toggle="dropdown" aria-expanded="false">Inventory</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="inventory.php">Add Product</a></li>
                                <li><a class="dropdown-item" href="products.php">View/Alter Products</a></li>
                            </ul>
                        </li>
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="adminorderhistory.php">Order history</a></li> 
                    </ul>
                    
                </div>
            </div>
        </nav>
            <!-- Header-->
            <header class="bg-dark py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder">Admin Page</h1>
                    <p class="lead fw-normal text-white-50 mb-0">Account Information</p>
                </div>
            </div>
        </header>
        <!-- Section-->
        <section class="py-5">
            
              
        <!-- Section Checkout summary -->
        <section class="container-list">
            <div class="container">
                <h1>Account Information</h1>
                <div class="container-checkout">
                    <!--h1>Shopping Cart</h1-->
                    <div class="info">
                        <div class="account-info">
                            <h5 class="username">Username: <?php echo $username ?></h5>
                            <br>                                  
                        </div>
                    </div>
                </div>
            </div>
        </section>

        </section>
        <section class="container-list">
            <div class="container">
            <h2>All Admins</h2>
        <div class="table-responsive">
            <table id="data_table" class="table table-striped">
                <thead>
                    <tr>
                    <th>ID</th>
                    <th>Username</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $sql_query = "SELECT id, username FROM admin";
                    $resultset = mysqli_query($db, $sql_query) or die("database error:". mysqli_error($db));
                    while( $product = mysqli_fetch_assoc($resultset) ) {
                    ?>
                    <tr id="<?php echo $product ['id']; ?>">
                        <td><?php echo $product ['id']; ?></td>
                        <td><?php echo $product ['username']; ?></td>
                    <?php } ?>
                </tbody>
            </table>	
            </div>
        </section>
        <!-- Footer-->
        <footer class="py-5 bg-dark">
        <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Muggle | Lab in course D0018E @ LTU 2023</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
