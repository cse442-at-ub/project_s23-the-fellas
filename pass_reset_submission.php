

<?php
// Include the server.php file
include('pass_reset.php');

$questions = get_questions($_SESSION['username']);

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Redirect to the login page
    header('Location: login.php');
    exit; // Exit the script
}

// Check if the login button was pressed
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['password']) && isset($_POST['confirm_password'])) {
    $username = $_SESSION['username'];
    $password = $_POST['password'];
	$confirm_password = $_POST['confirm_password'];
    if ($_POST['password'] != $_POST['confirm_password']){
		// Passwords do not match
		echo '<script>alert("The passwords do not match!");</script>';
		echo file_get_contents("pass_reset_submission.html");
	}
    else{
		change_password($username, $password);
		unset($_SESSION["username"]);
		unset($_SESSION["loggedin"]);
		unset($_POST["password"]);
		header('Location: login.php');
	}
   
}

?>
