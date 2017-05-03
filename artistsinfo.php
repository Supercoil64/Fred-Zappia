<!DOCTYPE html>

<html>
	<head>
		<title>Artist's Info</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="css/styles.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	</head>
	
	<body>
	<?php include "includes/navbar.php" ?>
	<script type="text/javascript">
		$("#menu_artistinfo").addClass("active");
	</script>
	
<div id="content">
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
	print("<p id='artistimagecaption'>Fred Zappia</p>");
	
	$introduction = $row['introduction'];
	print("<p id='artiststatement'>$introduction</p>");
	
	print("<h2>Previous Exhibitions</h2>");
	
	$sql = "SELECT * FROM Exhibitions INNER JOIN Address ON Exhibitions.zip=Address.zip;";
	$result = $mysqli->query($sql);
	if (!$result) {
		print($mysqli->error);
		exit("");
	}
	print("<table id='exhibitioninfo'><tr><th> </th><th>Period</th><th>Place</th></tr>");
	while($row=$result->fetch_assoc()){
		print("<tr>");
		print("<td>{$row['content']}</td>");
		$period = 'From '.$row['start_time'].' To '.$row['end_time'];
		print("<td>$period</td>");
		$address = implode(array($row['street'],$row['city'],$row['state'])," ");
		print("<td>$address</td>");
		print("</tr>");
	}
	print("</table>");
	
?>

</div>
	</body>
	
</html>