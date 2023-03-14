
<?php 
	include('/var/www/d0018e_js/php/f_product.php');

    if (!isLoggedIn()) {
        $_SESSION['msg'] = "You must log in first";
        header('location: index.php');
    }
    //$totalProducts = totalProducts();
    $cart_id = $_SESSION['cart_id'];
    $totalSumCart = totalSumCart($cart_id);
    $customer_id = $_SESSION['customerId'];
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
        <link href="css/modal.css" rel="stylesheet" />
    </head>
    <body>
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href="admin.php">Muggle</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="admin.php">Home</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="" role="button" data-bs-toggle="dropdown" aria-expanded="false">Account</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <?php if(isLoggedIn()) : ?>
                                <!-- <li><a class="dropdown-item" href="index.php">Logout</a></li> -->
                                <div>
                                <li><a class="dropdown-item" href="adminaccountinfo.php">Account Information</a></li>
                                <li><a class="dropdown-item" href="adminorderhistory.php">Order History</a></li>
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
                </div>
            </div>
        </nav>
        <!-- Header-->
        <header class="bg-dark py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder">Order view</h1>
                    <p class="lead fw-normal text-white-50 mb-0">Viewing an order</p>
                </div>
            </div>
        </header>
        
        <!-- Section CART ITEMS -->
        <section class="py-5">
        <div class="container">
            <h1>Order details</h1>
            <?php
            $order_id = $_SESSION['view_order_id'];
            $order_cartid = getCartId($order_id);
            $totalSumCart = getTotalSumOrder($order_id);
            $query = "SELECT * FROM cartitem WHERE cartid = '$order_cartid' ";
            // Execute the query
            $result = mysqli_query($db, $query);
            ?>
            <?php
            $sql = "SELECT * FROM `order` WHERE id = '$order_id'";
            $result = mysqli_query($db, $sql);
            ?>
            <?php while ($row = mysqli_fetch_array($result)){ ?>
                <?php
                    $billing_id = $row['billingid'];
                    $cart_id = $row['cartid'];
                    $totalSumOrder = $row['totalsum'];
                    $address = getAddress($billing_id);
                    $zipcode = getZipcode($billing_id);
                    $city = getCity($billing_id);
                    $phonenr = getPhoneNumber($billing_id);
                    $creditCardnr = getCreditCardnr($billing_id);
                ?>

                <div class="info">
                    <div class="account-info">
                        <h5>Order nr:  <?php echo $order_id ?></h5>
                        Cart: <?php echo $cart_id ?><br>
                        Address: <input name="address" value="<?php echo $address; ?>"><br>
                        Zip code: <input name="zipcode" value="<?php echo $zipcode; ?>"><br>
                        City: <input name="city" value="<?php echo $city ?>"><br>
                        Phone number: <input name="phonenr" value="<?php echo $phonenr; ?>"><br>
                        CreditcardNr: <input name="creditCardnr" value="<?php echo $creditCardnr; ?>"><br>
                        <h5>Total Sum: <?php echo $totalSumCart ?> SEK</h5>                                
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
        <div class="container">
        <?php
            $order_id = $_SESSION['view_order_id'];
            $order_cartid = getCartId($order_id);
            $totalSumCart = getTotalSumOrder($order_id);
            $query = "SELECT * FROM cartitem WHERE cartid = '$order_cartid' ";
            // Execute the query
            $result = mysqli_query($db, $query);
            ?>
        <?php
        // Loop through the results and display the products
        while ($row3 = mysqli_fetch_array($result)) {
            $order_id = $_SESSION['view_order_id'];
            $order_cartid = getCartId($order_id);
            $product_id = $row3['productid'];
            $product_quantity = $row3['quantity'];
            $product_price = $row3['price'];
            // Execute the query
            $query_2 = "SELECT * FROM product WHERE id = '$product_id' ";
            $result_2 = mysqli_query($db, $query_2);
            $row2 = mysqli_fetch_array($result_2);
            // Get the product information from the current row
            $product_name = $row2['name'];
            if($product_price == NULL){
                $product_price = $row2['price'];
            }
            $itemtotal_price = $row2['price'];
            $product_size = $row2['size'];
            $product_color = $row2['color'];
            // Display the product information in the given HTML format
            ?>
                    <!--h1>Shopping Cart</h1-->
                    <div class="card w-75">
                <div class="card-body">
                    <div class="product">
                        <img class="imgUrl" src=<?php echo $row2["imgurl"]; ?> alt="...">
                            <div class="product-info">
                                <h5 class="product-name">Product: <?php echo $product_name ?> (<?php echo $product_quantity ?> x <?php echo $product_price ?> kr)</h5>
                                <!-- Product details-->
                                <div class="justify-content-center">
                                <h6>Size: <?php echo $product_size; ?></h6>
                                    <h6>Color: <?php echo $product_color; ?></h6>
                                    <!--h6>Price: <!--?php echo $product_price; ?> SEK</h6-->
                                    <form method="post" action="adminvieworder_test.php">
                                        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                                        <input type="hidden" name="cart_id" value="<?php echo $order_cartid; ?>">
                                        <div class="form-group">
                                            <label for="quantity">Price:</label>
                                            <input type="text" id="new_price" name="new_price" value="<?php echo $product_price ?>">
                                            <div class="d-flex justify-content-center">
                                                <button type="submit" class="button" name="updateprice_btn_order" value="<?php echo $product_id; ?>">Update Price</button>
                                            </div>
                                        </div>
                                    </form>
                                    
                                    <form method="post" action="adminvieworder_test.php">
                                        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                                        <input type="hidden" name="cart_id" value="<?php echo $order_cartid; ?>">
                                        <div class="form-group">
                                            <label for="quantity">Quantity:</label>
                                            <input type="number" id="quantity" name="quantity" value="<?php echo $product_quantity ?>" min="1">
                                            <div class="d-flex justify-content-center">
                                                <button type="submit" class="button" name="updatecart_btn_order" value="<?php echo $product_id; ?>">Update Quantity</button>
                                            </div>
                                        </div>
                                    </form>
                                    <form method="post" action="adminvieworder_test.php">
                                <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                                <button type="submit" class="product-remove" name="removeproduct_btn_order" value="<?php echo $product_id; ?>">Remove from Order</button>
                            </form>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
            <?php
            }
            ?>
        </div>
        </section>
        <!-- Footer-->
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
