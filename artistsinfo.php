<? session_start() ?>
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
	print("<img src='images/artistinfo/$artistImageFilename' alt='noimage'>");
	if(isset($_SESSION['logged_user_by_sql'])){
		print("<form method = 'post' enctype = 'multipart/form-data'>");
		print("<input type = 'file' name='new_artistphoto'>");
		print("<input type = 'submit' value = 'Save' name = 'save_artistphoto'>");
		print("</form>");
	}	
	print("<p id='artistimagecaption'>Fred Zappia</p>");
	
	$introduction = $row['introduction'];
	if(empty($_SESSION['logged_user_by_sql'])){
		print("<p id='artiststatement'>$introduction</p>");
	}else{
		print("<form method = 'post'><textarea rows='4' cols='50' name='new_introduction' id='artiststatement'>$introduction</textarea><br><input type = 'submit' value = 'Save' name = 'save_introduction'>");
	}
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
	
	if(!empty($_SESSION['logged_user_by_sql']) && !empty($_POST['save_artistphoto'])){
		$newFile=$_FILES['new_artistphoto'];
		if($newFile['error']==4){
			echo "<script type='text/javascript'>alert('No image')</script>";
			exit();
		}elseif($newFile['error']!=0){
			echo "<script type='text/javascript'>alert('File upload error')</script>";
			exit();
		}
		$tempName=$newFile['tmp_name'];
		$file_name=$newFile['name'];
		
		if(strlen($file_name)>512){
			echo "<script type='text/javascript'>alert('Too long file name')</script>";
			exit();
		}
		
		$filetype=$newFile['type'];
		if($filetype!=="image/png" && $filetype!=="image/jpeg" && $filetype!=="image/gif"){
			echo "<script type='text/javascript'>alert('Upload file is not image file (png, jpeg, gif).')</script>";
			exit();
		}
		
		if($newFile['size']>3145728){
			echo "<script type='text/javascript'>alert('Maximum file size is 3MB')</script>";
			exit();			
		}
		
		require_once 'includes/config.php';
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		if ($mysqli->errno) {
			print($mysqli->error);
			exit();
		}
		
		
		$sql = "SELECT * FROM Artist WHERE aid = 1;";
		$result = $mysqli->query($sql);
		if (!$result) {
			print($mysqli->error);
			exit();
		}
		$row = $result->fetch_assoc();
		$artistImageFilename = $row['image'];
				
		$sql = "UPDATE Artist SET image='$file_name' WHERE aid = 1;";
		$mysqli->query($sql);
		
		#img folder's file permission should allow write.
		move_uploaded_file($tempName,"images/artistinfo/$file_name");
		chmod("images/artistinfo/$file_name",0777);
		unlink("images/artistinfo/$artistImageFilename");
		
		echo "<script type='text/javascript'>alert('Upload success. Please reload the page.')</script>";
				
	}
	
	if(!empty($_SESSION['logged_user_by_sql']) && !empty($_POST['save_introduction'])){
		$new_introduction=FILTER_INPUT(INPUT_POST,new_introduction,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		if ($mysqli->errno) {
			print($mysqli->error);
			exit();
		}
		$sql = "UPDATE Artist SET introduction='$new_introduction' WHERE aid = 1;";
		$mysqli->query($sql);
		
		echo "<script type='text/javascript'>alert('Upload success. Please reload the page.')</script>";
				
	}
	
	
?>

</div>
	</body>
	
</html>