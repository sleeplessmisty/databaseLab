<?php 
session_start();
include('/var/www/d0018e_js/php/f_billing.php');

// connect to database
//$datab = mysqli_connect('localhost', 'root', 'D0018E_ElvJenDan!', 'd0018e_db');

// variable declaration
$name = "";
$errors	= array(); 

if (isset($_POST['leaveReview_btn'])) {
    global $review;
    $product_id = intval($_POST['leaveReview_btn']);
    $grade = intval($_POST['grade']);
    /*$review = $_POST['review'];
    $text_review = "\$review = \"$review\";";
	leaveReview($product_id, $grade, $text_review);*/

    $review = $_POST['review'];
	leaveReview($product_id, $grade, $review);
}
function leaveReview($product_id, $grade, $review){
    global $db;
    global $review;
    $customer_id = $_SESSION['customerId'];
    $customer_id_int = intval($customer_id);
    $query_review = "INSERT INTO review (customerid, productid, grade, comment) 
        VALUES('$customer_id_int', '$product_id', '$grade', '$review')";
    if(mysqli_query($db, $query_review)) {

        $avg_grade = setAvggrade($product_id);
        $query_set_avggrade = "UPDATE product SET avggrade = '$avg_grade' WHERE id = '$product_id'";
        $result_q_set_avggrade = mysqli_query($db, $query_set_avggrade);
        header("location: ordercomplete.php");
        exit(); 
    } else {
        echo "Error: " . mysqli_error($db);
    }   
};

function totalReviews($product_id) {
	global $db;
    $query = "SELECT COUNT(*) FROM review WHERE productid='$product_id'";
	$result = mysqli_query($db, $query);
	if ($result && mysqli_num_rows($result) > 0) {
        return intval(mysqli_fetch_array($result)[0]);
    } else {
        return 0;
      }
}

function setAvggrade($product_id) {
	global $db;
	$query_grade = $sql = "SELECT AVG(grade) as avg_grade FROM review WHERE productid = $product_id";
    $result_query_grade= mysqli_query($db, $query_grade);
    if (!$result_query_grade) {
        echo "Error: " . mysqli_error($conn);
        exit();
      }
    $row = mysqli_fetch_assoc($result_query_grade);
	$avg_grade = $row['avg_grade'];
	return $avg_grade;
        
}

function hasReview($product_id) {
	global $db;
    $customer_id = $_SESSION['customerId'];
	$query = $sql = "SELECT * FROM review WHERE productid = $product_id AND customerid = $customer_id";
    $result_query= mysqli_query($db, $query);
    if(mysqli_num_rows($result_query) > 0){
        return TRUE;
        exit();
    }else{
        return FALSE;
        exit();
    }   
}

function getGrade($product_id) {
	global $db;
    $customer_id = $_SESSION['customerId'];
	$query_grade = "SELECT grade FROM review WHERE productid='$product_id' AND customerid = '$customer_id'";
    $result_query_grade= mysqli_query($db, $query_grade);
    if ($result_query_grade && mysqli_num_rows($result_query_grade) > 0){
        $row = mysqli_fetch_assoc($result_query_grade);
		$grade = $row['grade'];
		return $grade;
    }else{
        return 0;
    }       
}
function getGradeFromCustomerId($customer_id, $product_id) {
	global $db;
	$query_grade = "SELECT grade FROM review WHERE customerid = '$customer_id' AND productid='$product_id'";
    $result_query_grade= mysqli_query($db, $query_grade);
    if ($result_query_grade && mysqli_num_rows($result_query_grade) > 0){
        $row = mysqli_fetch_assoc($result_query_grade);
		$grade = $row['grade'];
		return $grade;
    }else{
        return 0;
    }       
}

function getReview($product_id){
    global $db;
    $query_getReview = "SELECT comment FROM review WHERE productid='$product_id'";
    $reviewResult = mysqli_query($db, $query_getReview);
    if ($reviewResult && mysqli_num_rows($reviewResult) > 0){
        return strval(mysqli_fetch_array($reviewResult)[0]);
    } else{
        return "";
    }
}

function getCustomerName($product_id, $comment){
    global $db;
    $query_getComment = "SELECT * FROM review WHERE productid='$product_id'";
    
}

function getUsernameFromCustomerId($customer_id) {
    global $db;
    $query = "SELECT username FROM customer WHERE id='$customer_id'";
    $username = mysqli_query($db, $query);
    if ($username && mysqli_num_rows($username) > 0){
        return mysqli_fetch_array($username)[0];
    } else{
        return 0;
    }  
}
function getReviewFromCustomerId($customer_id, $product_id) {
    global $db;
    $query = "SELECT comment FROM review WHERE customerid='$customer_id' AND productid = '$product_id'";
    $review = mysqli_query($db, $query);
    if ($review&& mysqli_num_rows($review) > 0){
        return mysqli_fetch_array($review)[0];
    } else{
        return 0;
    }  
}

function getQuantityOrder($order_id){
	global $db;
	$query = "SELECT cartid FROM `order` WHERE id='$order_id'";
	$result_query= mysqli_query($db, $query);
	if ($result_query && mysqli_num_rows($result_query) > 0){
		$row = mysqli_fetch_assoc($result_query);
		$cart_id = $row['cartid'];
		return $cart_id;
	}else{
		return NULL;      
	}
}

if (isset($_POST['leaveReview_btn_history'])) {
    global $review;
    $product_id = intval($_POST['leaveReview_btn_history']);
    $grade = intval($_POST['grade']);
    /*$review = $_POST['review'];
    $text_review = "\$review = \"$review\";";
	leaveReview($product_id, $grade, $text_review);*/

    $review = $_POST['review'];
	leaveReviewFromOrderHistory($product_id, $grade, $review);
}
function leaveReviewFromOrderHistory($product_id, $grade, $review){
    global $db;
    global $review;
    $customer_id = $_SESSION['customerId'];
    $customer_id_int = intval($customer_id);
    $query_review = "INSERT INTO review (customerid, productid, grade, comment) 
        VALUES('$customer_id_int', '$product_id', '$grade', '$review')";
    if(mysqli_query($db, $query_review)) {

        $avg_grade = setAvggrade($product_id);
        $query_set_avggrade = "UPDATE product SET avggrade = '$avg_grade' WHERE id = '$product_id'";
        $result_q_set_avggrade = mysqli_query($db, $query_set_avggrade);
        header("location: detailsreviews.php");
        exit(); 
    } else {
        echo "Error: " . mysqli_error($db);
    }   
};