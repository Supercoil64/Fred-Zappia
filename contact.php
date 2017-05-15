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
	
	<div id="content">
	<h1>Contact</h1>
	
	<form action="contact.php" method="post" id="contact_form" class="inputform">
		<br>
		<input type="text" name="name" id="name" placeholder="Name"><br>
		<br>
		<input type="text" name="mail" id="mail" placeholder="E-Mail"><br>
		<br>
		<textarea name="comment" id="comment"></textarea><br><br>
		<input type="submit" name="submit" value="Send">
		<input type="reset" value="Reset">
	</form>
	
	<?php 
		if(isset($_POST['submit'])){
			if($_POST['name'] == ""){
				echo "You must input a name.";
				return;
			} else if ($_POST['mail'] == ""){
				echo "You must enter an e-mail address.";
				return;
			} else if ($_POST['comment'] == ""){
				echo "Your message is blank.";
				return;
			} else if (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)){
				echo "E-mail is not valid.";
				return;
			} else {
			
				ini_set('SMTP','info2300.coecis.cornell.edu');
				ini_set('smtp_port',22);
				$to = "brc77@cornell.edu"; // this is your Email address
				$from = $_POST['mail']; // this is the sender's Email address
				$name = $_POST['name'];
				$subject = "Guest message from Zappia Fine Art";
				$subject2 = "Copy of your form submission";
				$message = $name . " wrote the following:" . "\n\n" . $_POST['comment'];

				$headers = "From:" . $from;
				mail($to,$subject,$message,$headers);
				echo "Mail Sent. Thank you " . $name . ", we will contact you shortly.";
			}
		}
	?>
	
	</div>
	</body>
	
</html>