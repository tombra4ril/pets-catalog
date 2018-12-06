<?php
//There is a session call in this file so do not echo anything before that call
	//call to session
	session_start();

//check if the user wants to logout
	if($_SESSION["user"] == "authenticated"){
		//Destroy the session completely
		$_SESSION["user"] = "";

		//This is done by using the session_name() function which will let php return the name of the session cookie variable itself
		if(isset($_COOKIE[session_name()])){
			//set the session cookie to an expired time using
			// the time() function minus a certain amount of time 
			setcookie(session_name(), "", time() - 1234, "/"); //The "/" is used to go to the root to make sure that the cookie is gotten
		}

		unset($_SESSION);
		session_destroy();

		//Create the logout display message
		$logout = "Logged out succesfully";
	}

	if(isset($_POST["username"]) && isset($_POST["password"])){
		//Create the message variable 
		$message = "";

		//Files to be included
		//included necessary files to connect to database
		require_once("../includes/php/constants.php");
		require_once("../includes/php/connect_database.php");

		//Include functions used in this file
		include_once("../includes/functions/database/database.php");

		//Get username and password
		$user = $_POST["username"];
		$pass = $_POST["password"];
		$authenticaton = retrieveUserPass($user, $pass);

		//Check if the username and password match the ones in the database
		if(($user == $authenticaton['username']) && ($pass == $authenticaton['password'])){
			//the username and the password match to redirect the user to the next page
			//Create the session variable to hold the authentication
			$_SESSION["user"] = "authenticated";

			// redirect_to("upload.php");
			header("Location: upload.php");
			exit;
		}else{
			$message = "(*) Username or Password Incorrect";
		}
	}else{
		//do nothing and just proceed with the rest of the page, the user just opened the page
		//Set message to display nothing
		$message = "";
	}
?>

<!DOCTYPE html>
<html>
	<head lang="en">
		<meta charset="utf-8" />
		<meta http-equiv="Page-Enter" content="RevealTrans(Duration=30,Transition=23)" />
		<link rel="stylesheet" type="text/css" href="../styles/login.css" />
		<link rel="stylesheet" href="../styles/footer_style.css"/>
		<title>Admin Login</title>
	</head>

	<body>
		<div id="main-wrapper">
			<header>
				<h1>only admin allowed here</h1>
				<h1>please leave this page if you are not an admin to avoid virus infection</h1>
			</header>

			<section>
				
					<?php 
						if(!empty($logout)){
							echo "<div id='hide'><p>{$logout}"; 
							echo "<span onclick='setHidden()'>&times;</span></p></div>";
						}
					?>
				
				<article>
					<img src="../images/admin/img_avatar.png"/>

					<form action="" method="post">
						<span><?php echo $message; ?></span>
						<p>
							<label>username:</label>
							<input type="text" name="username" placeholder="Enter name" />
						</p>
						<p>
							<label>password:</label>
							<input type="password" name="password" placeholder="Enter password"/>
						</p>
						<button type="submit" name="sub" value="next">Next</button>
					</form>
				</article>
				<p>
					<a href="../index.html">Go to Store</a>
				</p>
			</section>

			<?php
				include_once("../includes/html/footer.html");
			?>
		</div>
		<script>
			function setHidden(){
				document.getElementById("hide").style.display = "none";
			}
		</script>
	</body>
</html>