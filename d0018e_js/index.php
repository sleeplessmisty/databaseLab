<?php 
	include('/var/www/d0018e_js/php/f_cart.php');
    if (isset($_SESSION['user']) && $_SESSION['userType'] == 'admin' ) {
		header('location: admin.php');
	}else if (isset($_SESSION['user']) && $_SESSION['userType'] == 'customer' ){
		header('location: shop.php');
	}
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
    </head>
    <body>
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href="shop.php">Muggle</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="index.php">Home</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="" role="button" data-bs-toggle="dropdown" aria-expanded="false">Account</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <?php if(isLoggedIn()) : ?>
                                <!-- <li><a class="dropdown-item" href="index.php">Logout</a></li> -->
                                <form method="post" action="index.php">
                                <button type="submit" class="button" name="logout_btn" value="<?php echo $logout_btn; ?>">Logout</button>
					            </form>
                            <?php else : ?>
                                <li><a class="dropdown-item" href="login.php">Login</a></li>
                                <li><a class="dropdown-item" href="registercustomer.php">Register</a></li>
                                <li><hr class="dropdown-divider" /></li>
                                <li><a class="dropdown-item" href="adminlogin.php">Admin</a></li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    </ul>
                    <form class="d-flex">
                        <button class="btn btn-outline-dark" type="submit">
                            <i class="bi-cart-fill me-1"></i>
                            Cart
                            <span class="badge bg-dark text-white ms-1 rounded-pill">0</span>
                        </button>
                    </form>
                </div>
            </div>
        </nav>
        <!-- Header-->
        <header class="bg-dark py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder">Welcome to Muggle!</h1>
                    <p class="lead fw-normal text-white-50 mb-0">Login or register an account to purchase products</p>
                </div>
            </div>
        </header>
        <!-- Section-->
        <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center gap-sm-3">
            <?php
            $res = mysqli_query($db, "select * from product");
            while ($row = mysqli_fetch_array($res)) {
            ?>
                <div class="col sm-4">
                    <div class="card h-100">
                        <!-- Product image-->
                        <img class="card-img-top" src=<?php echo $row["imgurl"]; ?> alt="...">
                        <!-- Product details-->
                        <hr>
                        <div class="card-body p-4">
                            <div class="text-center">
                                <!-- Product name-->
                                <h5 class="fw-bolder"><?php echo $row["name"]; ?> </h5>
                                <h2><?php echo $row["price"]; ?> SEK</h2>
                            </div>
                        </div>
                        <!-- Product actions-->
                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
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
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
