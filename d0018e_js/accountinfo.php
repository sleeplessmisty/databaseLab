<?php 
	include('/var/www/d0018e_js/php/f_cart.php');

    if (!isLoggedIn()) {
        $_SESSION['msg'] = "You must log in first";
        header('location: index.php');
    }
    $totalProducts = totalProducts();
    $cart_id = $_SESSION['cart_id'];
    $totalSumCart = totalSumCart($cart_id);
    $customer_id = $_SESSION['customerId'];
    global $db;

    // Select the data from the billing table
// Prepare and execute the SQL query

$sql = "SELECT * FROM customer WHERE id = '$customer_id'";
$result = $db->query($sql);

// Check if any results were returned
if ($result->num_rows > 0) {
    // Loop through each row and output the data
    while($row = $result->fetch_assoc()) {
    // Get the attributes of the billing record
    $username = $row["username"];
    $firstname = $row["firstname"];
    $lastname = $row["lastname"];
    $email = $row["email"];
        
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
                <a class="navbar-brand" href="shop.php">Muggle</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="shop.php">Home</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="" role="button" data-bs-toggle="dropdown" aria-expanded="false">Account</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <?php if(isLoggedIn()) : ?>
                                <!-- <li><a class="dropdown-item" href="index.php">Logout</a></li> -->
                                <div>
                                <li><a class="dropdown-item" href="accountinfo.php">Account Information</a></li>
                                <li><a class="dropdown-item" href="orderhistory.php">Order History</a></li>
                                <li><hr class="dropdown-divider" /></li>
                                <form method="post" action="index.php">
                                <button type="submit" class="button" name="logout_btn" value="<?php echo $logout_btn; ?>">Logout</button>
					            </form>
                                </div>
                            <?php else : ?>
                                <li><a class="dropdown-item" href="login.php">Login</a></li>
                                <li><a class="dropdown-item" href="registercustomer.php">Register</a></li>
                                <li><hr class="dropdown-divider" /></li>
                                <li><a class="dropdown-item" href="adminlogin.php">Admin</a></li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    </ul>
                    <form class="d-flex" action="cart.php">
                        <button class="btn btn-outline-dark" type="submit">
                            <i class="bi-cart-fill me-1"></i>
                            Cart
                            <span class="badge bg-dark text-white ms-1 rounded-circle d-inline-flex align-items-center justify-content-center"><?php echo $totalProducts ?></span>
                        </button>
                    </form>
                </div>
            </div>
        </nav>
        <!-- Header-->
        <header class="bg-dark py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder">Muggle</h1>
                    <p class="lead fw-normal text-white-50 mb-0">Mugs for everyone</p>
                </div>
            </div>
        </header>
            
        <!-- Section Checkout summary -->
        <section class="container-list">
            <div class="container">
                <h1>Account Information</h1>
                <div class="container-checkout">
                    <!--h1>Shopping Cart</h1-->
                    <div class="info">
                        <div class="account-info">
                            <h5 class="username">Username: <?php echo $username ?></h5>
                            <h5 class="firstname">First Name: <?php echo $firstname ?></h5>
                            <h5 class="lastname">Last Name: <?php echo $lastname ?></h5>
                            <h5 class="Email">Email: <?php echo $email ?></h5>
                            <br>                                  
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!--div class="right_list"> 
            <br>
        <h2>Update Account Information</h2>
        <!--?php echo display_error(); ?>
        <form method="post" action="accountinfo.php">
                <div class="form-group">
                 <label for="username">Username:</label>
                    <input  class="form-control" placeholder="Enter username" name="username" value="">
                </div>
                <div class="form-group">
                 <label for="firstname">First name:</label>
                    <input  class="form-control" placeholder="Enter first name" name="firstname" value="">
                </div>
                <div class="form-group">
                 <label for="lastname">Last name:</label>
                    <input  class="form-control" placeholder="Enter last name" name="lastname" value="">
                </div>
                <div class="form-group">
                 <label for="email">Email:</label>
                    <input  class="form-control" placeholder="Enter email" name="email" value="">
                </div>
                <div class="form-group">
                    <label for="password_1">Old password:</label>
                    <input type="password" class="form-control" id="password_1" placeholder="Enter password" name="password_old" value="">
                <div class="form-group">
                    <label for="password_1">New password:</label>
                    <input type="password" class="form-control" id="password_1" placeholder="Enter password" name="password_1" value="">
                </div>
                <div class="form-group">
                    <label for="password_2">Confirm new password:</label>
                    <input type="password" class="form-control" id="password_2" placeholder="Confirm password" name="password_2" value="">
                </div>
                <div class="checkbox">
                    </div>
                    <br>
                    <button type="submit" class="button" name="update_btn" value="<?php echo $update_btn; ?>">Register</button>
                </div>
        </div-->
        <!-- Footer-->

        <!-- Footer-->

        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
