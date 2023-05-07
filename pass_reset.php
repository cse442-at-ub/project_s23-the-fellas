

<?php
// Include the server.php file
include('pass_reset_request.php');

$questions = get_questions($_SESSION['username']);

// Check if the login button was pressed
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['answer_1']) && isset($_POST['answer_2'])) {
    $username = $_SESSION['username'];
    $answer_1 = $_POST['answer_1'];
	$answer_2 = $_POST['answer_2'];
    
    // Check if the credentials are valid using the check_credentials function
    if (check_questions_and_answers($username, $answer_1, $answer_2) == true) {
		$_SESSION['loggedin'] = true;
  
        //echo password_hash($password, PASSWORD_DEFAULT); // get hashed passwords using PASSWORD_DEFAULT algorithm

        header('Location: pass_reset_submission.html');
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
	<form action="pass_reset.php" method="POST">
		<label for="username"><?php echo $questions[0]; ?></label>
		<input type="text" name="answer_1" id="answer_1" required><br><br>
		<label for="username"><?php echo $questions[1]; ?></label>
		<input type="text" name="answer_2" id="answer_2" required><br><br>
        <a href="login.php">Return to log in</a>
		<input type="submit" value="Submit">
	</form>
	
</body>
</html>