<!DOCTYPE html>

<html>
	<head>
		<title>Contact</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="css/styles.css">
	</head>
	
	<body>
	<?php include "includes/navbar.php" ?>
	
	<h1>Contact</h1>
	
	<form action="mailto:brc77@cornell.edu?subject=Message From Website" method="post" enctype="text/plain" id="contact_form">
		<br>
		<input type="text" name="name" id="mail" placeholder="Name"><br>
		<br>
		<input type="text" name="mail" id="mail" placeholder="E-Mail"><br>
		<br>
		<textarea type="text" name="comment" id="comment"></textarea><br><br>
		<input type="submit" value="Send">
		<input type="reset" value="Reset">
	</form>
	

	</body>
	
</html>