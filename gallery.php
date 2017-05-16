<? session_start() ?>
<!DOCTYPE html>

<html>
	<head>
		<title>Gallery</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="css/styles.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script type="text/javascript">
			function delete_id(id,album_id){
			if (confirm('Sure to delete this image in current album?')){
					window.location.href='gallery.php?album_id='+album_id+ '&delete_id='+id;
				}
			}
		</script>
	</head>
	
	<body>
	<?php include "includes/navbar.php" ?>
	<script type="text/javascript">
		$("#menu_gallery").addClass("active");
	</script>

	<!-- This page will show all ablums -->
	<h1>Gallery</h1>
	
<div id="content">
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
		
		print ("<a class ='view_all' href = 'all_images.php'><h4>view all paintings ><h4><a>");
		if (isset($_SESSION['logged_user_by_sql'])) {
		print ("<a class ='view_all' href = 'add_album.php'><h4>add new album ><h4><a>");
		print ("<a class ='view_all' href = 'add_image.php'><h4>add new painting ><h4><a>");
	}
		while($row = $result->fetch_assoc()){
			print("<div class='box'>");
			print("<div class='container'>");
			$album_id = $row['album_id'];
			$href = "album.php?album_id=$album_id";
			print("<div class='desc_album'><h2 id='albumTitle'>{$row[ 'title' ]}</h2></div>");
			print("<a href='$href'>");
			$query = "SELECT Images.file_path FROM Albums INNER JOIN Display ON Albums.album_id = Display.album_id INNER JOIN Images ON Images.image_id = Display.image_id WHERE Albums.album_id = $album_id";
			$temp = $mysqli->query($query);
			$path = $temp->fetch_row();
			if (empty($path)){
				$path[0] = 'images/paintings/none.jpg';
			}
			print("<img  src='".$path[0]."' alt='' >");
			print("</a>");
			print("<div class='overlay'>");
			//print("<div class='desc_album'><h4>{$row[ 'title' ]}</h4><p>Date Created: {$row['date_created']}</p><p>Date Modified: {$row['date_modified']}</p></div>");
			if (isset($_SESSION['logged_user_by_sql'])) {
				print("<div class ='delete'><a href='javascript:delete_id($album_id)' ><p>delete</a>  ");
				print("<a href='edit_album.php?edit_id=$album_id' >edit</p></a></div>");
			}
			print ("</div></div></div>");
		}



		$mysqli->close();
	
	?>

	
</div id="content">

	</body>
	
</html>