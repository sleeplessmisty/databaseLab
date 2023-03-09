<?php 
session_start();
include('/var/www/d0018e_js/php/f_register.php');

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
/*
if (isset($_SESSION['carterror'])) {
    echo "<div class='error-message'>" . $_SESSION['carterror'] . "</div>";
    unset($_SESSION['carterror']);
} */

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

    $sql = "SELECT status FROM cart WHERE id = $cart_id";

    // execute the query and store the result in $result
    $result1 = mysqli_query($db, $sql);

    // check if the query was successful and if it returned any rows
    if ($result1 && mysqli_num_rows($result1) > 0) {
        // fetch the first row from the result set as an associative array
        $row = mysqli_fetch_assoc($result1);
        // access the 'status' attribute from the $row array
        $status = $row['status'];
        if ($status == 'closed'){
            return 0;
        }else{

        $p_query = "SELECT SUM(quantity) as total_quantity FROM cartitem WHERE cartid='$cart_id'";
        $result = mysqli_query($db, $p_query);
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $total_quantity = $row['total_quantity'];
            if ($total_quantity === null) {
                return 0;
            } else {
                return $total_quantity;
            }
        } else {
            return 0;
          }
        }
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

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $total_price = $row['total_price'];
        if ($total_price === null) {
            return 0;
        } else {
            return $total_price;
        }
    } else {
        return 0;
    }
}

function getAvggrade($product_id) {
	global $db;
	$query_avg = "SELECT avggrade FROM product WHERE id='$product_id' LIMIT 1";
        $result_query_avg= mysqli_query($db, $query_avg);
        $row = mysqli_fetch_assoc($result_query_avg);
		$avg_grade = $row['avggrade'];
		return $avg_grade;
        
}

function getCartQuantity($product_id) {
    global $db;
    $cart_id = $_SESSION['cart_id'];
    $cart_id_int = intval($cart_id);
    $query = "SELECT quantity FROM cartitem WHERE cartid='$cart_id' AND productid='$product_id'";
    $currentQuantity = mysqli_query($db, $query);
    if ($currentQuantity && mysqli_num_rows($currentQuantity) > 0){
        return intval(mysqli_fetch_array($currentQuantity)[0]);
    } else{
        return 0;
    }
}
