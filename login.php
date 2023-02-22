

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST' && ($_POST['username'] == 'devin') && ($_POST['password'] == 'password')) {
    header('Location: home.php');
    exit;
    
}
?>



<!DOCTYPE html>
<html>
<head>
	<div class="header">
		<h1><span>The Fellas Calendar</span></h1>
	</div>
	<title>Login</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>	
	<form action="login.php" method="POST">
		<label for="username">Username:</label>
		<input type="text" name="username" id="username" required><br><br>
		<label for="password">Password:</label>
		<input type="password" name="password" id="password" required><br><br>
		<input type="submit" value="Login">
	</form>
</body>
</html>


