<?php
//Call to session
	session_start();

	//Check if the user is duly authenticated else redirect the user back to the login page
	if($_SESSION["user"] != "authenticated"){
		header("Location : login.php");
		exit;
	}

	//Files to be included
	//included necessary files to connect to database
	require_once("../includes/php/constants.php");
	require_once("../includes/php/connect_database.php");

	//Include functions used in this file
	include_once("../includes/functions/database/database.php");

	//Get the post parameters
	$type = $_POST["pet-category"];
	$name = $_POST["pet-name"];
	$desc = $_POST["pet-desc"];
	$price = $_POST["pet-price"];

	//Handling the file upload
	//Get the necessary file details
	$pictureName = $_FILES["pet-picture"]["name"];
	$pictureSize = $_FILES["pet-picture"]["size"];
	$errorCode = $_FILES["pet-picture"]["error"];
	$pictureTempName = $_FILES["pet-picture"]["tmp_name"];

	// var_dump($_FILES["pet-picture"]);
	
	//Where to store the file in the server
	$path = "../images/";
	$fullPath = $path . $pictureName;

	//Handle storage of the file
	//First check for any sort of error
	if($pictureSize >= 1024 * 1000){
		echo "Picture size exceeds 1Mb";
		exit;
	}elseif($errorCode > 0){
		echo "Failed to upload the file";
		exit;
	}elseif(move_uploaded_file($pictureTempName, $fullPath)){
		// echo "Successfull uploaded the file";
	}else{
		echo "Cannot upload file";
		exit;
	}

	if(isset($_POST["pet-colour"])){
		$colour = $_POST["pet-colour"];
	}

	if($type == "new"){
		//Get the new category description
		$typeDesc = $_POST["newDesc"];
		$type = $_POST["newCategory"];
		if(insertIntoPetTable($name, $type, $price, $desc, $pictureName, $typeDesc, false)){
			displayInfo($type, $name, $desc, $price, $fullPath);
		}else{
			header("Location: upload.php");
			exit;
		}

	}elseif(insertIntoPetTable($name, $type, $price, $desc, $pictureName)){
		displayInfo($type, $name, $desc, $price, $fullPath);
	}else{
		header("Location: upload.php");
		exit;
	}

	function displayInfo($type, $name, $desc, $price, $pic){
		global $link;
		echo "<DOCTYPE html>";
		echo "<html>";
			echo "<head>" .
					"<title>Information Submitted</title>" .
					"<link rel='stylesheet' type='text/css' href='../styles/process.css' />" .
				 "</head>";

			echo "<body>";
				echo "<fieldset>";
					echo "<legend>Information Uploaded</legend>";
					echo "<p>";
						echo "<img src='$pic' alt='Picture here' />";
					echo "</p>";
					echo "<p>";
						echo "<label class='name'>Category:</label>";
						echo "<label class='show-value'>{$type}";
					echo "</p>";
					echo "<p>";
						echo "<label class='name'>Name:</label>";
						echo "<label class='show-value'>{$name}";
					echo "</p>";echo "<p>";
						echo "<label class='name'>Description:</label>";
						echo "<label class='show-value'>{$desc}";
					echo "</p>";echo "<p>";
						echo "<label class='name'>Price:</label>";
						echo "<label class='show-value'>{$price}";
					echo "</p>";
				echo "</fieldset>";

				echo "<a href='upload.php'>Add Another</a>";
				echo "<a href='../index.html'>Cancel</a>";
				echo "<a href='login.php'>Logout</a>";
			echo "</body>";
		echo "</html>";
	}
?>

