<?php
	//included necessary files to connect to database
	require_once("../includes/php/constants.php");
	require_once("../includes/php/connect_database.php");

	//Include functions used in this file
	include_once("../includes/functions/database/database.php");
?>
<!DOCTYPE html>
<html>
	<head lang="en">
		<meta charset="utf-8"/>
		<title>Pet Store</title>
		<link rel="stylesheet" href="../styles/catalog_style.css"/>
		<link rel="stylesheet" href="../styles/footer_style.css"/>
	</head>

	<body>
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
							<span>
								Catalog
							</span>
						</li>
					</ul>
				</nav>
			</header>

			<section>
				<article>					
					<div class="pet">
						<form action="show_pets.php" method="get">
							<?php
								//Retrieve all the four initial rows from the database for test
								$query = "SELECT type, description";
								$query .= " FROM pettype";
								$query .= " ORDER BY type";

								$resultSet = mysqli_query($link, $query);

								//Handle error if any
								$error = "Could not retrieve the Pet type and description from the database";
								handle_query_error($resultSet, $error);

								//Create a variable to hold the count of displayed items
								$count = 0;

								while($row = mysqli_fetch_assoc($resultSet)){
									$count = 0;
									echo "<div class='pet-row-name-desc'>";
										echo "<input type='radio' checked name='name' value='{$row['type']}'/>";
										echo "<span class='pet-name'>";
											echo "{$row['type']}";
										echo "</span>";

										echo "<span class='pet-desc'>";
											echo "{$row['description']}";
										echo "</span>";
									echo "</div>";
								}
								echo "<button type='submit' name='q' value='pick'>Choose Pet</button>";
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