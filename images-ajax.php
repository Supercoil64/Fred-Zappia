<?php
	function get_page() {
		$page = 1;
		$input_page = filter_input( INPUT_GET, 'page', FILTER_SANITIZE_NUMBER_INT);
		if( ! empty( $input_page ) ) {
			if( $input_page > 1 ) {
				$page = $input_page;
			}
		}
		return $page;
	}
	function get_image( $page = 1 ) {

	}
	
	$page = filter_input( INPUT_GET, 'page', FILTER_SANITIZE_NUMBER_INT);
	$album_id = filter_input( INPUT_GET, 'albumId', FILTER_SANITIZE_NUMBER_INT);
	require_once 'includes/config.php';
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	if ( $mysqli->connect_error ) {
		die('Connect Error: ' . $mysqli->connect_error);
	}
	$per_page = 3;
	$offset = $per_page * $page;
	
	$sql = "SELECT * ";
	$sql .= "FROM Albums INNER JOIN Display ON Albums.album_id = Display.album_id ";
	$sql .= "INNER JOIN Images ON Display.image_id = Images.image_id ";
	$sql .= "WHERE Albums.album_id=$album_id";
	
	
	
	
	
//	$query .= " LIMIT $offset, $per_page;";
	$result = $mysqli->query($sql);
	$all_rows = $result->fetch_all( MYSQLI_ASSOC );
	$response = array('images' => $all_rows, );
	print(json_encode( $response ) );
	die();
	
?>