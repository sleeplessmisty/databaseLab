<?php 
    include('/var/www/d0018e_js/php/f_login.php');
    global $db;

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
                    <h1 class="display-4 fw-bolder">Admin Homepage</h1>
                    <p class="lead fw-normal text-white-50 mb-0">Products Overview</p>
                </div>
            </div>
        </header>
        <!-- Section-->
        <section class="py-5">
        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
            <form action="products.php">
                <div class="d-flex justify-content-center">
                    <button class="button" href="products.php">View/Alter Products</button>
                </div>
            </form>
        </div>
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center gap-sm-3">
            <?php
            $res = mysqli_query($db, "SELECT * FROM product");
            while ($row = mysqli_fetch_array($res)) {
                $active = $row["active"];
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
                                <?php if($active == 0) : 
                                 echo "<p class='text-danger'>Product not active in store </p>";
                                 ?>
                                 <?php endif; ?>
                            </div>
                        </div>
                        <!-- Product actions-->
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
