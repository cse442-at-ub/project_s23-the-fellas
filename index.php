<?php 
//If logged in, sent to homepage
if ($_SESSION['loggedin'] = true) {
    echo file_get_contents("header.html");
    echo file_get_contents("homePage.php");
}


//If not logged in, sent to login page
else {
    
    echo file_get_contents("login.php");
}