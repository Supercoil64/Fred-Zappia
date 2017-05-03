<!DOCTYPE html>

<html>
	<head>
		<title>Album</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="css/styles.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	</head>
	
	<body>
	<?php include "includes/navbar.php" ?>
	<script type="text/javascript">
		$("#menu_gallery").addClass("active");
	</script>



	<?php

	// after click on one image, it will show full size iamge
	require_once 'includes/config.php';

	$id = filter_input( INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT );
	if( empty( $id ) ) {
		//Try to get it from the POST data (form submission)
		$id = filter_input( INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT );
	}

	$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
	$sql = "SELECT * FROM Images WHERE image_id = $id";
	$sql_album = "SELECT * FROM Albums INNER JOIN Display ON Albums.album_id = Display.album_id AND image_id = $id";
	$result = $mysqli->query($sql);
	$albums = $mysqli->query($sql_album);
	$row = $result->fetch_assoc();
	$file_path = $row["file_path"];
	$title = $row["title"];
	$caption = $row["caption"];

	print("<br><br>");
	print("<h2>$title</h2>");
	print("<img class = 'full_img' src='".$file_path."' src=''></img>");
	print(" <div class='desc'>$caption<br><br></div></div></div></div>");

	print ("<div>");
	print ("<h4>Album(s) it is in: </h4>");
	while ($row_album = $albums->fetch_assoc()){
		$album_id = $row_album['album_id'];
		$href = "album.php?album_id=$album_id";
		print("<a href='$href'><p>{$row_album['title']}</p></a>");
	}
	print ("</div>");

	$mysqli->close();

	?>
	</body>

</html>