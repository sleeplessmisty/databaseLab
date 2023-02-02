<?php 
session_start();

// connect to database
$db = mysqli_connect('localhost', 'root', 'password123', 'd0018e_db');

// variable declaration
$username = "";
$email    = "";
$errors   = array(); 

// call the register() function if register_btn is clicked
if (isset($_POST['login_btn'])) {
	login();
}

    // LOGIN USER
function login(){
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

		$query_c = "SELECT * FROM customer WHERE username='$username' AND password='$password' LIMIT 1";
        $query_a = "SELECT * FROM admin WHERE username='$username' AND password='$password' LIMIT 1";
		$results_c = mysqli_query($db, $query_c);
        $results_a = mysqli_query($db, $query_a);

		if (mysqli_num_rows($results_c) == 1) { // customer found
			$logged_in_user = mysqli_fetch_assoc($results_c);
			$_SESSION['user'] = $logged_in_user;
			$_SESSION['userType'] = 'customer';
			$_SESSION['success']  = "You are now logged in";
				header('location: shop.php');
                exit();
			}
        if(mysqli_num_rows($results_a) == 1){ // admin found
            $logged_in_user = mysqli_fetch_assoc($results_a);
			$_SESSION['user'] = $logged_in_user;
			$_SESSION['userType'] = 'admin';
			$_SESSION['success']  = "You are now logged in";
				header('location: admin.php');
                exit();
		}else {
			array_push($errors, "Wrong username/password combination");
		}
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
	if (isset($_SESSION['user'])) {
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