

<?php
session_start();
// Include the server.php file
include('server.php');

// Check if the login button was pressed
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Check if the credentials are valid using the check_credentials function
    if (check_credentials($username, $password) == true) {
		$_SESSION['loggedin'] = true;
  
  		$_SESSION['username'] = $username;
        //echo password_hash($password, PASSWORD_DEFAULT);

        header('Location: index.php');
        exit;
    } else {
        // Display an error message if the credentials are not valid
        echo '<script>alert("Incorrect username or password");</script>';;
    }
}

?>



<!DOCTYPE html>
<html>
<head>
	<div class="header">
		<h1><span>The Fellas Calendar</span></h1>
	</div>
	<title>Login</title>
	<link rel="stylesheet" href="css/login.css">
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


