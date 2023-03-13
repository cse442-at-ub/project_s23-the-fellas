<?php
include 'CalCode.php';
$calendar = new Calendar('2023-03-06');
$calendar->add_event('Birthday', '2023-03-03', 1, 'green');
$calendar->add_event('Doctors', '2023-03-04', 1, 'red');
$calendar->add_event('Holiday', '2023-03-16', 7);
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Event Calendar</title>
		<link href="Style.css" rel="stylesheet" type="text/css">
		<link href="Calendar.css" rel="stylesheet" type="text/css">
		<meta name="viewport" content="width=device-width, initial-scale=1">
	</head>
	<body>
    <!-- Pop-up modal form for adding events. -->
    <div id="myModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <span class="close">&times;</span>
            <p>Add event details here:</p>
            <form action="addEvent.php" method="post">
                <label for="event-title-input">Event Title:</label>
                <input type="text" id="event-title-input" class="modal-input"><br>
                <label for="event-datetime-input">Event Date and Time:</label>
                <input type="datetime-local" id="event-datetime-input" class="modal-input"><br>
                <input type="submit">
            </form>
        </div>
    </div>
	    <!-- <nav class="navtop"> -->
	    <!-- <div> -->
		<h1 id="mainHead">
  			<div class="topnav">
   				<a href="#Active View2">Active View</a>
				<a id="pTopNav">Welcome Victor E. Bull</a>
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
              <script src="modal.js"></script>
	</body>
</html>