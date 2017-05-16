<?php session_start(); ?>
<!DOCTYPE html>

<html>
	<head>
		<title>All Images</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="css/styles.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script type="text/javascript">
			function delete_id(id,album_id){
			if (confirm('Sure to delete this image in current album?')){
					window.location.href='all_images.php?album_id='+album_id+ '&delete_id='+id;
				}
			}
			function handleSelect(elm){
				window.location.href = elm.value;
			}
		</script>
	</head>
	
	<body>
	
	<data id="pageInfo" value=1></data>
	<?php
		if(isset($_SESSION['logged_user_by_sql'])){
			print("<data id='key' value=1></data>");
		}
		if(!empty($_GET['sort'])){
			$sort=FILTER_INPUT(INPUT_GET,'sort',FILTER_SANITIZE_STRING);
			print("<data id='sort' value=$sort></data>");
		}else{
			print("<data id='sort' value='none'></data>");
		}
		
		
	?>
		
	<script type="text/javascript">
		$("#menu_gallery").addClass("active");
		$(window).scroll(function() {
			var windowHeight = $(document).height();
			var currentPosition = $(window).height() + $(window).scrollTop();
			if ((windowHeight - currentPosition) / windowHeight <= 0.0001) {
				var page=$("#pageInfo").val();
				console.log(page);
				var sort=$("#sort").val();
				var dataToSend = { page : page, albumId : 0 , sort : sort};
				console.log(dataToSend);
				request = $.ajax({
					url: "images-ajax.php",
					type: "get",
					data: dataToSend,
					dataType: "json"
				});
				request.done(function(data){
					var images=data.images;
					console.log(images);
					images.forEach(function(images){
						console.log(images.title);
						$newImage="<div class = 'box'><div class='container'><a href='full_image.php?id=";
						$newImage+=images.image_id;
						$newImage+="'><img class = 'pic' src= '";
						$newImage+=images.file_path;
						$newImage+="' ></img></a><div class='desc'><h4>";
						$newImage+=images.title;
						$newImage+="</h4><p>$";
						$newImage+=images.price+" "+images.dimensions+"</p></div>";
						if ($("#key").val()==1){
							$newImage+="<div class ='delete'><a href='javascript:delete_id("+images.image_id+")' ><p>delete</a> ";
							$newImage+="<a href='edit_image.php?edit_id="+images.image_id+"'>edit</p></a></div>";
						}
						$newImage+="</div></div>";
						$("#content").append($newImage);
					});
					page=page*1;
					page=page+1;
					$("#pageInfo").attr('value',page);
					if(images.length===0){
						$('#scrollDown').hide();
					}
				});
					
			}
			
			
		});
	</script>
	
	
	
	<?php include "includes/navbar.php" ?>
	<script type="text/javascript">
		$("#menu_gallery").addClass("active");
	</script>


<div id='content'>
	<?php
		require_once 'includes/config.php';

		$message = '';

		$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

				//Was there an error connecting to the database?
		if ($mysqli->errno) {
			//The page isn't worth much without a db connection so display the error and quit
			print($mysqli->error);
			exit();
		}

		if (isset($_GET['delete_id'])){
			$delete_id = filter_input( INPUT_GET, 'delete_id', FILTER_SANITIZE_NUMBER_INT );
			$path_query = "SELECT file_path FROM Images WHERE image_id =".$delete_id;
			$delete_path = $mysqli->query($path_query)->fetch_assoc()['file_path'];
			$delete_query = "DELETE FROM Images WHERE image_id = ".$delete_id;
			$delete_res = $mysqli->query($delete_query);
			if ($delete_res){
				unlink($delete_path);
				print("<script>");
				print ("window.location.href.replace(window.location.href.split('?')[0]);");
				print("</script>");
			} else{
				print("<script>");
				print("alert('Delete failed!')");
				print("</script>");
			}
		}


		if (isset($_GET['sort'])){
			$sort = filter_input(INPUT_GET,'sort',FILTER_SANITIZE_STRING);
		}
		// $sql = "SELECT * FROM images";
    
		$sql = "SELECT DISTINCT Images.image_id, Images.title, Images.file_path,Images.price,Images.dimensions FROM Images INNER JOIN Display ON Images.image_id = Display.image_id";
		// $sql_noalb = "SELECT DISTINCT Images.image_id, Images.title, Images.file_path,Images.price,Images.dimensions FROM Images LEFT JOIN Display ON Images.image_id = Display.image_id WHERE Display.album_id IS NULL";
		
		$sql .=" ORDER BY";
		if (!empty($sort)){
			$sql .= " $sort,";
			// $sql_noalb .= "ORDER BY $sort";
		}
		
		$sql .= " Images.image_id LIMIT 3";
		
		if ($mysqli->query($sql)){
			$result = $mysqli->query($sql);
		}else {
			echo '<p>Error loading images.</p>';
			$message .='<p>Error loading images.</p>';
		}
		// if ($mysqli->query($sql_noalb)){
		// 	$result_no= $mysqli->query($sql_noalb);
		// }else{
		// 	$message .='<p>Error loading images.</p>';
		// }
		print("<div id='sort'>");
		print("<h3>sort by: </h3>"); 
		print("<select onchange='javascript:handleSelect(this)'>");
		print("<option value=''></option>");
		print("<option value='all_images.php?sort=title'>title</option>");
		print("<option value='all_images.php?sort=price'>price</option>");
		print("</select>");
		// print("<a href='all_images.php?sort=title'>title</a>");
		// print("<a href='all_images.php?sort=price'>price</a>");
		print("</div>");


		 while($row = $result->fetch_assoc()){
		 	print("<div class = 'box'>");
		 	print("<div class='container'>");
		 	$id = $row['image_id'];
		 	$href = "full_image.php?id=$id";
		 	print("<a href='$href'>"); 
		 	print("<img class = 'pic' src= '".$row[ 'file_path' ]."' alt=''>");
		 	print("</a>");
		 	print(" <div class='desc_img'><h4>{$row[ 'title' ]}</h4><p>$"."{$row[ 'price' ]} {$row[ 'dimensions' ]}</p></div>");
		 	if (isset($_SESSION['logged_user_by_sql'])) {
				print("<div class ='delete'><a href='javascript:delete_id($id)' ><p>delete</a> ");
				print("<a href='edit_image.php?edit_id=$id' >edit</p></a></div>");

			}
			print ("</div></div>");
		 }


		 // print ("<div class='all_img'>");
		 // print ("<h4>Image(s) that are not in any albums<h4>");
		 // while($row_no = $result_no->fetch_assoc()){
		 // 	print("<div class = 'box'>");
		 // 	print("<div class='container'>");
		 // 	$id = $row_no['image_id'];
		 // 	$href = "full_image.php?id=$id";
		 // 	print("<a href='$href'>"); 
		 // 	print("<img class = 'pic' src= '".$row_no[ 'file_path' ]."' alt=''>");
		 // 	print("</a>");
		 // 	print(" <div class='desc_img'><h4>{$row_no[ 'title' ]}</h4></div>");
		 // 	if (isset($_SESSION['logged_user_by_sql'])) {
			// 	print("<div class ='delete'><a href='javascript:delete_id($id)' ><p>delete</a> ");
			// 	print("<a href='edit_image.php?edit_id=$id' >edit</p></a></div>");

			// }
			// print ("</div></div>");
		 // }
		 // print ("</div>");

		 $mysqli->close();
	?>

</div>
<div id='scrollDown'><img src='images/scrollDown.png' class='scrollDownIcon' alt=''></div>


	</body>
	
</html>