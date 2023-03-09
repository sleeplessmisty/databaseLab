<?php 
session_start();
include('/var/www/d0018e_js/php/f_review.php');

// variable declaration
$name = "";
$errors	= array(); 

// call the addProduct() function if product_btn is clicked
if (isset($_POST['addproduct_btn'])) {
	addProduct();
}

// REGISTER PRODUCT
function addProduct(){
	// call these variables with the global keyword to make them available in function
	global $db, $name, $errors;

	// receive all input values from the form. Call the e() function
    // defined below to escape form values
    $name    =  e($_POST['name']);
    $price   =  e($_POST['price']);
    $size    =  e($_POST['size']);
	$color   =  e($_POST['color']);
	$imgurl  =  e($_POST['imgurl']);
	$quantity  =  e($_POST['quantity']);
    //$price   = INT( $price );

	$q_name_db = "SELECT * FROM product WHERE name='$name'";
	$res_name_db = mysqli_query($db, $q_name_db);
	
	// form validation: ensure that the form is correctly filled
	if (empty($name)) { 
		array_push($errors, "Name is required"); 
	}
  	if (mysqli_num_rows($res_name_db) > 0){
    array_push($errors, "Product name is already taken"); 
  	}
  	if (empty($price)) { 
		array_push($errors, "Price is required"); 
	}
  	if (empty($size)) { 
		array_push($errors, "Size is required"); 
	}
	if (empty($color)) { 
		array_push($errors, "Color is required"); 
	}
    if (empty($imgurl)) { 
		array_push($errors, "Image url is required"); 
	}
	if (empty($quantity)) { 
		array_push($errors, "Quantity is required"); 
	}

	// add product if there are no errors in the form
	if (count($errors) == 0) {
		$query = "INSERT INTO product (name, price, size, color, imgurl, quantity) 
					VALUES('$name', '$price', '$size', '$color', '$imgurl', '$quantity')";
		mysqli_query($db, $query);
		$_SESSION['success']  = "New product successfully created!!";
		header("location: inventory.php");
		exit();	
	}
}

if ($_POST['action'] == 'edit' && $_POST['id']) {	
	$updateField='';
	if(isset($_POST['name'])) {
		$updateField.= "name='".$_POST['name']."'";
	}if(isset($_POST['price'])) {
		$updateField.= "price='".$_POST['price']."'";
	}if(isset($_POST['size'])) {
		$updateField.= "size='".$_POST['size']."'";
	}if(isset($_POST['color'])) {
		$updateField.= "color='".$_POST['color']."'";
	}if(isset($_POST['imgurl'])) {
		$updateField.= "imgurl='".$_POST['imgurl']."'";
	}if(isset($_POST['quantity'])) {
		$updateField.= "quantity='".$_POST['quantity']."'";
	}if(isset($_POST['active'])) {
		$updateField.= "active='".$_POST['active']."'";
	}
	
	if($updateField && $_POST['id']) {
		$sqlQuery = "UPDATE product SET $updateField WHERE id ='" . $_POST['id'] . "'";	
		mysqli_query($db, $sqlQuery) or die("database error:". mysqli_error($db));	
		$data = array(
			"message"	=> "Record Updated",	
			"status" => 1
		);
		echo json_encode($data);		
	}
}
/*if ($_POST['action'] == 'delete' && $_POST['id']) {
	$sqlQuery = "UPDATE product SET active = '0' WHERE id='" . $_POST['id'] . "'";	
	header("Refresh:0");
	mysqli_query($db, $sqlQuery) or die("database error:". mysqli_error($db));	
	$data = array(
		"message"	=> "Record Deleted",	
		"status" => 1

	);
	echo json_encode($data);	
}*/
if ($_POST['action'] == 'delete' && $_POST['id']) {
	$sqlQuery = "DELETE FROM product WHERE id='" . $_POST['id'] . "'";	
	header("Refresh:0");
	mysqli_query($db, $sqlQuery) or die("database error:". mysqli_error($db));	
	$data = array(
		"message"	=> "Record Deleted",	
		"status" => 1

	);
	echo json_encode($data);	
}

if (isset($_POST['product_pressed'])) {
	$product_id = $_POST['product_pressed'];
	$_SESSION['currentproduct']  = $product_id;
	header("location: productinfo.php");
	exit();	
}
