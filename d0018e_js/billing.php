<?php 
	include('/var/www/d0018e_js/php/f_billing.php');
    if (!isLoggedIn()) {
        $_SESSION['msg'] = "You must log in first";
        header('location: index.php');
    }
    $totalProducts = totalProducts();
    $cart_id = $_SESSION['cart_id'];
    $customer_id = $_SESSION['customerId'];
    $totalSumCart = totalSumCart($cart_id);
    global $db;
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
    <!-- Container -->
        <div class="container">
<br>
            <h2>Billing information</h2>
                <form method="post" action="billing.php">
                <?php echo display_error(); ?>
                <div class="form-group">
                 <label for="address">Address:</label>
                    <input  class="form-control" placeholder="Enter address" name="address" value="<?php echo $address; ?>">
                </div>
                <div class="form-group">
                 <label for="zipcode">Zip code:</label>
                    <input  class="form-control" placeholder="Enter zip code" name="zipcode" value="<?php echo $zipcode; ?>">
                </div>
                <div class="form-group">
                 <label for="city">City:</label>
                    <input  class="form-control" placeholder="Enter city" name="city" value="<?php echo $city; ?>">
                </div>
                <div class="form-group">
                 <label for="phonenumber">Phone number:</label>
                    <input  class="form-control" placeholder="Enter phone number" name="phonenumber" value="<?php echo $phonenumber; ?>">
                </div>
                <div class="form-group">
                    <label for="creditcard">Credit card number:</label>
                    <input type="creditcardnr" class="form-control" id="creditcardnr" placeholder="Enter credit card number" name="creditcardnr" value="<?php echo $creditcardnr ?>">
                </div>
                <div class="checkbox">
                     <div class="buttons">
                    </div>
                    <br>
                                        <!--form action="cart.php">
                    <h4><button class="button" href="cart.php">Previous</button></h4></div>
                </form -->
                    <button type="submit" class="button" name="prevbilling_btn" value="<?php echo $prevbilling_btn; ?>">Previous</button>
                    <button type="submit" class="button" name="billing_btn" value="<?php echo $billing_btn; ?>">Next</button>
                <br>
                    <br>
               
                <br>
                <br>
                </div>
                            </div>
           
            
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
