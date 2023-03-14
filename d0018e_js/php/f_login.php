<?php 
session_start();
//uncomment for error checking
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// connect to database
$servername = "localhost";
$username = "root";
$password = "D0018E_ElvJenDan!";
$dbname = "d0018e_db";
$db = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());

// variable declaration
$username = "";
$email    = "";
$errors   = array(); 

// call the c_login function if c_login_btn is clicked
if (isset($_POST['c_login_btn'])) {
	c_login();
}

// call the a_login function if a_login_btn is clicked
if (isset($_POST['a_login_btn'])) {
	a_login();
}

function c_login(){
	global $db, $username, $errors;

	// grap form values
	$username = e($_POST['username']);
	$password = e($_POST['password']);

	// make sure form is filled properly
	if (empty($username)) {
		array_push($errors, "Username is required");
	}
	if (empty($password)) {
		array_push($errors, "Password is required");
	}

	// attempt login if no errors on form 
	if (count($errors) == 0) {
		$password = md5($password);

		//$query_c = "SELECT * FROM customer WHERE username='$username' AND password='$password' LIMIT 1";
		//$results_c = mysqli_query($db, $query_c);
		$query_c = "SELECT * FROM customer WHERE username=? AND password=? LIMIT 1";
		$stmt = mysqli_prepare($db, $query_c);
		mysqli_stmt_bind_param($stmt, "ss", $username, $password);
		mysqli_stmt_execute($stmt);
		$results_c = mysqli_stmt_get_result($stmt);

		if (mysqli_num_rows($results_c) == 1) { // customer found
			$logged_in_user = mysqli_fetch_assoc($results_c);
			$_SESSION['user'] = $logged_in_user;
			$_SESSION['userType'] = 'customer';
			$_SESSION['success']  = "You are now logged in";

			//get customer id when logged in and send to create cart
			/*$query_c_id = "SELECT id FROM customer WHERE username='$username' LIMIT 1";
			$res_c_id = mysqli_query($db, $query_c_id);
			$c_id = mysqli_fetch_array($res_c_id);
			$_SESSION['customerId'] = intval($c_id[0]);*/
			$stmt = mysqli_prepare($db, "SELECT id FROM customer WHERE username = ? LIMIT 1");
			mysqli_stmt_bind_param($stmt, "s", $username);
			mysqli_stmt_execute($stmt);
			$res_c_id = mysqli_stmt_get_result($stmt);
			$c_id = mysqli_fetch_array($res_c_id);
			$_SESSION['customerId'] = intval($c_id[0]);
			createCart($c_id[0]);

				header('location: shop.php');
                exit();
		
			}else{
				array_push($errors, "Wrong username/password combination");
			}	
		}
}

    // LOGIN USER
	function a_login(){
		global $db, $username, $errors;
	
		// grap form values
		$username = e($_POST['username']);
		$password = e($_POST['password']);
	
		// make sure form is filled properly
		if (empty($username)) {
			array_push($errors, "Username is required");
		}
		if (empty($password)) {
			array_push($errors, "Password is required");
		}
	
		// attempt login if no errors on form 
		if (count($errors) == 0) {
			$password = md5($password);
	
			//$query_a = "SELECT * FROM admin WHERE username='$username' AND password='$password' LIMIT 1";
			//$results_a = mysqli_query($db, $query_a);
			$stmt = mysqli_prepare($db, "SELECT * FROM admin WHERE username = ? AND password = ? LIMIT 1");
			mysqli_stmt_bind_param($stmt, "ss", $username, $password);
			mysqli_stmt_execute($stmt);
			$results_a = mysqli_stmt_get_result($stmt);
	
			if(mysqli_num_rows($results_a) == 1){ // admin found
				$logged_in_user = mysqli_fetch_assoc($results_a);
				$_SESSION['user'] = 'customer';
				$_SESSION['userType'] = 'admin';
				$_SESSION['success']  = "You are now logged in";

				$stmt = mysqli_prepare($db, "SELECT id FROM admin WHERE username = ? LIMIT 1");
				mysqli_stmt_bind_param($stmt, "s", $username);
				mysqli_stmt_execute($stmt);
				$res_a_id = mysqli_stmt_get_result($stmt);
				$a_id = mysqli_fetch_array($res_a_id);
				$_SESSION['admin_id'] = intval($a_id[0]);
				header('location: admin.php');
				exit();
			}else {
				array_push($errors, "Wrong username/password combination");
			}
		}
	}

// create cart for customer when logged in if not exist
function createCart($id){
    global $db;

    $query_id = "SELECT * FROM cart WHERE customerid='$id' AND status='active' LIMIT 1";
    $result_q_id = mysqli_query($db, $query_id);
    $id_int = intval($id);

    //there is already a cart for this, get cart id of customers current cart and add to session
    if (mysqli_num_rows($result_q_id) == 1){
        $row = mysqli_fetch_assoc($result_q_id);
        $cart_id_int = intval($row['id']);
        $_SESSION['cart_id'] = $cart_id_int;
        return;

    //create cart with customer id and set status as active
    }else{
        $query_cart = "INSERT INTO cart (customerid, status) VALUES('$id_int', 'active')";
        mysqli_query($db, $query_cart);
        $query_c_id = "SELECT id FROM cart WHERE customerid='$id' AND status='active' LIMIT 1";
        $result_q_c_id = mysqli_query($db, $query_c_id);
        $row = mysqli_fetch_assoc($result_q_c_id);
        $cart_id_int = intval($row['id']);
        $_SESSION['cart_id'] = $cart_id_int;
        return;
    }
}

// return user array from their id
function getUserById($id){
	global $db;
	$query = "SELECT * FROM customer WHERE id=" . $id;
	$result = mysqli_query($db, $query);

	$user = mysqli_fetch_assoc($result);
	return $user;
}

// escape string
function e($val){
	global $db;
	return mysqli_real_escape_string($db, trim($val));
}

function display_error() {
	global $errors;

	if (count($errors) > 0){
		echo '<div class="error">';
			foreach ($errors as $error){
				echo $error .'<br>';
			}
		echo '</div>';
	}
}	

function isLoggedIn()
{
	if (isset($_SESSION['userType'])) {
		return true;
	}else{
		return false;
	}
}

// log user out if logout button clicked
if (isset($_POST['logout_btn']))  {
	session_destroy();
	unset($_SESSION['user']);
	header("location: index.php");
}
function isAdmin()
{
	if (isset($_SESSION['user']) && $_SESSION['userType'] == 'admin' ) {
		return true;
	}else{
		return false;
	}
}
