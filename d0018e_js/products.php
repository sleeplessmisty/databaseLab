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
        <title>Shop Homepage</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/style.css" rel="stylesheet" />

        <!--script type="text/javascript" src="/js/jquery.tabledit.js"></script-->
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!--link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"-->
        <!--link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css"-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" integrity="sha256-ivk71nXhz9nsyFDoYoGf2sbjrR9ddh+XDkCcfZxjvcM= sha384-E7gp+UYBLS2XewcxoJbfi0UpGMHSvt9XyI9bH4YIw5GDGW8AlC+2J7bVBBlMFC6p sha512-7aMbXH03HUs6zO1R+pLyekF1FTF89Deq4JpHw6zIo2vbtaXnDw+/2C03Je30WFDd6MpSwg+aLW4Di46qzu488Q==" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

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
                                <li><a class="dropdown-item" href="adminaccountinfo.php">Account Information</a></li>
                                <li><a class="dropdown-item" href="admin.php">Back to Adminpage</a></li>
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
                    <h1 class="display-4 fw-bolder">Modify products</h1>
                    <p class="lead fw-normal text-white-50 mb-0">Select a field to alter information</p>
                </div>
            </div>
        </header>
        <!-- Section-->
        <section class="py-5">
        <script type="text/javascript" src="js/jquery.tabledit.js"></script>
        <div class="container home">	
            <h2>Edit inventory</h2>		
            <h5>To remove/add product from store, set "active" as 0 or 1. </h5>	 
            <div class="table-responsive">
            <table id="data_table" class="table table-striped">
                <thead>
                    <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Size</th>
                    <th>Color</th>
                    <th>Quantity</th>	
                    <th>Image URL</th>
                    <th>Active</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $sql_query = "SELECT id, name, price, size, color, imgurl, quantity, active FROM product";
                    $resultset = mysqli_query($db, $sql_query) or die("database error:". mysqli_error($db));
                    while( $product = mysqli_fetch_assoc($resultset) ) {
                    ?>
                    <tr id="<?php echo $product ['id']; ?>">
                        <td><?php echo $product ['id']; ?></td>
                        <td><?php echo $product ['name']; ?></td>
                        <td><?php echo $product ['price']; ?></td>
                        <td><?php echo $product ['size']; ?></td>
                        <td><?php echo $product ['color']; ?></td>
                        <td><?php echo $product ['quantity']; ?></td>
                        <td><?php echo $product ['imgurl']; ?></td>
                        <td><?php echo $product ['active']; ?></td>
                    <?php } ?>
                </tbody>
            </table>	
            </div >

            <form action="inventory.php">
                <br>
            <button class="button" href="inventory.php">Add new Product</button>
            </form>
            <br>
        </div>
        <script type="text/javascript" src="/js/custom_table_edit.js"></script>
        <script>
        //apply
        //$("#data-table").SetEditable();
        </script>
        </script>
        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Muggle | Lab in course D0018E @ LTU 2023</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <!--script src="js/scripts.js"></script-->
    </body>
</html>