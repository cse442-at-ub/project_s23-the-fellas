<?php
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
	$calendar->add_event($event["title"], $event["dateTime"], 1, 'red');
	// echo '<script>alert("' . $event["userID"] . $event["title"] . $event["dateTime"] .  '");</script>';
}

//THIS PART RUNS EVERYTIME REFRESHED IDK WHY HELP
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["title"], $_POST["date-time"])) {
	addEvent($_SESSION['username'], $_POST["title"], substr($_POST["date-time"], 0, 10), "red");
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
		<link href="ProjectPHP/monthly_view.css" rel="stylesheet" type="text/css">
		<link href="ProjectPHP/Calendar.css" rel="stylesheet" type="text/css">
		<meta name="viewport" content="width=device-width, initial-scale=1">
	</head>
	<body>
    <!-- Pop-up modal form for adding events. -->
    <div id="myModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <span class="close">&times;</span>
            <p>Add event details here:</p>
            <form action="#" method="post"> <!-- Server returns this file, Calendar.php, upon form submission -->
                <label for="event-title-input">Event Title:</label>
                <input type="text" id="event-title-input" class="modal-input" name="title"><br>
                <label for="event-datetime-input">Event Date and Time:</label>
                <input type="datetime-local" id="event-datetime-input" class="modal-input" name="date-time"><br>
                <input type="submit">
            </form>
        </div>
    </div>
	    <!-- <nav class="navtop"> -->
	    <!-- <div> -->
		<h1 id="mainHead">
  			<div class="topnav">
   				<a href="#Active View2">Active View</a>
				<a id="pTopNav">Welcome, <?php echo $_SESSION['username']?></a>
    		</div></h1>
		<!-- </div> -->
	    <!-- </nav> -->
		<div class="sidenav">
			<a id="sideAnchor">  
				<button id="sideButton" type="button">Add Event</button>
			</a>
			<h1 id="sideHeader">
				<?php 
					date_default_timezone_set('America/New_York');
					echo 'Todays Events';
					$current_date = date('Y-m-d'); 
					$todaysEvents = loadTodaysEvents($_SESSION['username'], $current_date);
					
				?>
			</h1>
			<ol>
				<?php 
					foreach ($todaysEvents as $event) {
						echo "<li>" . $event["title"] . "</li><br><br><br>"; // output each event date and title
					}
				?>
			</ol>
		</div>
		  <div class="main">
		  <div class="content home">
			<?=$calendar?>
		</div>
              <script src="ProjectPHP/modal.js"></script>
	</body>
</html>