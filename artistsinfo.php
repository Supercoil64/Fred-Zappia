<!DOCTYPE html>

<html>
	<head>
		<title>Artist's Info</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="css/styles.css">
	</head>
	
	<body>
	<?php include "includes/navbar.php" ?>

<h1>Artist Information</h1>
	
<?php
	require_once 'includes/config.php';
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	if ($mysqli->errno) {
		print($mysqli->error);
		exit();
	}
	$sql = "SELECT * FROM Artist INNER JOIN Address ON Artist.zip=Address.zip WHERE aid = 1;";
	$result = $mysqli->query($sql);
	if (!$result) {
		print($mysqli->error);
		exit();
	}
	$row = $result->fetch_assoc();
	$artistImageFilename = $row['image'];
	print("<img src='images/artistinfo/$artistImageFilename'>");
	print("<p>Fred Zappia</p>");
	
	$introduction = $row['introduction'];
	print("<p>$introduction</p>");
	
	print("<h1>Previous Exhibitions</h1>");
	
	$sql = "SELECT * FROM Exhibitions INNER JOIN Address ON Exhibitions.zip=Address.zip;";
	$result = $mysqli->query($sql);
	if (!$result) {
		print($mysqli->error);
		exit("");
	}
	while($row=$result->fetch_assoc()){
		print($row['content']);
		print("<br>");
		$period = 'From '.$row['start_time'].' To '.$row['end_time'];
		print($period);
		print("<br>");		
		$address = implode(array($row['street'],$row['city'],$row['state'],$row['zip'])," ");
		print($address);
		print("<br>");		
	}
	
	
?>


	</body>
	
</html>