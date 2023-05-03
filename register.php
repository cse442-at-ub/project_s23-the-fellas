<?php
// Change this to your connection info.
$con = mysqli_connect("oceanus.cse.buffalo.edu:3306", "devincle", "50343841", "cse442_2023_spring_team_c_db");
if (mysqli_connect_errno()) {
	// If there is an error with the connection, stop the script and display the error.
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}


// We need to check if the account with that username exists.
if ($stmt = $con->prepare('SELECT * FROM user_accounts WHERE username = ?')) {
	// Bind parameters (s = string, i = int, b = blob, etc), hash the password using the PHP password_hash function.
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();
	$stmt->store_result();
	// Store the result so we can check if the account exists in the database.
	if ($stmt->num_rows > 0) {
		// Username already exists
		echo '<script>alert("Username exists, please choose another!");</script>';
		echo file_get_contents("register.html");
	} else {
		// Username doesn't exists, insert new account
        if ($stmt = $con->prepare('INSERT INTO user_accounts (username, password, email) VALUES (?, ?, ?)')) {
            // We do not want to expose passwords in our database, so hash the password and use password_verify when a user logs in.
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $stmt->bind_param('sss', $_POST['username'], $password, $_POST['email']);
            $stmt->execute();
            echo '<script>alert("You have successfully registered! You can now login!");</script>';
			include("login.php");
        } else {
            // Something is wrong with the SQL statement, so you must check to make sure your accounts table exists with all 3 fields.
            echo 'Could not prepare statement!';
        }
	}
	$stmt->close();
} else {
	// Something is wrong with the SQL statement, so you must check to make sure your accounts table exists with all 3 fields.
	echo 'Could not prepare statement!';
}
$con->close();
?>
