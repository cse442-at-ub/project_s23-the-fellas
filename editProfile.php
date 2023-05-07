<?php 
session_start(); // Start the session

include 'server.php';


// Check if the 'loggedin' variable is not set or has a value of false
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Redirect to the login page
    header('Location: login.php');
    exit; // Exit the script
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['password'])) {
  $username = $_SESSION['username'];
  $password = $_POST['password'];
  if (empty($password)) {
  }
  else {
    change_password($username, $password);
    unset($_SESSION["username"]);
    unset($_SESSION["loggedin"]);
    unset($_POST["password"]);
    header('Location: login.php');
  }
  
if(isset($_COOKIE['theme'])){
  $theme = decryptCookie($_COOKIE['theme']);
  if($theme == "dark"){
    echo '<link rel="stylesheet" href="css/darktheme.css">';
  }
}
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['themeList'])) {
  echo "<script>console.log('themelist set');</script>";
  $theme = $_POST['themeList'];
  if($theme == "Dark"){
    setcookie("theme", encryptCookie('dark'), time() + (86400 * 30), "/"); // set cookie for 30 days
  } else if ($theme == "Light") {
    setcookie("theme", encryptCookie('light'), time() + (86400 * 30), "/"); // set cookie for 30 days
  }
  unset($_POST['themeList']); 
  header('Location: ' . $_SERVER['PHP_SELF']);

}

?>



<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="css/profile.css">
    <?php
      if(isset($_COOKIE['theme'])){
        $theme = decryptCookie($_COOKIE['theme']);
        //print the theme:
        if($theme == "dark"){
          echo '<link rel="stylesheet" href="css/darktheme.css">';
        }
        else {
          echo '<link rel="stylesheet" href="css/profile.css">';
        }
      }
    ?>
  </head>
  <body>
    <div id="login-container">
        <button type="button" onclick="location.href='index.php';">Back</button>


      <form action="editProfile.php" method="POST">
        <!-- <label>About me:</label>
       
        <textarea id="bio" name="bio" placeholder="Enter your bio..." readonly></textarea>
        <br>
        <button type="button" onclick="toggleBioEdit()" class="bio-edit-btn">Edit Bio</button> -->


        <br><br>
        <label >Change Password:</label>
        <br>
        <input type="password" id="password" name="password" placeholder="Change Password...">
        <label for="themeList">Select a theme:</label>
        <select id="themeList" name="themeList">
            <option value="Default">Default</option>
            <option value="Dark">Dark</option>
            <option value="Light">Light</option>
          
        </select>
        <br><br>
        <label >Classes:</label>
        <ul>
            <li>CSE442</li>
            <li>CSE306</li>
            <li>CSE312</li>
            <li>NTR108</li>
            <li>DAC104</li>
          </ul>
        <br><br>

        <button type="submit">Save</button>
      </form>
    </div>
  </body>
</html>