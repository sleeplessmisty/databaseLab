<?php 
	include('/var/www/d0018e_js/php/f_product.php');
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
        <link href="css/modal.css" rel="stylesheet" />
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

                    <!-- Section-->
                    <section class="py-5">
                        <div class="container px-4 px-lg-5 mt-5">
                        <form method="get" action="">
                            <label for="color-filter" class="fw-bolder">Colors:</label><br>
                            <input type="checkbox" id="red" name="color[]" value="red">
                            <label for="red">Red</label><br>
                            <input type="checkbox" id="blue" name="color[]" value="blue">
                            <label for="blue">Blue</label><br>
                            <input type="checkbox" id="green" name="color[]" value="green">
                            <label for="green">Green</label><br>
                            <input type="checkbox" id="white" name="color[]" value="white">
                            <label for="green">White</label><br>
                            <input type="checkbox" id="yellow" name="color[]" value="yellow">
                            <label for="green">Yellow</label><br>
                            <input type="checkbox" id="pink" name="color[]" value="pink">
                            <label for="green">Pink</label><br>
                            <br>
                            <label for="sort-by" class="fw-bolder">Sort by:</label>
                            <br>
                            <select name="sort-by"id="sort-by">
                                <option value="">None</option>
                                <option value="price-asc">Price: Low to High</option>
                                <option value="price-desc">Price: High to Low</option>
                                <option value="name-asc">Name: A-Z</option>
                                <option value="name-desc">Name: Z-A</option>
                            </select>
                            <br>
                            <br>
                            <button type="submit" class="button">Apply</button>
                            </form>
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center gap-sm-3">
                    
                    <?php

                       if(isset($_GET['color'])) {
                            $selected_colors = $_GET['color'];
                            echo "Viewing colors:<br>";
                            foreach ($selected_colors as $color) {
                                echo ucfirst($color) . "<br>";
                            }
                            // Build the SQL query with a WHERE clause for the selected colors
                            $where = "active = '1' AND (";
                            foreach ($selected_colors as $color) {
                                if ($where != "active = '1' AND (") {
                                    $where .= ' OR ';
                                }
                                $where .= "color = '$color'";
                            }
                            $where .= ")";
                        } else {
                            // If no colors are selected, set the WHERE clause to return all active products
                            $where = "active = '1'";
                        }
                    // Check if the form has been submitted
                    if (isset($_GET['sort-by'])) {
                      $sort_by = $_GET['sort-by'];
            
                      // Set the SQL query to sort the data based on the user's selection
                      $sql_query = "SELECT * FROM product WHERE $where ORDER BY ";
            
                      if ($sort_by == 'price-asc') {
                        $sql_query .= "price ASC";
                        // Execute the SQL query
                      $res = mysqli_query($db, $sql_query);
                      } else if ($sort_by == 'price-desc') {
                        $sql_query .= "price DESC";
                        // Execute the SQL query
                      $res = mysqli_query($db, $sql_query);
                      } else if ($sort_by == 'name-asc') {
                        $sql_query .= "name ASC";
                        // Execute the SQL query
                      $res = mysqli_query($db, $sql_query);
                      } else if ($sort_by == 'name-desc') {
                        $sql_query .= "name DESC";
                        // Execute the SQL query
                      $res = mysqli_query($db, $sql_query);
                      }else{

                      $res = mysqli_query($db, "SELECT * FROM product WHERE $where");
                      }
                      
                    
                    }else{
                        $res = mysqli_query($db, "SELECT * FROM product WHERE $where");
                    }
  
                    
                    while ($row = mysqli_fetch_array($res)) {
                        $product_id = $row['id'];
                        $product_quantity = $row['quantity'];
                        $avg_grade = getAvggrade($product_id);
                        $tot_reviews = totalReviews($product_id);
                    ?>
                        <div class="col sm-4">
                            <div class="card h-100">
                                <!-- Product image-->
                                <!-- Button trigger modal -->
                                <button type="button" class="modalButton" data-bs-toggle="modal" data-bs-target="#productModal<?php echo $product_id; ?>"><img class="card-img-top" src=<?php echo $row["imgurl"]; ?> alt="..."></button>
                                <!-- Product details-->
                                <hr>
                                <div class="card-body p-3">
                                    <div class="text-center">
                                        <!-- Product name-->
                                        <h5 class="fw-bolder"><?php echo $row["name"]; ?> </h5>
                                        <h5><?php echo $row["price"]; ?> SEK</h5>
                                    </div>
                                    <!-- reviews here -->
                                    <div class="d-flex justify-content-center small text-warning mb-2">
                                        <?php if ($avg_grade === null) {
                                            // If avg_grade is NULL, display no stars
                                            echo '<p>No reviews yet</p>';
                                        } else {
                                            // Otherwise, display the stars based on the average grade
                                            $rounded_avg = $avg_grade < 4.5 ? floor($avg_grade) : ceil($avg_grade);
                                            for ($i = 1; $i <= 5; $i++) {
                                                if ($i <= $rounded_avg) {
                                                    echo '<div class="bi-star-fill"></div>';
                                                } else {
                                                    echo '<div class="bi-star"></div>';
                                                }
                                            }
                                            echo "   (" . $tot_reviews . ")";
                                        }?>
                                    </div>
                                </div>
                                <!-- Product actions-->
                                <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                    <?php
                                    // Visa Add to Cart-knappen endast om lagret är större än 0
                                    if ($product_quantity > 0) {
                                        $cart_quantity = getCartQuantity($product_id);
                                        $available_quantity = $product_quantity - $cart_quantity;
                                        ?>
                                        <form method="post" action="shop.php">
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
                                </div>
                            </div>
                        </div>
                        <!-- Modal -->
                        <div class="modal" id="productModal<?php echo $product_id; ?>" tabindex="-1" role="dialog" aria-labelledby="productModalLabel<?php echo $product_id; ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title"><?php echo $row["name"]; ?></h4>
                                        <form method="post" action="shop.php">
                                            <button type="submit" name="product_pressed" value="<?php echo $product_id; ?>" class="buttonnew">View Product</button>
                                        </form>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Product image-->
                                        <img class="imgUrl" src=<?php echo $row["imgurl"]; ?> alt="...">
                                        <hr>
                                        <!-- Product details-->
                                        <h5>Price: <?php echo $row["price"]; ?> SEK</h5>
                                        <h5>Size: <?php echo $row["size"]; ?></h5>
                                        <h5>Color: <?php echo $row["color"]; ?></h5>
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
                                                            <div class="card-subtitle mb-2 d-flex small text-warning align-items-center">
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
                                    <!-- Modal Footer -->
                                    <div class="modal-footer">
                                        <button type="button" class="button" data-bs-dismiss="modal" data-target="productModal<?php echo $product_id; ?>">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </section>

        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Muggle | Lab in course D0018E @ LTU 2023</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <!-- JS that clash with current DROPDOWN MENU, do not touch -->
        <!-- script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.3/umd/popper.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/js/bootstrap.min.js"></script -->

        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>