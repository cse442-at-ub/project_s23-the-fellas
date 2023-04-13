<?php
session_start(); // Start the session

include 'ProjectPHP/CalCode.php';

$calendar = new Calendar('2023-03-13');
$calendar->add_event('Birthday', '2023-03-03', 1, 'green');
if(isset($_POST["title"], $_POST["date-time"])) {
    $calendar->add_event($_POST["title"], substr($_POST["date-time"], 0, 10), 1, 'red');
}

// Check if the 'loggedin' variable is not set or has a value of false
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Redirect to the login page
    header('Location: login.php');
    exit; // Exit the script
}

$calendar = new Calendar();


$eventsArray = arrayOfEvents($_SESSION['username']);

foreach ($eventsArray as $event) {
	$calendar->add_event($event["title"], $event["dateTime"], 1, $event["color"], $event["eventID"]);
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
			</form>
		</div>
	</div>
	    <!-- <nav class="navtop"> -->
	    <!-- <div> -->
		<h1 id="mainHead">
  			<div class="topnav">
   				<a href="#Active View2">Active View</a>
				<a id="pTopNav">Welcome, Victor E. Bull</a>
    		</div></h1>
		<!-- </div> -->
	    <!-- </nav> -->
		<div class="sidenav">
			<a id="sideAnchor">  <button id="sideButton" type="button">Add Event</button></a>
  			<h1 id="sideHeader">Sunday's Events</h1>
  			<ol>
    		<li>1:00 AM Testing</li>
			<br>
    		<li>2:00 AM Testing</li>
			<br>
    		<li>3:00 AM Testing</li>
			<br>
    		<li>4:00 AM Testing</li>
  		</ol></div>
		  <div class="main">
		  <div class="content home">
			<?=$calendar?>
		</div>
              <script src="ProjectPHP/modal.js"></script>
	</body>
</html>