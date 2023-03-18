<?php



function check_credentials($username, $password) {
    // Connect to the database
    $db = mysqli_connect("oceanus.cse.buffalo.edu:3306", "devincle", "50343841", "cse442_2023_spring_team_c_db");
    
    // Check if the connection was successful
    if (!$db) {
      die("Connection failed: " . mysqli_connect_error());
    }
    
    // Sanitize the input to prevent SQL injection attacks
    $username = mysqli_real_escape_string($db, $username);
    $password = mysqli_real_escape_string($db, $password);
    
    // Query the database to check if the credentials are valid
    $query = "SELECT * FROM user_accounts WHERE username='$username' AND password='$password'";
    $result = mysqli_query($db, $query);
    
    // Check if there was an error with the query
    if (!$result) {
      die("Query failed: " . mysqli_error($db));
    }
    
    // Check if the query returned any rows
    if (mysqli_num_rows($result) > 0) {
      // The credentials are valid
      return true;
    } else {
      // The credentials are not valid
      return false;
    }
    
    // Close the database connection
    mysqli_close($db);
}



?>