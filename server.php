<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//The login functionality, checks if username and password exists in the database
//Passwords are hashed and salted
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
function arrayOfEvents($username) {
  $db = mysqli_connect("oceanus.cse.buffalo.edu:3306", "jtsang3", "50301665", "cse442_2023_spring_team_c_db");
  if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
  }
    $result = "";
    $events = "";
    
  // Use a prepared statement to get the data corresponding to the given username.
  if($username != "admin"){
    $stmt = $db->prepare("SELECT * FROM events WHERE userID = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result(); // get result of database query

    $events = array();

  while ($row = mysqli_fetch_assoc($result)) {
    $events[] = $row;
  }
  // Pulls Admin Events Into User Schedule
  $stmt = $db->prepare("SELECT * FROM events WHERE userID = 'admin'");
  $stmt->execute();

  $result = $stmt->get_result(); // get result of database query

  $events + array();
  while ($row = mysqli_fetch_assoc($result)) {
    $events[] = $row;
  }
}
  // Use a prepared statement to get the data corresponding to all usernames (ADMIN ROLE).
  elseif($username == "admin"){
    $stmt = $db->prepare("SELECT * FROM events");
    $stmt->execute();

    $result = $stmt->get_result(); // get result of database query

    $events = array();

    while ($row = mysqli_fetch_assoc($result)) {
      $events[] = $row;
    }
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

  /*
  $sql = "INSERT INTO events (userID, title, dateTime, color) VALUES ('$username', '$title', '$dateTime', '$color')";
  $result = mysqli_query($db, $sql);
  */

    // Use a prepared statement to add an event with the given parameters to the events table in the database.
    $stmt = $db->prepare("INSERT INTO events (userID, title, dateTime, color) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $title, $dateTime, $color);
    $stmt->execute();

    //$result = $stmt->get_result();

    /* Listen it works fine without this and I'm too tired and short on time to deal with this right now
  if (!$result) {
      die("Error adding event: " . mysqli_error($db));
  }
    */

  mysqli_close($db);

}

// Commented out for Sprint 3 grading
/*
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
*/


//Function for the side bar code
function loadTodaysEvents($username, $date) {
  echo "<script>console.log('LoadTodaysEvents Called: " . $username . $date . "');</script>";
  $db = mysqli_connect("oceanus.cse.buffalo.edu:3306", "jtsang3", "50301665", "cse442_2023_spring_team_c_db");
  if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
  }

  $result = "";
  $events = "";

  if($username != "admin"){
    // Use a prepared statement to get the data corresponding to the given username and time.
    $stmt = $db->prepare("SELECT * FROM events WHERE dateTime = ? AND userID = ?");
    $stmt->bind_param("ss", $date, $username);
    $stmt->execute();

    $result = $stmt->get_result();

  $events = array();

  while ($row = mysqli_fetch_assoc($result)) {
    $events[] = $row;
  }
  //Adds Admin Daily Events to sidebar
  $stmt = $db->prepare("SELECT * FROM events WHERE dateTime = ? AND userID = 'admin'");
  $stmt->bind_param("s", $date);
  $stmt->execute();

  $result = $stmt->get_result();

$events + array();

while ($row = mysqli_fetch_assoc($result)) {
  $events[] = $row;
  }
}

elseif($username == "admin"){   
  // Use a prepared statement to get the data corresponding to the given username and time.
  $stmt = $db->prepare("SELECT * FROM events WHERE dateTime = ?");
  $stmt->bind_param("s", $date);
  $stmt->execute();

  $result = $stmt->get_result();

$events = array();

  while ($row = mysqli_fetch_assoc($result)) {
    $events[] = $row;
  }
}
  mysqli_close($db);

  return $events;
}



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Get the raw POST data
  $raw_data = file_get_contents("php://input");

  // Decode the JSON data
  $json_data = json_decode($raw_data, true);
  echo "<script>alert('Devin: " . $raw_data . "');</script>";

  // Get the action from the decoded JSON data
  $action = $json_data['action'];

  if ($action == 'updateEvent') {
      $title = $json_data['title'];
      $dateTime = $json_data['dateTime'];
      $color = $json_data['color'];
      $eventID = $json_data['eventID'];

      updateEvent($title, $dateTime, $color, $eventID);
  }
  if ($action =='deleteEvent') {
      $title = $json_data['title'];
      $dateTime = $json_data['dateTime'];
      $color = $json_data['color'];
      $eventID = $json_data['eventID'];
      deleteEvent($title, $dateTime, $color, $eventID);
    }
  if ($action =='loadTodaysEvents'){
      // echo "<script>console.log('made it here');</script>";
      $username = $json_data['username'];
      $date = $json_data['date'];
      loadTodaysEvents($username, $date);
  }
}

function deleteEvent($title, $dateTime, $color, $eventID) {
  echo "<script>console.log('DeleteEventCalled:');</script>";

  $db = mysqli_connect("oceanus.cse.buffalo.edu:3306", "jtsang3", "50301665", "cse442_2023_spring_team_c_db");
  if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

  $title = mysqli_real_escape_string($db, $title);
  $dateTime = mysqli_real_escape_string($db, $dateTime);
  $color = mysqli_real_escape_string($db, $color);
  $eventID = mysqli_real_escape_string($db, $eventID);

  /* Unprepared query
  $sql = "DELETE from events WHERE eventID = '$eventID'";
  $result = mysqli_query($db, $sql);
  */

    // Use a prepared statement to delete the event with given eventID.
    $stmt = $db->prepare("DELETE from events WHERE eventID = ?");
    $stmt->bind_param("s", $eventID);
    $stmt->execute();

/* See comment at line 110 for details
  if ($result) {
    echo "Event with ID $eventID has been removed successfully.";
} else {
    echo "Error removing event with ID $eventID: " . mysqli_error($db);
}
  */

mysqli_close($db);
}
function updateEvent($title, $dateTime, $color, $eventID) {
  $db = mysqli_connect("oceanus.cse.buffalo.edu:3306", "jtsang3", "50301665", "cse442_2023_spring_team_c_db");
  if (!$db) {
      die("Connection failed: " . mysqli_connect_error());
  }

  /* Prepare statements don't require escaped strings
  $title = mysqli_real_escape_string($db, $title);
  $dateTime = mysqli_real_escape_string($db, $dateTime);
  $color = mysqli_real_escape_string($db, $color);
  $eventID = mysqli_real_escape_string($db, $eventID);
  */

  /* Unprepared query
  $sql = "UPDATE events SET title = '$title', dateTime = '$dateTime', color = '$color' WHERE eventID = '$eventID'";
  $result = mysqli_query($db, $sql);
*/

    // Use a prepared statement to get update the data corresponding to the given parameters.
    $stmt = $db->prepare("UPDATE events SET title =?, dateTime =?, color =? WHERE eventID =?");
    $stmt->bind_param("ssss", $title, $dateTime, $color, $eventID);
    $stmt->execute();

  /* Commented out temporarily, add back later maybe
  if ($result) {
      echo "Event with ID $eventID has been updated successfully.";
  } else {
      echo "Error updating event with ID $eventID: " . mysqli_error($db);
  }
  */

  mysqli_close($db);
}


?>