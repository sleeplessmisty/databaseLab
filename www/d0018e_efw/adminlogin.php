<?php include('f_login.php') ?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
	<title>Registration system PHP and MySQL</title>
</head>
<body>
<div class="header">
	<h2>Admin login</h2>
</div>
<form method="post" action="adminlogin.php">
<?php echo display_error(); ?>
	<div class="input-group">
		<label>Username</label>
		<input type="text" name="username" value="<?php echo $username; ?>">
	</div>
	<div class="input-group">
		<label>Password</label>
		<input type="password" name="password" value="<?php echo $password; ?>">
	</div>
	<div class="input-group">
		<button type="submit" class="btn" name="login_btn" value="<?php echo $login_btn; ?>">Sign in</button>
	</div>
</form>
</body>
</html>