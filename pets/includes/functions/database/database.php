<?php
//This file is used to do CRUD on the database

//Hanles any query error and sends a corresponding error message
function handle_query_error($result, $message){
	global $link;//Brings into scope the $link(connection) variable

	if(!$result){
		die($message . mysqli_error($link));
	}
}

//Gets the total number of pets in the pets_catalog database
function getTotalNumberPets(){
	global $link;//Brings into scope the $link(connection) variable

	$query = "SELECT COUNT(id)";
	$query .= " AS count_value";
	$query .= " FROM pet";

	$resultSet = mysqli_query($link, $query);
	$errorMessage = "Could not get the total count of the pet table";

	//Handle error if any
	handle_query_error($resultSet, $errorMessage);

	//Get the value from the result set
	$row = mysqli_fetch_assoc($resultSet);
	$field = $row["count_value"];

	//Return the value found
	return $field;
}

//Gets the total number of pets in the pets_catalog database of a specific type
function getNumberTypePets($type){
	global $link;//Brings into scope the $link(connection) variable

	$query = "SELECT COUNT(id)";
	$query .= " AS count_value";
	$query .= " FROM pet";
	$query .= " WHERE type='{$type}'";

	$resultSet = mysqli_query($link, $query);
	$errorMessage = "Could not get the total count of the pet table";

	//Handle error if any
	handle_query_error($resultSet, $errorMessage);

	//Get the value from the result set
	$row = mysqli_fetch_assoc($resultSet);
	$field = $row["count_value"];

	//Return the value found
	return $field;
}

//This function is used check if the user authenticity from the admin table
function retrieveUserPass($user, $pass){
	global $link;//Brings the $link variable into scope

	$query = "SELECT username, password";
	$query .= " FROM admin";
	$query .= " WHERE username='{$user}'";
	$query .= " AND password='{$pass}'";
	$query .= " LIMIT 1";

	$result = mysqli_query($link, $query);

	//Handle error if any
	handle_query_error($result, "Query of admin table for the username and password wrong.");

	$row = mysqli_fetch_assoc($result);
	return $row;
}

//This function is used to get all the pet type from the pettype database
function getPetCategories(){
	global $link;

	$query = "SELECT type ";
	$query .= " FROM pettype";
	$query .= " ORDER BY type ASC";

	//query the database
	$result = mysqli_query($link, $query);

	//Handle error if any
	handle_query_error($result, "Failed to get all the pet types from the pettype table");

	return $result;
}

function insertIntoPetTable($name, $type, $price, $desc, $picture, $newDesc = "", $test = true){
	global $link;

	if(!$test){
		$query = "INSERT INTO pettype SET";
		$query .= " type = '{$type}',";
		$query .= " description = '{$newDesc}'";

		//Query the database
		$result = mysqli_query($link, $query);
	}

	$query = "INSERT INTO pet SET";
	$query .= " name = '{$name}',";
	$query .= " type = '{$type}',";
	$query .= " price = {$price},";
	$query .= " description = '{$desc}',";
	$query .= " picture = '{$picture}'";

	//Query the database
	$result = mysqli_query($link, $query);

	return $result;
}
?>