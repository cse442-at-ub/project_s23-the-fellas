<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//The login functionality, checks if username and password exists in the database
//Passwords are hashed and salted
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

//Returns the entire array of events for a given user
function arrayOfEvents($username) {
  $db = mysqli_connect("oceanus.cse.buffalo.edu:3306", "jtsang3", "50301665", "cse442_2023_spring_team_c_db");
  if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
  }
  $sql = "SELECT * FROM events WHERE userID = '$username'";
  $result = mysqli_query($db, $sql);
  $events = array();
  while ($row = mysqli_fetch_assoc($result)) {
    $events[] = $row;
  }
  mysqli_close($db);
  return $events;

}

//Function for adding an event to the database
function addEvent($username, $title, $dateTime, $color) {

  $db = mysqli_connect("oceanus.cse.buffalo.edu:3306", "jtsang3", "50301665", "cse442_2023_spring_team_c_db");
  if (!$db) {
      die("Connection failed: " . mysqli_connect_error());
  }
  $sql = "INSERT INTO events (userID, title, dateTime, color) VALUES ('$username', '$title', '$dateTime', '$color')";
  $result = mysqli_query($db, $sql);
  if (!$result) {
      die("Error adding event: " . mysqli_error($db));
  }
  mysqli_close($db);

}


//Just used to delete some incorrectly formed items (keeping for future reference)
function deleteTestEvents() {
  $db = mysqli_connect("oceanus.cse.buffalo.edu:3306", "jtsang3", "50301665", "cse442_2023_spring_team_c_db");
  if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
  }

  $sql = "DELETE FROM events WHERE userID='devincle'";
  $result = mysqli_query($db, $sql);

  if (!$result) {
    die("Error deleting events: " . mysqli_error($db));
  }

  mysqli_close($db);
}


//Function for the side bar code
function loadTodaysEvents($username, $date) {
  $db = mysqli_connect("oceanus.cse.buffalo.edu:3306", "jtsang3", "50301665", "cse442_2023_spring_team_c_db");
  if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
  }
  
  $sql = "SELECT * FROM events WHERE dateTime = '$date' AND userID = '$username'";
  $result = mysqli_query($db, $sql);
  $events = array();
  while ($row = mysqli_fetch_assoc($result)) {
    $events[] = $row;
  }
  mysqli_close($db);
  return $events;
}



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Get the raw POST data
  $raw_data = file_get_contents("php://input");

  // Decode the JSON data
  $json_data = json_decode($raw_data, true);
  echo "<script>console.log('PHP: " . $raw_data . "');</script>";

  // Get the action from the decoded JSON data
  $action = $json_data['action'];

  if ($action == 'updateEvent') {
      $title = $json_data['title'];
      $dateTime = $json_data['dateTime'];
      $color = $json_data['color'];
      $eventID = $json_data['eventID'];

      echo "Calling updateEvent with the following data: ";
      echo "Title: $title, DateTime: $dateTime, Color: $color, EventID: $eventID";
  
      // Call the updateEvent function with the data
      // addEvent("devincle", $title, $dateTime, $color);
      updateEvent($title, $dateTime, $color, $eventID);
  }
}
function updateEvent($title, $dateTime, $color, $eventID) {
  $db = mysqli_connect("oceanus.cse.buffalo.edu:3306", "jtsang3", "50301665", "cse442_2023_spring_team_c_db");
  if (!$db) {
      die("Connection failed: " . mysqli_connect_error());
  }

  $title = mysqli_real_escape_string($db, $title);
  $dateTime = mysqli_real_escape_string($db, $dateTime);
  $color = mysqli_real_escape_string($db, $color);
  $eventID = mysqli_real_escape_string($db, $eventID);

  $sql = "UPDATE events SET title = '$title', dateTime = '$dateTime', color = '$color' WHERE eventID = '$eventID'";
  $result = mysqli_query($db, $sql);

  if ($result) {
      echo "Event with ID $eventID has been updated successfully.";
  } else {
      echo "Error updating event with ID $eventID: " . mysqli_error($db);
  }

  mysqli_close($db);
}


?>