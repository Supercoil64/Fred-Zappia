<!DOCTYPE html>

<html>
	<head>
		<title>Fred Zappia</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="css/styles.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	</head>
	
	<body>
	<?php include "includes/navbar.php" ?>
	<script type="text/javascript">
		$("#menu_home").addClass("active");
		
		var currentBackground = 0;
		var backgrounds = [];
		backgrounds[0] = '/users/fp_cadbygy/www/final-project/images/paintings/1934.jpg';
		backgrounds[1] = '/users/fp_cadbygy/www/final-project/images/paintings/Derby.jpg';
		backgrounds[2] = '/users/fp_cadbygy/www/final-project/images/paintings/Bridge at Cooperstown.jpg';
		backgrounds[3] = '/users/fp_cadbygy/www/final-project/images/paintings/Bocce.jpg';
		backgrounds[4] = '/users/fp_cadbygy/www/final-project/images/paintings/The Catcher.jpg';

		function changeBackground() {
			console.log("in changebackground");
			currentBackground++;
			if(currentBackground > 2) currentBackground = 0;

			$('#hero-image').fadeOut(200,function() {
				console.log("faded");
				console.log("changing background");
				$('#hero-image').css({
					'background-image' : "url('" + backgrounds[currentBackground] + "')"
				});
				console.log("fade back in");
				$('#hero-image').fadeIn(200);
			});


			setTimeout(changeBackground, 5000);
		}

		$(document).ready(function() {
			setTimeout(changeBackground, 5000);        
		});
	</script>
	
	<div id="hero-image">
		<div class="hero-text">
			
		</div>
	</div>
	
	
	<div id="content">
	
		<h2>Upcoming Events</h2>
	
		<iframe src="https://calendar.google.com/calendar/embed?src=brc77%40cornell.edu&ctz=America/New_York" 
		width="800" height="600" scrolling="no"></iframe>
		
	</div><!-- end of container div -->
	

	</body>
	
</html>