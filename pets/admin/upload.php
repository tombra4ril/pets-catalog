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
?>
<!DOCTYPE html>
<html>
	<head lang="en">
		<meta charset="utf-8" />
		<link rel="stylesheet" type="text/css" href="../styles/upload.css" />
		<title>Upload Pets File</title>
	</head>

	<body>
		<div id="main-wrapper">
			<header>
				<h1>Upload files less than 1Mb</h1>
			</header>

			<section>
				<article>
					<div id="category">
						
					</div>
					<form method="post" action="process.php" enctype="multipart/form-data">
						<div id="old-category">
							<?php
								//Get the pet categories from the pet type table
								$result = getPetCategories();

								while($row = mysqli_fetch_assoc($result)){
									echo "<input class='old-input' type='radio' checked name='pet-category' value='{$row['type']}' />";
									echo "<label class='old-label'>{$row['type']}</label>";
								}
							?>
						</div>
						<div id="new-category">
							<div id="show-hide">
								<input id="check" type="radio" name="pet-category" value="new" />
								<label>New Category</label>
							</div>
							<fieldset id="hidden">
								<legend>Category:</legend>
								<p>
									<label class="fWidth">Name:</label>
									<input type="text" name="newCategory" placeholder="Enter name" />
								</p>
								<p>
									<label class="fWidth">Description:</label>
									<input type="text" name="newDesc" size="50" placeholder="Enter Short description" />
								</p>
							</fieldset>
						</div>
						<div id="pet-desc">
							<fieldset>
								<legend>Pet Informaton:</legend>
								<p>
									<label class="fWidth">Name:</label>
									<input type="text" name="pet-name" placeholder="Enter name" required />
								</p>
									<label class="fWidth">Description:</label>
									<input type="text" name="pet-desc" size="50" placeholder="Enter Description" required />
								</p>
									<label class="fWidth">Price:</label>
									<input type="number" name="pet-price" placeholder="Enter Price" required />
								</p>
									<label class="fWidth">Picture:</label>
									<input type="file" accept="image/*" name="pet-picture" />
								</p>
								<p>
									<label class="fWidth">Colour(Optional):</label>
									<input type="text" name="pet-colour" placeholder="Enter Colour"/>
								</p>
							</fieldset>
							
						</div>
						<div id="buttons">
							<button>Submit</button>
							<button>Clear</button>
						</div>
					</form>
					<a href="../index.html">Cancel</a>
					<a href="login.php">Log Out</a>
				</article>
			</section>

			<?php
				include("../includes/html/footer.html");
			?>
		</div>
	</body>
	<script type="text/javascript" src="../scripts/show_hide.js"></script>
	<!-- <script type="text/javascript" src="../scripts/validate_form.js"></script> -->
</html>