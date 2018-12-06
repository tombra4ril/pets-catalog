<?php
//included necessary files to connect to database
	require_once("../includes/php/constants.php");
	require_once("../includes/php/connect_database.php");

	//Include functions used in this file
	include_once("../includes/functions/database/database.php");

	//Get the id of the picture
	$id = $_GET["id"];

	//Set the file path to the folder of the pictures 
	$path = "../images/";

	//Get the picture name 
	$query = "SELECT picture FROM pet";
	$query .= " WHERE id={$id}";

	$result = mysqli_query($link, $query);

	if($result){
		$item = mysqli_fetch_assoc($result);
		$name = $item["picture"];
	}

	$file = $path . $name;

	if (file_exists($file)) {
	    header('Content-Description: File Transfer');
	    header('Content-Type: application/octet-stream');
	    header('Content-Disposition: attachment; filename="'.basename($file).'"');
	    header('Expires: 0');
	    header('Cache-Control: must-revalidate');
	    header('Pragma: public');
	    header('Content-Length: ' . filesize($file));
	    readfile($file);
	    exit;
	}
?> 