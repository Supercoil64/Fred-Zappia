<!DOCTYPE html>

<html>
	<head>
		<title>Gallery</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="css/styles.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	</head>
	
	<body>
	<?php include "includes/navbar.php" ?>
	<script type="text/javascript">
		$("#menu_gallery").addClass("active");
	</script>

	<!-- This page will show all ablums -->

	<?php
		require_once 'includes/config.php';

		$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

		//Was there an error connecting to the database?
		if ($mysqli->errno) {
			//The page isn't worth much without a db connection so display the error and quit
			print($mysqli->error);
			exit();
		}


		if (isset($_GET['delete_id'])){
			$delete_id = filter_input( INPUT_GET, 'delete_id', FILTER_SANITIZE_NUMBER_INT );
			$delete_query = "DELETE FROM Albums WHERE album_id = ".$delete_id;
			$delete_res = $mysqli->query($delete_query);

			if ($delete_res){
				print("<script>");
				// print ("window.alert(window.location.href.split('?')[0]);");
				print ("window.location.href.replace(window.location.href.split('?')[0]);");
				// print ("window.location.reload();");
				print("</script>");
			} else{
				print("<script>");
				print("alert('Delete failed!')");
				print("</script>");
			}

		}

		$result = $mysqli->query("SELECT * FROM Albums");
	

		while($row = $result->fetch_assoc()){
			print("<div class='box'>");
			print("<div class='container'>");
			$album_id = $row['album_id'];
			$href = "album.php?album_id=$album_id";
			print("<a href='$href'>");
			$query = "SELECT Images.file_path FROM Albums INNER JOIN Display ON Albums.album_id = Display.album_id INNER JOIN Images ON Images.image_id = Display.image_id WHERE Albums.album_id = $album_id";
			$temp = $mysqli->query($query);
			$path = $temp->fetch_row();
			if (empty($path)){
				$path[0] = 'images/paintings/none.jpg';
			}
			print("<img class = 'pic' src='".$path[0]."' alt='' >");
			print("</a>");
			print("<div class='overlay'>");
			print("<div class='desc_album'><h4>{$row[ 'title' ]}</h4><p>Date Created: {$row['date_created']}</p><p>Date Modified: {$row['date_modified']}</p></div>");
			if (isset($_SESSION['logged_user_by_sql'])) {
				print("<div class ='delete'><a href='javascript:delete_id($album_id)' ><p>delete</a>   ");
				print("<a href='edit_album.php?edit_id=$album_id' >edit</p></a></div>");
			}
			print ("</div></div></div>");
		}


		$mysqli->close();
	
	?>

	


	</body>
	
</html>