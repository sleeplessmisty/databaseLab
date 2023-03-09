<?php 
session_start();

// connect to database
include('/var/www/d0018e_js/php/f_checkout.php');
//$db = mysqli_connect('localhost', 'root', 'D0018E_ElvJenDan!', 'd0018e_db');

// variable declaration
$username = "";
$errors   = array(); 
$cart_id = $_SESSION['cart_id'];

// call the registeradmin() function if registeradmin_btn is clicked
if (isset($_POST['billing_btn'])) {

// REGISTER ADMIN
	// call these variables with the global keyword to make them available in function
	global $db, $errors;

	// receive all input values from the form. Call the e() function
    // defined below to escape form values

	$customer_id = $_SESSION['customerId'];
	$cart_id = $_SESSION['cart_id'];

	$address    =  e($_POST['address']);
	$zipcode  =  e($_POST['zipcode']);
	$city  =  e($_POST['city']);
    $phonenumber  =  e($_POST['phonenumber']);
	$creditcardnr  =  e($_POST['creditcardnr']);

	$sql = "SELECT COUNT(*) as total_rows FROM billing WHERE cartid = '$cart_id'";
	$result = mysqli_query($db, $sql);
	$row = mysqli_fetch_assoc($result); 



	// form validation: ensure that the form is correctly filled
	if (empty($address)) { 
		array_push($errors, "Address is required"); 
	}

    if (empty($zipcode)) { 
		array_push($errors, "Zip code is required"); 
	}

     if (empty($city)) { 
		array_push($errors, "City is required"); 
	}

     if (empty($phonenumber)) { 
		array_push($errors, "Phone number is required"); 
	}

     if (empty($creditcardnr)) { 
		array_push($errors, "Creditcard number is required"); 
	}

	
	// register billing info if there are no errors
	if (count($errors) == 0) {

		 if ($row['total_rows'] > 0) {
			echo $row['total_rows'];
        // update the existing row
		$query = "UPDATE billing SET address=?, zipcode=?, city=?, phonenumber=?, creditcardnr=? WHERE cartid=?";
		$stmt = mysqli_prepare($db, $query);
		mysqli_stmt_bind_param($stmt, "ssssss", $address, $zipcode, $city, $phonenumber, $creditcardnr, $cart_id);
		mysqli_stmt_execute($stmt);
		//setSessionBilling ($cart_id);

  	} else {

		$query = "INSERT INTO billing (cartid, customerid, address, zipcode, city, phonenumber, creditcardnr) 
				  VALUES(?, ?, ?, ?, ?, ?, ?)";
			$stmt = mysqli_prepare($db, $query);
			mysqli_stmt_bind_param($stmt, "sssssss", $cart_id, $customer_id, $address, $zipcode, $city, $phonenumber, $creditcardnr);
			mysqli_stmt_execute($stmt);
			//setSessionBilling ($cart_id);
			//$_SESSION['user'] = getUserById($logged_in_user_id); // put logged in user in session
			//$_SESSION['success']  = "Billing info created!"; 

  }
	if(mysqli_stmt_error($stmt)) {
		printf("Error message: %s\n", mysqli_stmt_error($stmt));
		} 

header("location: checkout.php");
exit();	
		}
	}

	if (isset($_POST['prevbilling_btn'])) {
		header("location: cart.php");
	}

function getAddress($billing_id){
	global $db;
	$query = "SELECT address FROM billing WHERE id='$billing_id'";
	$result_query= mysqli_query($db, $query);
	if ($result_query && mysqli_num_rows($result_query) > 0){
		$row = mysqli_fetch_assoc($result_query);
		$address = $row['address'];
		return $address;
	}else{
		return "";      
	}
}

function getZipcode($billing_id){
	global $db;
	$query = "SELECT zipcode FROM billing WHERE id='$billing_id'";
	$result_query= mysqli_query($db, $query);
	if ($result_query && mysqli_num_rows($result_query) > 0){
		$row = mysqli_fetch_assoc($result_query);
		$zipcode = $row['zipcode'];
		return $zipcode;
	}else{
		return "";      
	}
}

function getCity($billing_id){
	global $db;
	$query = "SELECT city FROM billing WHERE id='$billing_id'";
	$result_query= mysqli_query($db, $query);
	if ($result_query && mysqli_num_rows($result_query) > 0){
		$row = mysqli_fetch_assoc($result_query);
		$city = $row['city'];
		return $city;
	}else{
		return "";      
	}
}

function getPhoneNumber($billing_id){
	global $db;
	$query = "SELECT phonenumber FROM billing WHERE id='$billing_id'";
	$result_query= mysqli_query($db, $query);
	if ($result_query && mysqli_num_rows($result_query) > 0){
		$row = mysqli_fetch_assoc($result_query);
		$phonenumber = $row['phonenumber'];
		return $phonenumber;
	}else{
		return "";      
	}
}

function getCreditCardnr($billing_id){
	global $db;
	$query = "SELECT creditcardnr FROM billing WHERE id='$billing_id'";
	$result_query= mysqli_query($db, $query);
	if ($result_query && mysqli_num_rows($result_query) > 0){
		$row = mysqli_fetch_assoc($result_query);
		$creditcardnr = $row['creditcardnr'];
		return $creditcardnr;
	}else{
		return "";      
	}
}

function getBillingId($order_id){
	global $db;
	$query = "SELECT billingid FROM order WHERE id='$order_id'";
	$result_query= mysqli_query($db, $query);
	if ($result_query && mysqli_num_rows($result_query) > 0){
		$row = mysqli_fetch_assoc($result_query);
		$billing_id = $row['billingid'];
		return $billing_id;
	}else{
		return "";  
	}
}
/*
function setSessionBilling ($cart_id) {
    global $db;
    $query_order = "SELECT id FROM billing WHERE cartid='$cart_id'" ;
    $result_q_b_id = mysqli_query($db, $query_order);
    $row2 = mysqli_fetch_assoc($result_q_b_id);
    $order_id_int = intval($row2['id']);
    $_SESSION['billing_id'] = $billing_id_int;
    $billing_id = $_SESSION['billing_id'];
    $billing_id_int = intval($billing_id); 
} */