<?php
include 'test.php';
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
</body>
</html>