<?php 
session_start(); // Start the session

// Check if the 'loggedin' variable is not set or has a value of false
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Redirect to the login page
    header('Location: login.php');
    exit; // Exit the script
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
      if(isset($_POST['themeList'])){
        $theme = $_POST['themeList'];
        if($theme == "Dark"){
          echo '<link rel="stylesheet" href="css/darktheme.css">';
        }
      }
    ?>
  </head>
  <body>
    <div id="login-container">
        <button type="button" onclick="location.href='index.php';">Back</button>
        <button type="button" onclick="location.href='testing.php';">Testing</button>


      <form method="POST">
      <img id="profilePic" src="data/pfp.png" alt="Profile Picture" width="150" onclick="document.getElementById('fileInput').click();">
      <input type="file" id="fileInput" style="display: none;" onchange="setProfilePic(this);">
        <label>About me:</label>
       
        <textarea id="bio" name="bio" placeholder="Enter your bio..." readonly></textarea>
        <br>
        <button type="button" onclick="toggleBioEdit()" class="bio-edit-btn">Edit Bio</button>

        <script>
        function setProfilePic(input) {
          if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
              document.getElementById('profilePic').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
          }
        }
        function toggleBioEdit() {
          var bio = document.getElementById("bio");
          if (bio.readOnly) {
            bio.readOnly = false;
            bio.style.border = "1px solid #ccc";
            bio.style.background = "#fff";
          } else {
            bio.readOnly = true;
            bio.style.border = "none";
            bio.style.background = "none";
          }
        }
        </script>
        <br><br>
        <label >Login Details:</label>
        <input type="text" id="username" name="username" placeholder="Change Username...">
        <br><br>
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