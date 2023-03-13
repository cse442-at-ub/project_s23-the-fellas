<?php
include 'ProjectPHP/CalCode.php';
$calendar = new Calendar('2021-02-03');
$calendar->add_event('Birthday', '2021-02-03', 1, 'green');
$calendar->add_event('Doctors', '2021-02-04', 1, 'red');
$calendar->add_event('Holiday', '2021-02-16', 7);
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="column.css">
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

<h1 id="mainHead">
  <div class="topnav">
    <a class="active" href="#Active View">Active View</a>
	<a id="pTopNav">Welcome Victor E. Bull</a>
    </div></h1>
<div class="sidenav">
	<a id="sideAnchor">  <button id="sideButton" type="button" onclick="alert('Add Event')">Add Event</button></a>
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

	</div>
<script src="modal.js"></script>
</body>

</html>