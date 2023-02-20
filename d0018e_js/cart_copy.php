<?php 
	include('/var/www/d0018e_js/php/f_cart.php');
    if (!isLoggedIn()) {
        $_SESSION['msg'] = "You must log in first";
        header('location: index.php');
    }
    $totalProducts = totalProducts();
    $cart_id = $_SESSION['cart_id'];
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
        <title>Cart page</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/style.css" rel="stylesheet" />
        <link href="css/cart.css" rel="stylesheet" />
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
                                <form method="post" action="index.php">
                                <button type="submit" class="button" name="logout_btn" value="<?php echo $logout_btn; ?>">Logout</button>
					            </form>
                                <li><a class="dropdown-item" href="accountinfo.php">Account Information</a></li>
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

        <header class="bg-dark py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder">Mugs with style!</h1>
                    <p class="lead fw-normal text-white-50 mb-0">Mugs for everyone</p>
                </div>
            </div>
        </header>
        
        <div class="container-shopandpay d-flex justify-content-center">
            <div class="left-column">
                <!-- Section CART ITEMS -->
                <section class="py-5">
                    <div class="container">
                        <h1>Shopping Cart</h1>
                        <?php
                        $query = "SELECT * FROM cartitem WHERE cartid = '$cart_id' ";
                        $result = mysqli_query($db, $query);

                        while ($row = mysqli_fetch_array($result)) {
                            $product_id = $row['productid'];
                            $product_quantity = $row['quantity'];
                            $query_2 = "SELECT * FROM product WHERE id = '$product_id;' ";
                            $result_2 = mysqli_query($db, $query_2);
                            $row2 = mysqli_fetch_array($result_2);
                            $product_name = $row2['name'];
                            $product_price = $row2['price'];
                            $itemtotal_price = $row2['price'] * $row['quantity'];
                            $product_size = $row2['size'];
                            $product_color = $row2['color'];
                        ?>
                            <section class="py-5">
                                <div class="container-cart">
                                    <div class="cart">
                                        <div class="product">
                                            <img class="card-img-top" src=<?php echo $row2["imgurl"]; ?> alt="...">
                                            <div class="product-info">
                                                <h5 class="product-name">Product: <?php echo $product_name ?></h5>
                                                <h6 class="product-price">Price: <?php echo $itemtotal_price ?> SEK</h6>
                                                <h6 class="product-size">Size: <?php echo $product_size ?></h6>
                                                <h6 class="product-color">Color: <?php echo $product_color ?></h6>
                                                <form method="post" action="shop.php">
                                                    <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                                                    <div class="form-group">
                                                        <label for="quantity">Quantity:</label>
                                                        <input type="number" id="quantity" name="quantity" value="<?php echo $product_quantity ?>" min="1">
                                                    </div>
                                                    <div class="d-flex justify-content-center">
                                                        <button type="submit" class="button" name="updatecart_btn" value="<?php echo $product_id; ?>">Update Cart</button>
                                                    </div>
                                                </form>
                                                <form method="post" action="shop.php">
                                                    <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                                                    <button type="submit" class="product-remove" name="removeproduct_btn" value="<?php echo $product_id; ?>">Remove from Cart</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        <?php
                        }
                        ?>
                    </div>
                </section>
            </div>
            <div class="right-column">
                <div class="container">
                    <h3>Cart Total: <?php echo $totalSumCart ?> SEK</h3>
                    <!-- Display payment information here -->

                </div>
            </div>
        </div>
        <!-- Footer -->
        <footer class="py-5 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Your Website 2022</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
