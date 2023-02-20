<?php 
session_start();
include('/var/www/d0018e_js/php/f_login.php');

// connect to database
//$datab = mysqli_connect('localhost', 'root', 'D0018E_ElvJenDan!', 'd0018e_db');

// variable declaration
$name = "";
$errors	= array(); 

if (isset($_POST['addtocart_btn'])) {
    $product_id = intval($_POST['addtocart_btn']);
    $quantity = intval($_POST['quantity']);
    addtoCart($product_id, $quantity);
}

function addtoCart($product_id, $quantity){
    global $db;
    $cart_id = $_SESSION['cart_id'];
    $cart_id_int = intval($cart_id);
    echo "Adding product id: " . $product_id . " with quantity: " . $quantity;
    $query_cart = "INSERT INTO cartitem (cartid, productid, quantity) 
        VALUES('$cart_id_int', '$product_id', '$quantity')
        ON DUPLICATE KEY UPDATE quantity = quantity + $quantity";
    if(mysqli_query($db, $query_cart)) {
        header("location: shop.php");
        exit(); 
    } else {
        echo "Error: " . mysqli_error($db);
    }   
}

function totalProducts() {
	global $db;
	$cart_id = $_SESSION['cart_id'];
	$p_query = "SELECT SUM(quantity) as total_quantity FROM cartitem WHERE cartid='$cart_id'";
	$result = mysqli_query($db, $p_query);
  
	if ($result && mysqli_num_rows($result) > 0) {
	  $row = mysqli_fetch_assoc($result);
	  return $row['total_quantity'];
	} else {
	  return 0;
	}
  }

  if (isset($_POST['updatecart_btn'])) {
    $product_id = intval($_POST['updatecart_btn']);
    $quantity = intval($_POST['quantity']);
    updateCart($product_id, $quantity);
}

function updateCart($product_id, $quantity){
    global $db;
    $cart_id = $_SESSION['cart_id'];
    $cart_id_int = intval($cart_id);
    $query_cart = "UPDATE cartitem 
                   SET quantity = '$quantity' 
                   WHERE cartid = '$cart_id_int' AND productid = '$product_id'";
    if(mysqli_query($db, $query_cart)) {
        header("location: cart.php");
        exit(); 
    } else {
        echo "Error: " . mysqli_error($db);
    }   
}

if (isset($_POST['removeproduct_btn'])) {
    $product_id = intval($_POST['removeproduct_btn']);
    removeProductCart($product_id);
}

function removeProductCart($product_id){
    global $db;
    $cart_id = $_SESSION['cart_id'];
    $cart_id_int = intval($cart_id);
    $query_cart = "DELETE FROM cartitem 
                 WHERE cartid = '$cart_id_int' AND productid = '$product_id'";
    if(mysqli_query($db, $query_cart)) {
        header("location: cart.php");
        exit(); 
    } else {
        echo "Error: " . mysqli_error($db);
    }   
}

function totalSumCart($cart_id){
    global $db;
	$sql = "SELECT SUM(product.price * cartitem.quantity) AS total_price FROM product 
        JOIN cartitem ON product.id = cartitem.productid 
        WHERE cartitem.cartid = '$cart_id'";

	$result = mysqli_query($db, $sql);

	if (mysqli_num_rows($result) > 0) {
		$row = mysqli_fetch_assoc($result);
		$total_price = $row['total_price'];
		return $total_price;
	} else {
		$total_price = 0;
        return $total_price;
	}   
}