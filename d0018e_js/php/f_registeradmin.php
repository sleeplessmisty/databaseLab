<?php 
session_start();

// connect to database
include('/var/www/d0018e_js/php/f_login.php');
//$db = mysqli_connect('localhost', 'root', 'D0018E_ElvJenDan!', 'd0018e_db');

// variable declaration
$username = "";
$errors   = array(); 

// call the registeradmin() function if registeradmin_btn is clicked
if (isset($_POST['registeradmin_btn'])) {
	registeradmin();
}

// REGISTER ADMIN
function registeradmin(){
	// call these variables with the global keyword to make them available in function
	global $db, $username, $errors;

	// receive all input values from the form. Call the e() function
    // defined below to escape form values
	$username    =  e($_POST['username']);
	$password_1  =  e($_POST['password_1']);
	$password_2  =  e($_POST['password_2']);

$q_username_db = "SELECT * FROM admin WHERE username='$username'";
$res_username_db = mysqli_query($db, $q_username_db);

	// form validation: ensure that the form is correctly filled
	if (empty($username)) { 
		array_push($errors, "Username is required"); 
	}

    if (mysqli_num_rows($res_username_db) > 0){
    array_push($errors, "Username is already taken"); 
    }

    if (empty($password_1)) { 
		array_push($errors, "Password is required"); 
	}

	if ($password_1 != $password_2) {
		array_push($errors, "The two passwords do not match");
	}

	// register new admin if there are no errors in the form
	if (count($errors) == 0) {
		$password = md5($password_1);//encrypt the password before saving in the database

			$query = "INSERT INTO admin (username, password) 
					  VALUES('$username', '$password')";
			mysqli_query($db, $query);

			//$_SESSION['user'] = getUserById($logged_in_user_id); // put logged in user in session
			$_SESSION['success']  = "New Admin successfully created!";
			header("location: admin.php");
			exit();	
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