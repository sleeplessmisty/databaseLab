<?php include('f_register.php') ?>
<!DOCTYPE html>
<html>
<head>
	<title>Registration system PHP and MySQL</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="header">
	<h2>Register a new Customer<h2>
</div>
<form method="post" action="registercustomer.php">
<?php echo display_error(); ?>
	<div class="input-group">
		<label>Username</label>
		<input type="text" name="username" value="<?php echo $username; ?>">
	</div>
    <div class="input-group">
		<label>First name</label>
		<input type="text" name="firstname" value="<?php echo $firstname; ?>">
	</div>
    <div class="input-group">
		<label>Last name</label>
		<input type="text" name="lastname" value="<?php echo $lastname; ?>">
	</div>
	<div class="input-group">
		<label>Email</label>
		<input type="email" name="email" value="<?php echo $email; ?>">
	</div>
	<div class="input-group">
		<label>Password</label>
		<input type="password" name="password_1" value="<?php echo $password_1; ?>">
	</div>
	<div class="input-group">
		<label>Confirm password</label>
		<input type="password" name="password_2" value="<?php echo $password_2; ?>">
	</div>
	<div class="input-group">
		<button type="submit" class="btn" name="register_btn"  value="<?php echo $register_btn; ?>">Register</button>
	</div>
</form>
</body>
</html>