<?php 
//If logged in, sent to homepage
if ($_SESSION['loggedin'] = true) {
    echo file_get_contents("header.html");
    include("ProjectPHP/Calendar.php");
}


//If not logged in, sent to login page
else {
    
    echo file_get_contents("login.php");
}