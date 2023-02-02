<?php include('f_login.php') ?>
<!DOCTYPE html>
<html>
<head>
	<title>Homepage</title>
  <link rel="stylesheet" href="style.css">
</head>
<style>
  body {
    background-image: url('images/mugger.jpg');
    background-size: cover;
    background-repeat: no-repeat;
  }
  </style>
<body>

<div class="header">
	<h2>Welcome to muggle, login or create an account to start shopping!</h2>
</div>
<form method="post" action="index.php">
<?php echo display_error(); ?>
	<div class="input-group">
    <label for="uname">Username</label>
    <input type="text" placeholder="Enter Username" name="username" value ="<?php echo $username; ?>"required>
  </div>
  <div class="input-group">
    <label for="psw">Password</label>
    <input type="password" placeholder="Enter Password" name="password" value = "<?php echo $password; ?>"required>
  </div>
	<div class="input-group">
		<button type="submit" class="btn" name="login_btn" value = "<?php echo $login_btn; ?>">Login</button>
  </div>
	<div class="input-group">
		Not a member yet? <a href="registercustomer.php">Create user</a>
  </div>
  <div class="input-group">
		Are you an admin? <a href="adminlogin.php">Login as Admin</a>
	</div>
</form>
</body>
</html>
