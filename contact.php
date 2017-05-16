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
	
	<?php 
		function validate() {
			if(isset($_POST['submit'])){
				if($_POST['name'] == ""){
					return "You must input a name.";
				} else if ($_POST['mail'] == ""){
					return "You must enter an e-mail address.";
				} else if ($_POST['comment'] == ""){
					return "Your message is blank.";
				} else if (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)){
					return "E-mail is not valid.";
				} else {
			
					ini_set('SMTP','info2300.coecis.cornell.edu');
					ini_set('smtp_port',22);
					$to = "brc77@cornell.edu"; // this is your Email address
					$from = $_POST['mail']; // this is the sender's Email address
					$name = $_POST['name'];
					$subject = "Guest message from Zappia Fine Art";
					$subject2 = "Copy of your form submission";
					$message = $name . " wrote the following:" . "\n\n" . $_POST['comment'];
					
					if(isset($_POST['listserve'])){
						$message = $message . "\n\n Please add " . $from . " to the listserve.";
					}

					$headers = "From:" . $from;
					mail($to,$subject,$message,$headers);
					return "Mail Sent. Thank you " . $name . ", we will contact you shortly.";
				}
			}
		}
	?>
	<script type="text/javascript">
		$("#menu_contact").addClass("active");
	</script>
	
	<div id="content">
	<h1>Contact</h1>
	
	<div id="feedback">
		<?php echo validate(); ?>
	</div><!-- end of feedback div -->
	
	<form action="contact.php" method="post" id="contact_form" class="inputform">
		<br>
		<input type="text" name="name" id="name" placeholder="Name"><br>
		<br>
		<input type="text" name="mail" id="mail" placeholder="E-Mail"><br>
		<br>
		<textarea name="comment" id="comment"></textarea><br>
		<input type="checkbox" name="listserve" value="Listserve"> Add me to Fred's e-mail listserve<br><br>
		<input type="submit" name="submit" value="Send">
		<input type="reset" value="Reset">
	</form>
	
	</div>
	</body>
	
</html>