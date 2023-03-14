<?php 
session_start();

// connect to database
include('/var/www/d0018e_js/php/f_product.php');
//$db = mysqli_connect('localhost', 'root', 'D0018E_ElvJenDan!', 'd0018e_db');

// variable declaration
$username = "";
$errors   = array(); 

 if (isset($_POST['updateaddress_btn'])) {
    $billing_id = intval($_POST['billing_id']);
    $address = ($_POST['address']);
    updateAddress($billing_id, $address);
}

 function updateAddress($billing_id, $address){
    global $db;
    $query_billing = "UPDATE billing SET address = '$address'
                 WHERE id = $billing_id";
    if(mysqli_query($db, $query_billing)) {
        header("location: adminvieworder.php");
        exit(); 
    } else {
        echo "Error: " . mysqli_error($db);
    }    
 }  

 // zity phone credit

 if (isset($_POST['updatezipcode_btn'])) {
    $billing_id = intval($_POST['billing_id']);
    $zipcode= ($_POST['zipcode']);
    updateZip($billing_id, $zipcode);
}

 function updateZip($billing_id, $zipcode){
    global $db;
    $query_billing = "UPDATE billing SET zipcode = '$zipcode'
                 WHERE id = $billing_id";
    if(mysqli_query($db, $query_billing)) {
        header("location: adminvieworder.php");
        exit(); 
    } else {
        echo "Error: " . mysqli_error($db);
    }    
 }  

 if (isset($_POST['updatecity_btn'])) {
    $billing_id = intval($_POST['billing_id']);
    $city = ($_POST['city']);
    updateCity($billing_id, $city);
}

function updateCity($billing_id, $city){
    global $db;
    $query_billing = "UPDATE billing SET city = '$city'
                 WHERE id = $billing_id";
    if(mysqli_query($db, $query_billing)) {
        header("location: adminvieworder.php");
        exit(); 
    } else {
        echo "Error: " . mysqli_error($db);
    }    
}

if (isset($_POST['updatephonenr_btn'])) {
    $billing_id = intval($_POST['billing_id']);
    $phonenr = intval($_POST['phonenr']);
    updatePhonenr($billing_id, $phonenr);
}

function updatePhonenr($billing_id, $phonenr){
    global $db;
    $query_billing = "UPDATE billing SET phonenumber = '$phonenr'
                 WHERE id = $billing_id";
    if(mysqli_query($db, $query_billing)) {
        header("location: adminvieworder.php");
        exit(); 
    } else {
        echo "Error: " . mysqli_error($db);
    }    
}

if (isset($_POST['updatecreditcard_btn'])) {
    $billing_id = intval($_POST['billing_id']);
    $creditCardnr = intval($_POST['creditCardnr']);
    updateCreditcard($billing_id, $creditCardnr);
}

function updateCreditcard($billing_id, $creditCardnr){
    global $db;
    $query_billing = "UPDATE billing SET creditcardnr = '$creditCardnr'
                 WHERE id = $billing_id";
    if(mysqli_query($db, $query_billing)) {
        header("location: adminvieworder.php");
        exit(); 
    } else {
        echo "Error: " . mysqli_error($db);
    }    
}

if (isset($_POST['updatecart_btn_order'])) {
    $product_id = intval($_POST['updatecart_btn_order']);
    $quantity = intval($_POST['quantity']);
    $cart_id = intval($_POST['cart_id']);
    $order_id = intval($_POST['order_id']);
    $previous_quantity = intval($_POST['previous_quantity']);
    updateQuantityOrder($product_id, $quantity, $cart_id, $order_id, $previous_quantity);
}

function updateQuantityOrder($product_id, $quantity, $cart_id, $order_id, $previous_quantity){
    global $db;
    $query_cart = "UPDATE cartitem 
                   SET quantity = $quantity
                   WHERE cartid = $cart_id AND productid = $product_id";
    if(mysqli_query($db, $query_cart)) {
        updateStock($product_id, $previous_quantity, $quantity);
        $totalSum = getNewTotalSum($cart_id);
        $query_cart2 = "UPDATE `order` SET totalsum = $totalSum
            WHERE cartid = $cart_id";
        if(mysqli_query($db, $query_cart2)) {
            header("location: adminvieworder.php");
            exit(); 
        } else {
            echo "Error: " . mysqli_error($db);
        } 
    } else {
        echo "Error: " . mysqli_error($db);
    }   
}

if (isset($_POST['removeproduct_btn_order'])) {
    $product_id = intval($_POST['removeproduct_btn_order']);
    $cart_id = intval($_POST['cart_id']);
    $order_id = intval($_POST['order_id']);
    $previous_quantity = intval($_POST['previous_quantity']);
    removeProductOrder($product_id, $cart_id, $previous_quantity);
}

function removeProductOrder($product_id, $cart_id, $previous_quantity){
    global $db;
    $query_cart = "DELETE FROM cartitem 
                 WHERE cartid = $cart_id AND productid = $product_id";
    if(mysqli_query($db, $query_cart)) {
        updateStock($product_id, $previous_quantity, 0);
        header("location: adminvieworder.php");
        exit(); 
    } else {
        echo "Error: " . mysqli_error($db);
    }   
}

if (isset($_POST['updateprice_btn_order'])) {
    $product_id = intval($_POST['updateprice_btn_order']);
    $cart_id = intval($_POST['cart_id']);
    $product_price = intval($_POST['new_price']);
    $order_id = intval($_POST['order_id']);
    updatePriceOrder($product_id, $cart_id, $product_price);
}

function updatePriceOrder($product_id, $cart_id, $product_price){
    global $db;
    $query_cart = "UPDATE cartitem SET price = $product_price
                 WHERE cartid = $cart_id AND productid = $product_id ";
    if(mysqli_query($db, $query_cart)) {
        $totalSum = getNewTotalSum($cart_id);
        $query_cart2 = "UPDATE `order` SET totalsum = $totalSum
            WHERE cartid = $cart_id";
        if(mysqli_query($db, $query_cart2)) {
            header("location: adminvieworder.php");
            exit(); 
        } else {
            echo "Error: " . mysqli_error($db);
        } 
    } else {
        echo "Error: " . mysqli_error($db);
    }   
}

function updateStock($product_id, $previous_quantity, $quantity){
    global $db;
    //if stock should increase
    if($previous_quantity < $quantity){
        $difference = intval($quantity - $previous_quantity);
        $current_quantity = getStockProduct($product_id);
        $new_quantity = intval($current_quantity - $difference);
        $query_stock = "UPDATE product SET quantity = $new_quantity
            WHERE id = $product_id ";
        if(mysqli_query($db, $query_stock)) {
            return;
    //if stock should decrease
            } 
    }elseif($previous_quantity > $quantity){
        $difference = intval($previous_quantity - $quantity);
        $current_quantity = getStockProduct($product_id);
        $new_quantity = intval($current_quantity + $difference);
        $query_stock = "UPDATE product SET quantity = $new_quantity
            WHERE id = $product_id ";
        if(mysqli_query($db, $query_stock)) {
            return;
        }
    }elseif($quantity == 0){
        $difference = intval($previous_quantity - $quantity);
        $current_quantity = getStockProduct($product_id);
        $new_quantity = intval($current_quantity + $difference);
        $query_stock = "UPDATE product SET quantity = $new_quantity
            WHERE id = $product_id ";
        if(mysqli_query($db, $query_stock)) {
            return;
        }
    }else{

    echo "Error: " . mysqli_error($db);
    }
}


function getStockProduct($product_id){
    global $db;
    $query = "SELECT quantity FROM product WHERE id=$product_id";
    $result_query= mysqli_query($db, $query);
    if ($result_query && mysqli_num_rows($result_query) > 0){
        $row = mysqli_fetch_assoc($result_query);
        $quantity = $row['quantity'];
        return $quantity;
    }else{
        return NULL;      
    }
}

function getNewTotalSum($cart_id){
    global $db;
    $query = "SELECT SUM(cartitem.price * cartitem.quantity) AS totalSum FROM cartitem 
        WHERE cartitem.cartid = '$cart_id'";
    $result = mysqli_query($db, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $totalSum = $row['totalSum'];
        if ($totalSum === null) {
            return 0;
        } else {
            return $totalSum;
        }
    } else {
        return 0;
    }
}

if (isset($_POST['update_status_order'])) {
    /*header("location: admin.php");
    exit();*/
   $status = $_POST['order-status'];
    $order_id = $_POST['update_status_order'];

    // Set the SQL query to sort the data based on the user's selection
    $query = "UPDATE `order` SET status = '$status' WHERE id =  '$order_id'";

    if(mysqli_query($db, $query)) {
        header("location: adminvieworder.php");
        exit(); 
    } else {
        echo "Error: " . mysqli_error($db);
    }
}
