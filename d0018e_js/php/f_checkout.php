<?php 
session_start();
include('/var/www/d0018e_js/php/f_cart.php');

// connect to database
//$datab = mysqli_connect('localhost', 'root', 'D0018E_ElvJenDan!', 'd0018e_db');

// variable declaration
$name = "";
$errors	= array();
$carterror	= array();

if (isset($_POST['placeOrder_btn'])) {
    global $db;
    mysqli_begin_transaction($db);
    try{
        $cart_id = $_SESSION['cart_id'];
        $cart_id_int = intval($cart_id);
        setPriceCartitem($cart_id_int);
        $customer_id = $_SESSION['customerId'];
        $customer_id_int = intval($customer_id);
        $totalSum = totalSumCart($cart_id_int);
        $totalSum_int = intval($totalSum);

        $last_cart_id = $_SESSION['cart_id'];
        $_SESSION['last_cart_id'] = $last_cart_id;

        $query_b_id = "SELECT id FROM billing WHERE cartid='$cart_id' LIMIT 1";
        $result_q_b_id = mysqli_query($db, $query_b_id);
        $row = mysqli_fetch_assoc($result_q_b_id);
        $billing_id_int = intval($row['id']);
        $_SESSION['billing_id'] = $billing_id_int;

        $billing_id = $_SESSION['billing_id'];
        $billing_id_int = intval($billing_id);

        // retrieve cart items for a given cart_id
        $query = "SELECT productid, quantity FROM cartitem WHERE cartid = ?";
        $stmt = mysqli_prepare($db, $query);
        mysqli_stmt_bind_param($stmt, "i", $cart_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt); 

        $quantity_error = false;
        $can_update = true;

        // loop through the result set and update product quantities
        while ($row = mysqli_fetch_assoc($result)) {
            $product_id = $row['productid'];
            $quantity = $row['quantity'];

            // get the current quantity for the product
            $query = "SELECT quantity, active FROM product WHERE id = ?";
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, "i", $product_id);
            mysqli_stmt_execute($stmt);
            $result2 = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_array($result2);
            $current_quantity = $row['quantity'];
            $active = $row['active'];

            // check if the cart item quantity is greater than the product quantity, or out of stock/removed
            if ($quantity > $current_quantity || $quantity == 0) {
                $quantity_error = true;
                $can_update = false;

                // set the cart item quantity to the product quantity
                $query = "UPDATE cartitem SET quantity = ? WHERE cartid = ? AND productid = ?";
                $stmt = mysqli_prepare($db, $query);
                mysqli_stmt_bind_param($stmt, "iii", $current_quantity, $cart_id, $product_id);
                mysqli_stmt_execute($stmt);
            }
            if ($active == 0) {
                $quantity_error = true;
                $can_update = false;
            }
        }
        if ($quantity_error) { 
            session_start();
            $_SESSION['carterror'] = "The inventory changed since you placed the products in the basket and the quantity of some products were updated. Please update and review basket before proceeding with purchase.";
                // Commit the transaction
            mysqli_commit($db);
            header("location: cart.php");
            exit(); 
        }
        // update the product stock by subtracting the cart item quantity
        if ($can_update) {
        $new_quantity = $current_quantity - $quantity;
        $query = "UPDATE product SET quantity = ? WHERE id = ?";
        $stmt = mysqli_prepare($db, $query);
        mysqli_stmt_bind_param($stmt, "ii", $new_quantity, $product_id);
        mysqli_stmt_execute($stmt);
    }

        // Update the status in the cart table
        $query_cart = "UPDATE cart SET status = 'closed' WHERE id = ?";
        $stmt = mysqli_prepare($db, $query_cart);
        mysqli_stmt_bind_param($stmt, "i", $cart_id);
        mysqli_stmt_execute($stmt);

        // Check for errors
        if(mysqli_stmt_error($stmt)) {
            printf("Error message: %s\n", mysqli_stmt_error($stmt));
        } 

        $query_order = "INSERT INTO `order` (billingid, customerid, cartid, totalsum) 
            VALUES('$billing_id_int', '$customer_id', '$cart_id_int', '$totalSum_int')";
        if(mysqli_query($db, $query_order)) { 
            setSessionOrder($billing_id_int);
            createCart($customer_id);
            // Commit the transaction
            mysqli_commit($db);
            header("location: ordercomplete.php");
            exit(); 
        } else {
            echo "Error: " . mysqli_error($db); 
        } 
    } catch (Exception $e) {
        // Rollback the transaction
        mysqli_rollback($db);
    }
} 

if (isset($_POST['details_btn'])) {
    $order_id = $_POST['details_btn'];
    $_SESSION['review_order_id'] = $order_id;
    header("location: detailsreviews.php");
        exit(); 
    global $db;
}

if (isset($_POST['admindetails_btn'])) {
    $order_id = $_POST['admindetails_btn'];
    $_SESSION['view_order_id'] = $order_id;
    header("location: adminvieworder.php");
        exit(); 
    global $db;
}

function getCartId($order_id){
	global $db;
	$query = "SELECT cartid FROM `order` WHERE id='$order_id'";
	$result_query= mysqli_query($db, $query);
	if ($result_query && mysqli_num_rows($result_query) > 0){
		$row = mysqli_fetch_assoc($result_query);
		$cart_id = $row['cartid'];
		return $cart_id;
	} else {
		return NULL;      
	}
}

function setSessionOrder ($billing_id) {
    global $db;
    $query_order = "SELECT id FROM `order` WHERE billingid='$billing_id'" ;
    $result_q_o_id = mysqli_query($db, $query_order);
    $row2 = mysqli_fetch_assoc($result_q_o_id);
    $order_id_int = intval($row2['id']);
    $_SESSION['order_id'] = $order_id_int;
    $order_id = $_SESSION['order_id'];
    $order_id_int = intval($order_id); 
}

function getTotalSumOrder($order_id){
	global $db;
	$query = "SELECT totalsum FROM `order` WHERE id='$order_id'";
	$result_query= mysqli_query($db, $query);
	if ($result_query && mysqli_num_rows($result_query) > 0){
		$row = mysqli_fetch_assoc($result_query);
		$totalSum = $row['totalsum'];
		return $totalSum;
	}else{
		return 0;      
	}
} 

function setPriceCartitem($cart_id) {
    global $db;
    $query = "SELECT productid FROM cartitem WHERE cartid='$cart_id'";
    $result_q = mysqli_query($db, $query);
    while($row = mysqli_fetch_assoc($result_q)){
        $product_id = $row['productid'];
        $query_price = "SELECT price FROM product WHERE id='$product_id'" ;
        $result_p = mysqli_query($db, $query_price);
        $row_p = mysqli_fetch_assoc($result_p);
        $price = $row_p['price'];
        $query_update = "UPDATE cartitem SET price='$price' WHERE productid='$product_id' AND cartid = '$cart_id'";
        $result = mysqli_query($db, $query_update);
    }
}

