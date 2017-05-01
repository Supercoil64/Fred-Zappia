<!DOCTYPE html>

<html>
<body>
<?php
	//include("includes/header.php");
?>

<h1>Artist Statement</h1>

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
	$artistImageFilename = $row['image'];
	print("<img src='images/artistinfo/$artistImageFilename'>");
	print("<p>Fred Zappia</p>");
	
	$introduction = $row['introduction'];
	print("<p>$introduction</p>");
	
	print("<h1>Previous Exhibitions</h1>");
	
	$sql = "SELECT * FROM Exhibitions INNER JOIN Address_exhibition ON Exhibitions.zip=Address_exhibition.zip;";
	$result = $mysqli->query($sql);
	if (!$result) {
		print($mysqli->error);
		exit("");
	}
	while($row=$result->fetch_assoc()){
		print($row['content']);
		print($row['start_time']);
		print($row['end_time']);
		print($row['street']);
		print($row['city']);
		print($row['state']);
		print($row['zip']);
		
	}
	
	
?>

</body>
</html>