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


	<!-- after click on one album, it will show images in that ablum -->


		<?php
		$album_id = filter_input( INPUT_GET, 'album_id', FILTER_SANITIZE_NUMBER_INT );
		if( empty( $album_id ) ) {
			//Try to get it from the POST data (form submission)
			$album_id = filter_input( INPUT_POST, 'album_id', FILTER_SANITIZE_NUMBER_INT );
		}


		require_once 'includes/config.php';

		$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

		//Was there an error connecting to the database?
		if ($mysqli->errno) {
			//The page isn't worth much without a db connection so display the error and quit
			print($mysqli->error);
			exit();
		}

		$row_name = $mysqli->query("SELECT title FROM Albums WHERE album_id = $album_id")->fetch_assoc();
		$album_name = $row_name['title'];


		if (isset($_GET['delete_id'])){
			$delete_id = filter_input( INPUT_GET, 'delete_id', FILTER_SANITIZE_NUMBER_INT );
			$delete_query = "DELETE FROM Display WHERE album_id = $album_id AND image_id = $delete_id";
			$delete_res = $mysqli->query($delete_query);

			if ($delete_res){
				print("<script>");
				// print ("window.alert(window.location.href();");
				print ("window.location.href.replace(window.location.href.split('&')[0]);");
				// print ("window.location.reload();");
				print("</script>");
			} else{
				print("<script>");
				print("alert('Delete failed!')");
				print("</script>");
			}

		}

		$sql = "SELECT images.image_id, images.title, images.caption, images.price, images.dimensions, images.file_path ";
		$sql .= "FROM Albums INNER JOIN Display ON Albums.album_id = Display.album_id AND Albums.album_id = $album_id ";
		$sql .=  "INNER JOIN Images ON Display.image_id = Images.image_id";

		$result = $mysqli->query($sql);

		print ("<h2>$album_name</h2>");

		 while($row = $result->fetch_assoc()){
		 	print("<div class = 'box'>");
		 	print("<div class='container'>");
		 	$id = $row['image_id'];
		 	$href = "full_image.php?id= $id";
		 	print("<a href='$href'>"); 
		 	print("<img class = 'pic' src= '".$row[ 'file_path' ]."' ></img>");
		 	print("</a>");
		 	print(" <div class='desc'><h4>{$row[ 'title' ]}</h4></div>");
		 	if (isset($_SESSION['logged_user_by_sql'])) {
				print("<div class ='delete'><a href='javascript:delete_id($id,$album_id)' ><p>delete</p></a></div>");
			}
			print ("</div></div>");
		 }

		 $mysqli->close();


		 ?>



	</body>
	
</html>