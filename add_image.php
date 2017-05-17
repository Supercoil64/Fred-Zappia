<?php session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
		<title> Add Image</title>
	<!-- 	function:add new albums -->
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

		if (! isset($_SESSION['logged_user_by_sql'])) {
			print ("<div class = 'caution'><h4>Please login to add images.</h4></div>");
		} else {

		require_once 'includes/settings.php';
		require_once 'includes/config.php';

		$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

		if ($mysqli->errno) {
			print "<p>$mysqli->error</p>";
			exit();
		}

		$target_dir = "images/paintings/";

		$message = '';
		$upload = 1;
		$sql = "SELECT album_id,title FROM Albums";
		$results = $mysqli->query($sql);

		//check if image file is a actual image
		if (isset($_POST["submit"])){
			
			$target_file = $target_dir.basename($_FILES["fileToUpload"]["name"]);
			$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
			$target_file_temp = str_replace(" ", '%20', $target_file);

			if (!$_FILES["fileToUpload"]["tmp_name"]){
				$message .= "<p>No file selected.</p>";
			}
			else{
				$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
				if ($check !== false){
					$upload = 1;
				} else {
					$upload = 0;
					$message .= "<p>File is not an image.</p>";
				}

			// check if file already exists
			if (file_exists($target_file)){
				$upload = 0;
				$message .= "<p>File already exists</p>";
			}
			// check file size
			if ($_FILES["fileToUpload"]["size"] > 5000000) {
				$message .= "<p>Your file is too large.</p>";
				$upload = 0;
			}
			// check file formats
			if (!strcasecmp($imageFileType,"jpg") && !strcasecmp($imageFileType,"png") &&  !strcasecmp($imageFileType,"jpeg") && !strcasecmp($imageFileType,"gif")){
				$message .= "<p>Wrong file type.</p>";
				$upload = 0;
			}

			if ($upload == 1){

			$field_values = array();
				
				//Loop through the expected fields
			foreach( $fields_images as $field ) {
				$field_name = $field[ 'term' ];
				$filter = $field[ 'filter' ];

				if ($field_name == 'file_path'){
					$field_values[$field_name] = $target_file_temp;
				}

				//Does this term exist in the POST data submitted by the add/edit movie form?
				if( !empty( $_POST[ $field_name ] ) ) {
						//Get the value for this term from the POST data
						$field_value = filter_input( INPUT_POST, $field_name, $filter );
						
						//Store the field values
						$field_values[ $field_name ] = $field_value;
					}
				}	

				$sql = '';
				if( empty( $field_values['title']) || empty( $field_values['caption']) || empty($field_values['dimensions']) || empty( $field_values['price']) ) {
					$message .= '<p>Image not added. Title, Caption, Dimensions, and Price are required.</p>';

				} elseif (strlen($field_values['title']) > 100) {
					$message .= '<p>Image not added. Title should has less than 100 characters.</p>';
				} elseif(strlen($field_values['dimensions']) >20 ){
					$message .= '<p>Image not added. Dimensions should has less than 20 characters.</p>';
				} elseif(strlen($field_values['caption']) >500 ){
					$message .= '<p>Image not added. Caption should has less than 500 characters.</p>';
				} else{
					if (! move_uploaded_file($_FILES["fileToUpload"]["tmp_name"],$target_file)){
						$message .= "<p>Error uploading your file</p>";
					}
					else{
						$field_name_array = array_keys($field_values);
						$field_list = implode(',',$field_name_array);
						$value_list = implode("','",$field_values);
						$sql .= "INSERT INTO Images ($field_list) VALUES ('$value_list');";
					}
				}

				if (!empty($sql)){
					if ($mysqli -> query($sql)){
						$message.='<p>Image Saved.</p>';

						$image_id = $mysqli->insert_id;
					} else {
						$message .= "<p>Error saving image.</p><p>$mysqli->error</p>";
					}
				}

				if (!empty($image_id)){
					if (!empty($_POST['albums'])){
						$albums = $_POST['albums'];
						foreach ($albums as $album){
							$mysqli->query("INSERT INTO Display(album_id,image_id) VALUES($album,$image_id)");
							// $mysqli->query("UPDATE Albums SET date_modified = now() WHERE album_id = $album");
						}
					}
				}
			}
		}
	}

	$mysqli->close();

	?>


		<div class = 'add'>
			<h3>Add Image</h3>
		<?php
		print "<h3 class ='message'>$message</h3>";
		print "<form method = 'post' enctype = 'multipart/form-data'>";
		print "<p>Select image to upload</p>";
		print "<input type = 'file' name='fileToUpload' id = 'fileToUpload'>";
		print "<p>add title:</p>";
		print "<input type='text' name = 'title'>";
		print "<p>add caption:</p>";
		print "<input type='text' name = 'caption'>";
		print "<p>add dimension:</p>";
		print "<input type = 'text' name = 'dimensions'>";
		print "<p>add price($):</p>";
		print "<input type = 'text' name = 'price'>";
		print "<p>add to albums(s)</p>";
		print "<table id  = 'addImage'><thead><tr><th>Add To</th><th>Album Id</th><th>Title</th></tr></thead>";
		print "<tbody>";
		while($row = $results->fetch_assoc()){
			$value = $row['album_id'];
			$title = $row['title'];
			print "<tr>";
			print "<td><input type = 'checkbox' name = 'albums[]' value='$value'></td><td>$value</td><td>$title</td>";
			print "</tr>";

		}
		print "</tbody>";
		print "</table>";
		print "<input type = 'submit' value = 'Upload Image' name = 'submit'>";
		print "</form>";
		print "<a class='return' href='gallery.php'>return</a>";
		print "</div>";
	}
		?>
	</body>

</html>

