<?php

//The login functionality, checks if username and password exists in the database
//Passwords are hashed and salted
function check_credentials($username, $password) {

    // Connect to the database
    $db = mysqli_connect("oceanus.cse.buffalo.edu:3306", "jtsang3", "50301665", "cse442_2023_spring_team_c_db");
    
    // Check if the connection was successful
    if (!$db) {
      die("Connection failed: " . mysqli_connect_error());
    }

    echo "Connection to database successful\n";
/*
    // Sanitize the input to prevent SQL injection attacks
    $username = mysqli_real_escape_string($db, $username);
    $password = mysqli_real_escape_string($db, $password);
    
    // Unprepared Query
    $query = "SELECT * FROM user_accounts WHERE username='$username'";
    $result = mysqli_query($db, $query);

    */
    // Use a prepared statement to get the data corresponding to the given username.
    $stmt = $db->prepare("SELECT * FROM user_accounts WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();

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
function arrayOfEvents($username)
{
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


    // Use a prepared statement to get the data corresponding to the given username.
    $stmt = $db->prepare("SELECT * FROM events WHERE userID = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();

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
  // Get the data from the POST request
  $action = $_POST['action'];
  if ($action == 'updateEvent') {
      $title = $_POST['title'];
      $dateTime = $_POST['dateTime'];
      $color = $_POST['color'];
      $eventID = $_POST['eventID'];

      // Call the updateEvent function with the data
      updateEvent($title, $dateTime, $color, $eventID);
  }
}
function updateEvent($title, $dateTime, $color, $eventID) {

  $db = mysqli_connect("oceanus.cse.buffalo.edu:3306", "jtsang3", "50301665", "cse442_2023_spring_team_c_db");
  if (!$db) {
      die("Connection failed: " . mysqli_connect_error());
  }
  

  // Prepare the SQL update statement
  $sql = "UPDATE events SET title = ?, dateTime = ?, color = ? WHERE eventID = ?";

  // Prepare the statement and bind the parameters
  if ($stmt = mysqli_prepare($db, $sql)) {
      mysqli_stmt_bind_param($stmt, "sssi", $title, $dateTime, $color, $eventID);

      // Execute the statement
      if (mysqli_stmt_execute($stmt)) {
          echo "Event with ID $eventID has been updated successfully.";
      } else {
          echo "Error updating event with ID $eventID: " . mysqli_stmt_error($stmt);
      }

      // Close the prepared statement
      mysqli_stmt_close($stmt);
  } else {
      echo "Error preparing the statement: " . mysqli_error($db);
  }

  // Close the database connection
  mysqli_close($db);
}

?>