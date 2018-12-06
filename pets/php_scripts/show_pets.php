<?php
	//included necessary files to connect to database
	require_once("../includes/php/constants.php");
	require_once("../includes/php/connect_database.php");

	//Include functions used in this file
	include_once("../includes/functions/database/database.php");
?>
<?php
	//This section is used to get and set the necessary data needed to display this page correctly
	//Get the type checked and the button clicked
	$petType = $_GET["name"];
	$button = $_GET["q"];

	//Check if the really exists in the headers sent
	if(!(isset($petType) && isset($button))){
		//Redirect the user back to the catalog.php page
		//Because the necessary data for this page was not set
		header("Location: catalog.php");
		exit;
	}

	//Create variables to hold how many rows are there in the database of a specific type
	$total = getNumberTypePets($petType);

	//Create variable to hold the total number of pets in the database
	$overallTotal = getTotalNumberPets();
		
	//Prepare data to use when the next and previous button is clicked
	if(isset($_POST["newPage"])){
		$rows = $_POST["rows"];

		if($_POST["newPage"] == "next"){//When the previous button is clicked
			$start = $_GET["stop"];
			$stop = $_GET["stop"] + $rows;
		}elseif($_POST["newPage"] == "previous"){
			$stop = $_GET["start"];
			$start = $stop  - $rows;
		}else{
			//Do nothing for now
		}
	}else{
		if(isset($_POST["rows"]) || isset($_GET["rows"])){
			if(isset($_POST["rows"])){
				$rows = $_POST["rows"];
			}else{
				$rows = $_GET["rows"];
			}
		}else{
			$rows = 2;
		}
		
		$_GET["stop"] = $rows;

		//Where to start and stop getting data from the database
		$start = 0;
		$stop = $start + $rows;
	}
?>

<!DOCTYPE html>
<html>
	<head lang="en">
		<meta charset="utf-8"/>
		<title>Pet Store</title>
		<link rel="stylesheet" href="../styles/catalog_style.css"/>
		<link rel="stylesheet" href="../styles/footer_style.css"/>
		<script type="text/javascript" src="../scripts/pets_scripts.js"></script>
	</head>

	<body>
		<!-- Create an hidden span for the larger picture -->
		<div id="hidden">
			<div>
				<span onclick="close_image()">&times;</span>
				<img />
			</div>
		</div>

		<div id="main-wrapper">
			<header>
				<div class="title">
					<h1>pet catalog</h1>
				</div>
				<nav>
					<ul>
						<li><a href="../index.html">Home</a></li>
						<li>
							<span class="arrow-image">
								<img src="../images/icons/arrow-r.jpg" alt="arrow image"/>
							</span>
							<a href="../php_scripts/catalog.php">Catalog</a>
						</li><li>
							<span class="arrow-image">
								<img src="../images/icons/arrow-r.jpg" alt="arrow image"/>
							</span>
							<?php echo "{$petType}"; ?>
						</li>
					</ul>
				</nav>
			</header>

			<section>
				<article>					
					<div class="pet">
						<form id="form" action=<?php echo $_SERVER["SCRIPT_NAME"] . "?name={$_GET['name']}&q={$_GET['q']}&start={$start}&stop={$stop}&rows={$rows}"; ?> method="POST">
							<?php
								$startCount = $start + 1;
								$stopCount = $start + $rows;

								//Use the appropraite number if the $stopCount variable is bigger than the total
								if($stopCount > $total){
									$stopCount = $total;
								}
								echo "<div id='show'>";
									echo "<p class='count'>Showing <span class='make-bold'>";
										echo $startCount;
										echo " - ";
										echo $stopCount;
										// echo " - {$stop}";
									echo "</span></p>";
							?>
							<?php
								//This section is used to display the select tag and its options
								echo "<select id='select' name='rows'>";
									//Option for 2
									echo "<option class='option' value='2'";
										if(isset($rows) & $rows == 2){
											echo " selected";
										}
										echo ">2</option>";

									//Option for 4
									echo "<option class='option' value='4'";
										if(isset($rows) & $rows == 4){
											echo " selected";
										}
										echo ">4</option>";

									//Option for 8
									echo "<option class='option' value='8'";
										if(isset($rows) & $rows == 8){
											echo " selected";
										}
										echo ">8</option>";
								echo "</select>";
								?>
								

								<button id="button-reload" type="submit"><img src="../images/icons/ico_reload.png"></button>
								<!-- <script type="text/javascript" src="../scripts/reload_display.js"></script> -->
							</div>
							<?php
								//Retrieve all the four initial rows from the database for test
								$query = "SELECT *";
								$query .= " FROM pet";
								$query .= " WHERE type='{$petType}'";
								// $query .= " ORDER BY name";
								$query .= " LIMIT {$start}, {$rows}";

								$resultSet = mysqli_query($link, $query);

								//Handle error if any
								$error = "Could not retrieve the Pet details from the pet table";
								handle_query_error($resultSet, $error);

								//Create a variable to hold the count of displayed items
								$count = 0;

								//Create a variable to hold the image path
								$imagePath = "../images/";

								while($row = mysqli_fetch_assoc($resultSet)){
									$count = 0;
									echo "<div class='pet-row-name-desc'>";
										//Echo the id column
										echo "<span class='pet-id'>";
											echo "{$row['id']}";
										echo "</span>";

										//Echo the name column
										echo "<span class='pet-name'>";
											echo "{$row['name']}";
										echo "</span>";

										//Echo the description column
										echo "<span class='pet-desc'>";
											echo "{$row['description']}";
										echo "</span>";

										//Echo the picture column
										$image = $imagePath . $row["picture"];//Picture path
										echo "<span class='pet-picture'>";
											echo "<img src='{$image}' alt='Image here' onclick=display_hidden_picture('{$image}') title='Click to view large image' />";
											echo "<p><a href='download.php?id={$row["id"]}' title='Click to Download'>Download</a></p>";
										echo "</span>";

										//Echo the price column
										echo "<span class='pet-price'>";
											echo "{$row['price']}";
										echo "</span>";
									echo "</div>";
								}
								echo "<div id='button-next-previous'>";
									//Previous button
									echo "<button type='submit' name='newPage' value='previous'";
									//Change the enabled attribute of the button above if this condition is met 
									if($start < 2){
										echo " disabled";
									}
									echo "><< Previous</button>";

									//Next button
									echo "<button type='submit' name='newPage' value='next'";
									//Change the enabled attribute of the button above if this condition is met 
									if($stop > $total - 1){
										echo " disabled";
									}
									//This section of php file is used to display the range of pets displayed
									echo ">>> Next</button>";
								echo "</div>";
							?>
						</form>
					</div>
				</article>
			</section>

			<?php
				include_once("../includes/html/footer.html");
			?>
		</div>
	</body>
</html>