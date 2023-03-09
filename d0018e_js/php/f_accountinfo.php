<?php 
session_start();
include('/var/www/d0018e_js/php/f_login.php');

// variable declaration
$username = "";
$email    = "";
$errors   = array(); 

if (isset($_POST['accupdate_btn'])) {
	accupdate();
}

function accupdate(){
	global $db, $errors;

	// receive all input values from the form. Call the e() function
    // defined below to escape form values
	$username    =  $_POST['username'];
	$firstname  =  $_POST['firstname'];
	$lastname  =  $_POST['lastname'];
	$email       =  $_POST['email'];
	//$password_old  =  $_POST['password_old'];
	$password_1  =  $_POST['password_1'];
	$password_2  =  $_POST['password_2'];


$q_username_db = "SELECT * FROM customer WHERE username=? LIMIT 1";
$q_email_db = "SELECT * FROM customer WHERE email=? LIMIT 1";
$stmt_username = mysqli_prepare($db, $q_username_db);
$stmt_email = mysqli_prepare($db, $q_email_db);
mysqli_stmt_bind_param($stmt_username, "s", $username);
mysqli_stmt_bind_param($stmt_email, "s", $email);
mysqli_stmt_execute($stmt_username);
$res_username_db = mysqli_stmt_get_result($stmt_username);
mysqli_stmt_free_result($stmt_username); // free the result set
mysqli_stmt_execute($stmt_email);
$res_email_db = mysqli_stmt_get_result($stmt_email);
mysqli_stmt_free_result($stmt_email); // free the result set

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
  if (empty($password_old)) { 
	array_push($errors, "Previous Password is required"); 
}
	if (empty($password_1)) { 
		array_push($errors, "Password is required"); 
	}
	if ($password_1 != $password_2) {
		array_push($errors, "The two passwords do not match");
	}

	if (count($errors) == 0) {
		$password = md5($password_1);//encrypt the password before saving in the database

		$customer_id = $_SESSION['customerId'];

		$query_c = "SELECT * FROM customer WHERE id=? AND password=? LIMIT 1";
		$stmt = mysqli_prepare($db, $query_c);
		mysqli_stmt_bind_param($stmt, "ss", $customer_id, $password_old);
		mysqli_stmt_execute($stmt);
		$results_c = mysqli_stmt_get_result($stmt);

		if (mysqli_num_rows($results_c) == 1) { // customer found

			$query = "UPDATE customer SET username=?, password=?, firstname=?, lastname=?, email=? WHERE id=?";
			$stmt = mysqli_prepare($db, $query);
			mysqli_stmt_bind_param($stmt, "sssss", $username, $password, $firstname, $lastname, $email, $customer_id);
			mysqli_stmt_execute($stmt);

			header('location: accountinfo.php');
			exit();	

		}
	}
}