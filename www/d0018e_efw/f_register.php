<?php 
session_start();

// connect to database
$db = mysqli_connect('localhost', 'root', 'password123', 'd0018e_db');

// variable declaration
$username = "";
$email    = "";
$errors   = array(); 

// call the register() function if register_btn is clicked
if (isset($_POST['register_btn'])) {
	register();
}

// REGISTER USER
function register(){
	// call these variables with the global keyword to make them available in function
	global $db, $errors, $username, $email, $firstname, $lastname;

	// receive all input values from the form. Call the e() function
    // defined below to escape form values
	$username    =  e($_POST['username']);
  $firstname  =  e($_POST['firstname']);
  $lastname  =  e($_POST['lastname']);
	$email       =  e($_POST['email']);
	$password_1  =  e($_POST['password_1']);
	$password_2  =  e($_POST['password_2']);

$q_username_db = "SELECT * FROM customer WHERE username='$username'";
$q_email_db = "SELECT * FROM customer WHERE email='$email'";
$res_username_db = mysqli_query($db, $q_username_db);
$res_email_db = mysqli_query($db, $q_email_db);

	// form validation: ensure that the form is correctly filled
	if (empty($username)) { 
		array_push($errors, "Username is required"); 
	}
  if (mysqli_num_rows($res_username_db) > 0){
    array_push($errors, "Username is already taken"); 
  }
  if (empty($firstname)) { 
		array_push($errors, "First name is required"); 
	}
  if (empty($lastname)) { 
		array_push($errors, "Last name is required"); 
	}
	if (empty($email)) { 
		array_push($errors, "Email is required"); 
	}
  if (mysqli_num_rows($res_email_db) >0){
    array_push($errors, "This email is already registered to an account");
  }
	if (empty($password_1)) { 
		array_push($errors, "Password is required"); 
	}
	if ($password_1 != $password_2) {
		array_push($errors, "The two passwords do not match");
	}

	// register user if there are no errors in the form
	if (count($errors) == 0) {
		$password = md5($password_1);//encrypt the password before saving in the database

			$query = "INSERT INTO customer (username, password, firstname, lastname, email) 
					  VALUES('$username', '$password', '$firstname', '$lastname', '$email')";
			mysqli_query($db, $query);
		//	$_SESSION['success']  = "New customer successfully created!!";
		//	header('location: home.php');

			// get id of the created user
			$logged_in_user_id = mysqli_insert_id($db);

			$_SESSION['user'] = getUserById($logged_in_user_id); // put logged in user in session
			$_SESSION['success']  = "New customer successfully created. You are now logged in";
			header("location: shop.php");
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