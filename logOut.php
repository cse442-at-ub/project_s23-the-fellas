<?php
session_start(); // Start the session



// Unset all of the session variables
$_SESSION['loggedin'] = false; 

//Set username to empty
$_SESSION['username'] = "";

// Redirect to the login page
header('Location: login.php'); 




exit; // Exit the script
?>
