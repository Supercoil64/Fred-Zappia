<? session_start() ?>
<!DOCTYPE html>

<html  lang="en">
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
	print("<img src='images/artistinfo/$artistImageFilename' alt='' class='artistinfoPhoto'>");
	print("<p id='artistimagecaption'>Fred Zappia</p>");
	if(isset($_SESSION['logged_user_by_sql'])){
		print("<form method = 'post' class='artistinfo_save' enctype = 'multipart/form-data'>");
		print("<input type = 'file' name='new_artistphoto'>");
		print("<input type = 'submit' value = 'Save' name = 'save_artistphoto'>");
		print("</form>");
	}	


	
	
	$paragraph1 = $row['paragraph1'];
	if(empty($_SESSION['logged_user_by_sql'])){
		print("<p class='artiststatement'>$paragraph1</p>");
	}else{
		print("<form method = 'post' class='artistinfo_save'><textarea rows='4' cols='50' name='new_paragraph1' class='artiststatement'>$paragraph1</textarea><br><input type = 'submit' value = 'Save' name = 'save_paragraph1'></form>");
	}
	
	
	print("<img src='images/artistinfo/Paintbrushes.jpeg' alt='' class='artistinfoPhoto'>");
	
	$paragraph2 = $row['paragraph2'];
	if(empty($_SESSION['logged_user_by_sql'])){
		print("<p class='artiststatement'>$paragraph2</p>");
	}else{
		print("<form method = 'post' class='artistinfo_save'><textarea rows='4' cols='50' name='new_paragraph2' class='artiststatement'>$paragraph2</textarea><br><input type = 'submit' value = 'Save' name = 'save_paragraph2'></form>");
	}
	
	print("<img src='images/artistinfo/Closeupofhand.JPG' alt='' class='artistinfoPhoto'>");
	
	
	$paragraph3 = $row['paragraph3'];
	if(empty($_SESSION['logged_user_by_sql'])){
		print("<p class='artiststatement'>$paragraph3</p>");
	}else{
		print("<form method = 'post' class='artistinfo_save'><textarea rows='4' cols='50' name='new_paragraph3' class='artiststatement'>$paragraph3</textarea><br><input type = 'submit' value = 'Save' name = 'save_paragraph3'></form>");
	}
	
	
	print("<h2>Previous Exhibitions</h2>");
	
	$sql = "SELECT * FROM Exhibitions;";
	$result = $mysqli->query($sql);
	if (!$result) {
		print($mysqli->error);
		exit("");
	}
	if(empty($_SESSION['logged_user_by_sql'])){
		print("<table id='exhibitioninfo'><tr><th> </th><th>Period</th><th>Place</th><th>URL</th></tr>");
		while($row=$result->fetch_assoc()){
			print("<tr>");
			print("<td>{$row['content']}</td>");
			$period = $row['start_time'].' to '.$row['end_time'];
			print("<td>$period</td>");
			print("<td>{$row['place']}</td>");
			print("<td><a href='{$row['url']}'>{$row['url']}</a></td>");
			print("</tr>");
		}
		print("</table>");
				
	}else{
		print("<form method='post' class='artistinfo_save'><table id='exhibitioninfo'><tr><th>Id</th><th>Title</th><th>From</th><th>To</th><th>Place</th><th>URL</th></tr>");
		while($row=$result->fetch_assoc()){
			print("<tr>");
			print("<td>{$row['eid']}</td>");
			$content='content'.$row['eid'];
			print("<td><input type='text' value={$row['content']} name='$content'></td>");
			$start_time='start_time'.$row['eid'];
			print("<td><input type='date' value={$row['start_time']} name='$start_time'></td>");
			$end_time='end_time'.$row['eid'];
			print("<td><input type='date' value={$row['end_time']} name='$end_time'></td>");
			$place='place'.$row['eid'];
			print("<td><input type='text' value={$row['place']} name='$place'></td>");
			$url='url'.$row['eid'];
			print("<td><input type='text' value={$row['url']} name='$url'></td>");
			print("</tr>");
		}
		print("</table><input type='submit' name='save_exhibition' value='Save'></form>");
	}
	
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
		
		echo "<script type='text/javascript'>alert('Upload success. Please reload the page.')</script>";
				
	}
	
	if(!empty($_SESSION['logged_user_by_sql']) && !empty($_POST['save_paragraph1'])){
		$new_paragraph1=FILTER_INPUT(INPUT_POST,new_paragraph1,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		if ($mysqli->errno) {
			print($mysqli->error);
			exit();
		}
		$sql = "UPDATE Artist SET paragraph1='$new_paragraph1' WHERE aid = 1;";
		$mysqli->query($sql);
		echo "<script type='text/javascript'>alert('Upload success. Please reload the page.')</script>";
	}
	
	if(!empty($_SESSION['logged_user_by_sql']) && !empty($_POST['save_paragraph2'])){
		$new_paragraph2=FILTER_INPUT(INPUT_POST,new_paragraph2,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		if ($mysqli->errno) {
			print($mysqli->error);
			exit();
		}
		$sql = "UPDATE Artist SET paragraph2='$new_paragraph2' WHERE aid = 1;";
		$mysqli->query($sql);
		echo "<script type='text/javascript'>alert('Upload success. Please reload the page.')</script>";
	}
	
	if(!empty($_SESSION['logged_user_by_sql']) && !empty($_POST['save_paragraph3'])){
		$new_paragraph3=FILTER_INPUT(INPUT_POST,new_paragraph3,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		if ($mysqli->errno) {
			print($mysqli->error);
			exit();
		}
		$sql = "UPDATE Artist SET paragraph3='$new_paragraph3' WHERE aid = 1;";
		$mysqli->query($sql);
		echo "<script type='text/javascript'>alert('Upload success. Please reload the page.')</script>";
	}
	
	
	if(!empty($_SESSION['logged_user_by_sql']) && !empty($_POST['save_exhibition'])){
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		if ($mysqli->errno) {
			print($mysqli->error);
			exit();
		}
		
		for ($i = 1; $i <= 3; $i++) {
			$content='content'.$i;
			$new=FILTER_INPUT(INPUT_POST,$content,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			$sql = "UPDATE Exhibitions SET content='$new' WHERE eid = $i;";
			$mysqli->query($sql);
			
			$start_time='start_time'.$i;
			$new=FILTER_INPUT(INPUT_POST,$start_time,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			$sql = "UPDATE Exhibitions SET start_time='$new' WHERE eid = $i;";
			$mysqli->query($sql);
			
			$end_time='start_time'.$i;
			$new=FILTER_INPUT(INPUT_POST,$end_time,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			$sql = "UPDATE Exhibitions SET end_time='$new' WHERE eid = $i;";
			$mysqli->query($sql);
			
			$place='place'.$i;
			$new=FILTER_INPUT(INPUT_POST,$place,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			$sql = "UPDATE Exhibitions SET place='$new' WHERE eid = $i;";
			$mysqli->query($sql);
			
			$url='url'.$i;
			$new=FILTER_INPUT(INPUT_POST,$url,FILTER_SANITIZE_URL);
			$sql = "UPDATE Exhibitions SET url='$new' WHERE eid = $i;";
			$mysqli->query($sql);
						
		}
		

		
		echo "<script type='text/javascript'>alert('Upload success. Please reload the page.')</script>";
	}
	
?>

</div>
	</body>
	
</html>