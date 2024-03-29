<?php
session_set_cookie_params(0); // configure session cookies to be destroyed when the browser closes
session_start(); // Start the session

include 'ProjectPHP/CalCode.php';
include 'server.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Redirect to the login page
    header('Location: login.php');
    exit; // Exit the script
}

$calendar = new Calendar();


$eventsArray = arrayOfEvents($_SESSION['username']);

foreach ($eventsArray as $event) {
	$calendar->add_event($event["title"], $event["dateTime"], 1, $event["color"], $event["eventID"]);
}

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["title"], $_POST["date-time"])) {
	addEvent($_SESSION['username'], $_POST["title"], substr($_POST["date-time"], 0, 10), $_POST["addEventColor"]);
    unset($_POST["title"]);
    unset($_POST["date-time"]);

	header("Location: " . $_SERVER['PHP_SELF']); // Redirect to the same page
    exit;
}

// Check if the 'loggedin' variable is not set or has a value of false



?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Event Calendar</title>
		<?php
      if(isset($_COOKIE['theme'])){
		$theme = decryptCookie($_COOKIE['theme']);
        //print the theme:
        if($theme == "dark"){
          echo '<link href="ProjectPHP/monthly_view_Dark.css" rel="stylesheet" type="text/css">';
		  echo '<link href="ProjectPHP/CalendarDark.css" rel="stylesheet" type="text/css">';
        }
        else {
			echo '<link href="ProjectPHP/monthly_view.css" rel="stylesheet" type="text/css">';
			echo '<link href="ProjectPHP/Calendar.css" rel="stylesheet" type="text/css">';
        }
      }
	  else {
		  echo '<link href="ProjectPHP/monthly_view.css" rel="stylesheet" type="text/css">';
		  echo '<link href="ProjectPHP/Calendar.css" rel="stylesheet" type="text/css">';
	  }
    ?>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<script>
		function validateForm() {
		  var x = document.forms["InputForm"]["title"].value;
		  var y = document.forms["InputForm"]["date-time"].value;
		  if (x == "" || x == null) {
			alert("Event Title must be filled out");
			return false;
		  }
		  if (y == "" || x == null) {
			alert("Event Date must be filled out");
			return false;
		  }
		}
		</script>
	</head>
	<body>
    <!-- Pop-up modal form for adding events. -->
    <div id="myModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <span class="close">&times;</span>
            <p>Add event details here:</p>
            <form action="#" method="post" onsubmit="return validateForm()" name="InputForm"> <!-- Server returns this file, Calendar.php, upon form submission -->
                <label for="event-title-input">Event Title:</label>
                <input type="text" id="event-title-input" class="modal-input" name="title"><br>
                <label for="event-datetime-input">Event Date and Time:</label>
                <input type="datetime-local" id="event-datetime-input" class="modal-input" name="date-time"><br>
				<label for="addEventColor">Color:</label>
				<select id="addEventColor" name="addEventColor">
					<option value="red">Red</option>
					<option value="blue">Blue</option>
					<option value="orange">Orange</option>
					<option value="green">Green</option>
					<option value="purple">Purple</option>
					<option value="black">Black</option>

				</select>
                <input type="submit">
				
            </form>
        </div>

    </div>
	<div id="eventInfoModal" class="event-info-modal">
		<div class="event-info-modal-content">
			<span class="event-info-close">&times;</span>
			<form id="eventInfoForm">
				<input type="hidden" id="eventInfoID">
				<label for="eventInfoTitle">Title:</label>
				<input type="text" id="eventInfoTitle" name="title">
				<br>
				<label for="eventInfoDate">Date:</label>
				<input type="date" id="eventInfoDate" name="date">
				<br>
				<label for="eventInfoColor">Color:</label>
				<select id="eventInfoColor" name="color">
					<option value="red">Red</option>
					<option value="blue">Blue</option>
					<option value="orange">Orange</option>
					<option value="green">Green</option>
					<option value="purple">Purple</option>
					<option value="black">Black</option>
				</select>
				<br>
				<button type="submit">Save Changes</button>
				<br>
				<button id = "delete">Delete Event</button>
			</form>
		</div>
	</div>
			<div id="dayModal" class="modal">
				<div class="modal-content">
					<span class="close">&times;</span>
					<h2 id="dayModalTitle">Events</h2>
					<ul id="dayModalEvents"></ul>
				</div>
			</div>

		<div class="sidenav">
			<a id="sideAnchor">  
				<button id="sideButton" type="button">Add Event</button>
			</a>
			<h1 id="sideHeader">
				<?php 
					date_default_timezone_set('America/New_York');
					echo 'Todays Events';
					$current_date = date('Y-m-d'); 
					$todaysEvents = loadTodaysEvents($_SESSION['username'], $current_date, FALSE);
					
				?>
			</h1>
			<ol>
				<?php 
				echo "<div>";
					foreach ($todaysEvents as $event) {
						echo "<li>" . $event["title"] . "</li><br><br><br>"; // output each event date and title
					}
					echo "</div>";
				?>
			</ol>
		</div>
		  <div class="main">
		  <div class="content home">
			<?=$calendar?>
		</div>
              <script src="ProjectPHP/modal.js"></script>
			  <script src="ProjectPHP/calendar.js"></script>

	</body>
</html>