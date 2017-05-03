<!DOCTYPE html>

<html>
	<head>
		<title>Contact</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="css/styles.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	</head>
	
	<body>
	<?php include "includes/navbar.php" ?>
	<script type="text/javascript">
		$("#menu_contact").addClass("active");
	</script>
	
	<h1>Contact</h1>
	
	<form action="mailto:brc77@cornell.edu" method="post" enctype="text/plain" id="contact_form">
		<br>
		<input type="text" name="name" id="name" placeholder="Name"><br>
		<br>
		<input type="text" name="mail" id="mail" placeholder="E-Mail"><br>
		<br>
		<textarea name="comment" id="comment"></textarea><br><br>
		<input type="submit" value="Send">
		<input type="reset" value="Reset">
	</form>
	

	</body>
	
</html>