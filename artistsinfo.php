<!DOCTYPE html>

<html>
<body>
<?php
	//include("includes/header.php");
?>

<h1>Fred Zappia</h1>

<?php
	require_once 'includes/config.php';
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	if ($mysqli->errno) {
		print($mysqli->error);
		exit("");
	}
	$sql = "SELECT * FROM Artist INNER JOIN Address_artist ON Artist.zip=Address_artist.zip WHERE aid = 1;";
	$result = $mysqli->query($sql);
	if (!$result) {
		print($mysqli->error);
		exit("");
	}
	$row = $result->fetch_assoc();
	print ($row['image']);
	print ($row['phone']);
	print ($row['email']);
	print ($row['introduction']);
	print ($row['street']);
	print ($row['zip']);
	print ($row['city']);
	print ($row['state']);
?>

</body>
</html>