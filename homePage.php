<?php 
session_start(); // Start the session

// Check if the 'loggedin' variable is not set or has a value of false
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Redirect to the login page
    header('Location: login.php');
    exit; // Exit the script
}
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="data/home.css">
<link rel="stylesheet" href="data/column.css">
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
  </ol>
  <!-- <a href="#edit">Edit Events</a> -->
</div>
<div class="main">
	<div class="row">
		<table class="table" cellspacing="0" cellpadding="0">
			<thead>
				<tr>
					<th>Time</th>
					<th>Sunday</th>
					<th>Monday</th>
					<th>Tuesday</th>
					<th>Wednesday</th>
					<th>Thursday</th>
					<th>Friday</th>
					<th>Saturday</th>
				</tr>
			</thead>
			<tbody>
				  <tr>
					<td>12:00 AM</td>
				  </tr>
				  <tr>
					<td>1:00 AM</td>
					<td>Testing</td>
				  </tr>
				  <tr>
					<td>2:00 AM</td>
					<td>Testing</td>
				  </tr>
				  <tr>
					<td>3:00 AM</td>
					<td>Testing</td>
				  </tr>
				  <tr>
					<td>4:00 AM</td>
					<td>Testing</td>
				  </tr>
				  <tr>
					<td>5:00 AM</td>
				  </tr>
				  <tr>
					<td>6:00 AM</td>
				  </tr>
				  <tr>
					<td>7:00 AM</td>
				  </tr>
				  <tr>
					<td>8:00 AM</td>
				  </tr>
				  <tr>
					<td>9:00 AM</td>
				  </tr>
				  <tr>
					<td>10:00 AM</td>
				  </tr>
				  <tr>
					<td>11:00 AM</td>
				  </tr>
				  <tr>
					<td>12:00 PM</td>
				  </tr>
				  
			</tbody>		
		</table>
	</div>    
</div>
</body>
</html>