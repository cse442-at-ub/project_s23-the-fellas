

<?php
session_set_cookie_params(0); // configure session cookies to be destroyed when the browser closes
session_start();
// Include the server.php file
include('server.php');

// Check if the login button was pressed
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['username']) && isset($_POST['email'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    
    // Check if the credentials are valid using the check_credentials function
    if (check_credentials_email($username, $email) == true) {

  		$_SESSION['username'] = $username;
        //echo password_hash($password, PASSWORD_DEFAULT); // get hashed passwords using PASSWORD_DEFAULT algorithm

        header('Location: pass_reset.php');
        exit;
    } else {
        // Display an error message if the credentials are not valid
        echo '<script>alert("Incorrect username or password");</script>';;
    }
}

?>