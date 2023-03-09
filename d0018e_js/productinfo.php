<?php 
	include('/var/www/d0018e_js/php/f_review.php');
    if (!isLoggedIn()) {
        $_SESSION['msg'] = "You must log in first";
        header('location: index.php');
    }

    global $db;
    $totalProducts = totalProducts();
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
        <?php
        $product_id = $_SESSION['currentproduct'];
        $sql = "SELECT * FROM product WHERE id='$product_id'";
        $res = mysqli_query($db, $sql);
            $row = mysqli_fetch_array($res);
            $price = $row['price'];
            $size = $row['size'];
            $tot_reviews = $row['color'];
            $product_quantity = $row['quantity'];
                ?>
        <!-- Section-->
                <!-- Section-->
                <section class="py-5">
                <div style="text-align: center;">
                        <!-- Product image-->
                         <!--img class="imgUrl" src=<!?php echo $row["imgurl"]; ?> alt="..."-->
                         <img class="imgUrl" src="<?php echo $row["imgurl"]; ?>" alt="..." width="400" style="display: block; margin: 0 auto;">

                        <hr>
                        <!-- Product details-->
                        <h5>Price: <?php echo $row["price"]; ?> SEK</h5>
                        <h5>Size: <?php echo $row["size"]; ?></h5>
                        <h5>Color: <?php echo $row["color"]; ?></h5>
                        <!-- Product actions-->
                            <?php
                            // Visa Add to Cart-knappen endast om lagret är större än 0
                            if ($product_quantity > 0) {
                                $cart_quantity = getCartQuantity($product_id);
                                $available_quantity = $product_quantity - $cart_quantity;
                                ?>
                                <form method="post" action="productinfo.php">
                                    <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                                        <div class="form-group">
                                        <label for="quantity">Quantity:</label>
                                        <?php
                                        // Visa ett felmeddelande om kunden försöker lägga till fler varor än vad som finns i lagret
                                        if ($available_quantity == 0) {
                                            echo "<p class='text-danger'>Max quantity already reached </p>";
                                        }
                                        ?>
                                        <input type="number" id="quantity" name="quantity" value="1" min="1" max="<?php echo $available_quantity; ?>">
                                    </div>
                                    <br>
                                    <div class="d-flex justify-content-center">
                                        <button type="submit" class="button" name="addtocart_btn" value="<?php echo $product_id; ?>" <?php
                                        // Inaktivera knappen om lagret är tomt eller kunden har lagt till fler varor än vad som finns i lagret
                                        if ($available_quantity == 0) {
                                            echo "disabled";
                                        }
                                        ?>>Add to Cart</button>
                                    </div>
                                </form>
                                <?php
                                } else {
                                    echo "<p class='text-danger'>Product is currently out of stock.</p>";
                                }
                                ?>
                            <hr>
                        <h4>Reviews</h4>
                        <!-- Reviews -->
                        <?php
                        if (totalReviews($product_id) > 0){
                        ?>
                        <div class="row row-cols-1 row-cols-md-2 g-4">
                            <?php
                            $query = "SELECT comment, grade, customerid FROM review WHERE productid = $product_id";
                            $result = mysqli_query($db, $query);
                            while ($row = mysqli_fetch_array($result)) {
                                $customer_id =  $row['customerid'];
                                $grade = getGradeFromCustomerId($customer_id, $product_id);
                                $username = getUsernameFromCustomerId($customer_id);
                                $review = getReviewFromCustomerId($customer_id, $product_id);
                            ?>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo $username; ?></h5>
                                            <div class="card-subtitle mb-2 d-flex small text-warning justify-content-center">
                                                <?php
                                                    for ($i = 1; $i <= 5; $i++) {
                                                        if ($i <= round($grade)) {
                                                            echo '<div class="bi-star-fill"></div>';
                                                        } else {
                                                             echo '<div class="bi-star"></div>';
                                                            }
                                                        }
                                                        ?>
                                            </div>
                                            <p class="card-text"><?php echo $review; ?></p>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                }
                                ?>
                        </div>
                        <?php
                        } else {
                            echo "<p>No reviews yet.</p>";
                        }
                        ?>
                        </div>
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
