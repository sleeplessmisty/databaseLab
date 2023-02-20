<?php 
include('/var/www/d0018e_js/php/f_product.php');

if (!isAdmin()) {
	$_SESSION['msg'] = "You must log in first";
	header('location: adminlogin.php');
}

if (isset($_GET['logout'])) {
	session_destroy();
	unset($_SESSION['user']);
	header("location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Inventory Homepage</title>
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
                                <li><a class="dropdown-item" href="admin.php">Logout</a></li>
                                <li><a class="dropdown-item" href="admin.php">Change password</a></li>
                                <li><hr class="dropdown-divider" /></li>
                                <li><a class="dropdown-item" href="admin.php">Create admin</a></li>
                                <?php else : ?>
                                <li><a class="dropdown-item" href="admin.php">Login</a></li>
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
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="inventory.php">Order history</a></li> 
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Header-->
        <header class="bg-dark py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder">Product creation page</h1>
                    <p class="lead fw-normal text-white-50 mb-0">Type in the information below</p>
                </div>
            </div>
        </header>
        <!-- Section-->
        <div class="container">
            <h2>Add Product</h2>
                <form method="post" action="inventory.php">
                <?php echo display_error(); ?>
                    <div class="form-group">
                    <label for="name">Product name:</label>
                        <input class="form-control" placeholder="Enter product name" name="name" value="<?php echo $name; ?>">
                    </div>
                    <div class="form-group">
                        <label for="price">Price:</label>
                        <input type="number" class="form-control" placeholder="Enter product price" name="price" value="<?php echo $price; ?>">
                    </div>
                    <div class="form-group">
                        <label for="size">Size:</label>
                        <input class="form-control" placeholder="Enter product size" name="size" value="<?php echo $size; ?>">
                    </div>
                    <div class="form-group">
                        <label for="color">Color:</label>
                        <input class="form-control" placeholder="Enter product color" name="color" value="<?php echo $color; ?>">
                    </div>
                    <div class="form-group">
                        <label for="imgurl">Image url:</label>
                        <input class="form-control" placeholder="Enter image url" name="imgurl" value="<?php echo $imgurl; ?>">
                    </div>
                    <div class="form-group">
                        <label for="quantity">Quantity:</label>
                        <input class="form-control" placeholder="Enter quantity" name="quantity" value="<?php echo $quantity; ?>">
                    </div>
                    <div class="checkbox">
                        </div>
                        <br>
                        <button type="submit" class="button" name="addproduct_btn" value="<?php echo $addproduct_btn; ?>">Register</button>
                    </div>
        </div>
        <br>
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
