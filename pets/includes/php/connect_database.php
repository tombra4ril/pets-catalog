<?php
	//Connect to the database
	$link = mysqli_connect(HOST, USERNAME, PASSWORD, DB);

	//Handle possible error if connection failed
	if(!$link){
		die("Error: Could not connect" . mysqli_error($link));
	}
?>