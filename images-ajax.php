<!DOCTYPE html>
<html>
<body>
<?php
	//Infinite scroll	PHP – return images when called	require_once '../functions.php';
	function get_page() {
		$page = 1; //Default to the first page
		$input_page = filter_input( INPUT_GET, 'page', FILTER_SANITIZE_NUMBER_INT);
		if( ! empty( $input_page ) ) {
			if( $input_page > 1 ) {
				$page = $input_page;
			}
		}
		return $page;
	}
	function get_thumbnails( $page = 1 ) {
		require_once 'includes/config.php';
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		if ( $mysqli->connect_error ) {
			die('Connect Error: ' . $mysqli->connect_error);
		}
		$per_page = 10;
		$offset = $per_page * ( $page - 1);
		$query = "SELECT * FROM Albums INNER JOIN Display ON Albums.albumID=Display.albumID INNER JOIN Images ON Images.imageID= Display.imageID";
		$query .= " WHERE Albums.albumID=$albumID"
		$query .= " LIMIT $offset, $per_page;";
		$result = $mysqli->query($query);
		return $result;
	}
	
	$page = get_page();
	$result = get_thumbnails( $page );
	$all_rows = $result->fetch_all( MYSQLI_ASSOC );
	$response = array('images' => $all_rows, );
	print(json_encode( $response ) );
	die();
	
?>



</body>
</html>