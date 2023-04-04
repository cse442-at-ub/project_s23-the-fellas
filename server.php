<?php



function check_credentials($username, $password) {

    // Connect to the database
    $db = mysqli_connect("oceanus.cse.buffalo.edu:3306", "jtsang3", "50301665", "cse442_2023_spring_team_c_db");
    
    // Check if the connection was successful
    if (!$db) {
      die("Connection failed: " . mysqli_connect_error());
    }
    
    // Sanitize the input to prevent SQL injection attacks
    $username = mysqli_real_escape_string($db, $username);
    $password = mysqli_real_escape_string($db, $password);
    
    // Query the database to get data for user with username='$username'
    //$query = "SELECT * FROM user_accounts WHERE username='$username'";
    $query = "SELECT * FROM user_accounts WHERE username='$username'";
    $result = mysqli_query($db, $query);
    
    // Check if there was an error with the query
    if (!$result) {
      die("Query failed: " . mysqli_error($db));
    }


    $row = $result->fetch_assoc(); // parse the query result into an associative array.

    if (is_array($row)) {
        if (password_verify($password, $row['password'])) {
            // The credentials are valid
            return true;
        }
        else {
            // The credentials are not valid
            return false;
        }
    }
    
    // Close the database connection
    mysqli_close($db);
}



?>