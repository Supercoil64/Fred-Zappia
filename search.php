<!DOCTYPE html>

<html>
	<head>
		<title>Search</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="css/styles.css">
	</head>
	
	<body>
	<?php include "includes/navbar.php" ?>

	<!-- PHP – receive search key word through $_POST and show thumbnails that match the key word by accessing the database with mysqli. -->


<!-- 	if(!empty($_POST['searchWord'])){
	$searchWord=filter_input(INPUT_POST, 'searchWord', FILTER_SANITIZE_FULL_SPECIAL_CHARS);				$searchWord="%".$searchWord."%";
	require_once 'includes/config.php';
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	if ($mysqli->errno) {
		print($mysqli->error);
		exit();
	}
	$sql = “SELECT * FROM Images WHERE title LIKE ‘$searchWord’ AND description LIKE ‘$searchWord’;”;
	$result = $mysqli->query($sql);
	if (!$result) {
		print($mysqli->error);
		exit("<p class='warning'>No images</p>");
	}
	# fetch $result and show thumbnails
	$mysqli->close();
} -->


	</body>
	
</html>