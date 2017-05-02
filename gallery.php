<!DOCTYPE html>

<html>
	<head>
		<title>Gallery</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="css/styles.css">
	</head>
	
	<body>
	<?php include "includes/navbar.php" ?>


	<!-- This page will show all ablums -->
	<!-- after click on one album, it will show images in that ablum -->

	<!-- if(!empty($_GET['albumID'])){				
	$albumID=FILTER_INPUT(INPUT_GET,'albumID',FILTER_VALIDATE_INT);
	if($albumID===FALSE){
		exit("<p class='warning'>Wrong URL</p>");
	}
	require_once 'includes/config.php';
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	if ($mysqli->errno) {
		print($mysqli->error);
		exit();
	}
	$sql = 'SELECT * FROM Albums INNER JOIN Display ON Albums.albumID=Display.albumID INNER JOIN Images ON Images.imageID= Display.imageID';
	$sql .= " where Albums.albumID=$albumID;";
	$result = $mysqli->query($sql);
	if (!$result) {
		print($mysqli->error);
		exit("<p class='warning'>No images</p>");
	}
	# fetch $result and show thumbnails
	$mysqli->close();
} -->



	<!-- after click on on image, it will show full-size image -->
<!-- 	if(!empty($_GET['imageID'])){			
	$imageId=FILTER_INPUT(INPUT_GET,'imageId',FILTER_VALIDATE_INT);
	if($imageId===FALSE){
		exit("<p class='warning'>Wrong URL</p>");
	}
	require_once 'includes/config.php';
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	if ($mysqli->errno) {
		print($mysqli->error); -->


	


	</body>
	
</html>