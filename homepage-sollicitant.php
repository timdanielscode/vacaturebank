<!-- 97044742 -->
<!-- Tim Daniëls -->
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" href="style.css">
</head>
<body>	
	<header>
		<a href="homepage-sollicitant.php"><h1>PowerJobs vacaturebank</h1></a>
		<ul>
			<li><a href="profile.php">Profiel wijzigen</a></li>
			<li><a href="logout.php">Log uit</a></li>
		</ul>
	</header>
	<div class="inleiding center">
		<?php session_start(); $naam = $_SESSION["naam"]; echo "<p class='ingelogd'>U bent ingelogd als: <span class='naam'>$naam</span><br><br>Bekijk hier jouw openstaande vaccatures. U kunt nu op de vacatures reageren. Bekijk ook uw sollicitatie geschiedenis om uw reacties in de gaten te houden.</p>"; ?>
	</div>
	<div class="sollicitatie-history-rapport-row">
		<div class="row">
			<div class="col-12">
				<div class="center">
					<a href="sollicitatie-history-rapport.php">
						<input type="button" name="button" value="Sollicitatie history" class="btn">
					</a>
				</div>
			</div>
		</div>
	</div>
	<div class="formulier-vacatures">
		<form name="formulier" method="POST" class="form-sollicitant">
			<h2 class="center">Bekijk de openstaande vacatures:</h2>
			<div class="row">
				<div class="col-6">
					<input type="submit" name="submit" value="Bekijk" class="btn-sollicitant">
				</div>
				<div class="col-6">	
					<input type="submit" name="sluit" value="Sluit" class="btn-sollicitant">
				</div>
			</div>
		</form>
				<?php 
				$dbhost = 'localhost';
				$dbname = 'vacaturebank';
				$user = '';
				$pass = "";
					try {
						$database = new PDO("mysql:host=$dbhost;dbname=$dbname", $user,$pass);
						$database->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					}
					catch(PDOException $e) {
						echo $e->getMessage();
						echo "Verbinding NIET gemaakt.";
					}
					if(isset($_POST["submit"])) {
						$query = "SELECT * FROM vacatures ORDER BY datum ASC, bedrijf ASC, vacature ASC";
						$vacatures = $database->prepare($query);
						try {
							$vacatures->execute(array());
							$vacatures->setFetchMode(PDO::FETCH_ASSOC);
							echo "<table align='center' class='homepagesoliicitant-table'>
									<tr>
										<th>Reageer</th>
										<th>Bedrijf</th>
										<th>Vacature</th>
										<th>Functie</th>
										<th>Datum</th>
									</tr>";	
							foreach($vacatures as $vacature) {
								echo "<tr>
										<form name='formulier' method='POST' class='form-sollicitant'>";
										echo "<td class='td-reageer'>"; 
										echo "<input type='submit' name='reageer' value='Reageer' class='button-reageer btn'/>";
										$id = $vacature['id'];
										
										echo "<input hidden type='text' name='id' value='$id'/>";
										echo "</td>"; 
										echo "<td>"; 
											print_r($vacature['bedrijf']); 
											$bedrijf = $vacature['bedrijf'];
										echo "<input hidden type='text' name='bedrijf' value='$bedrijf'/>";
										echo  "</td>"; 
										echo "<td>";
											print_r($vacature["vacature"]); 
											$vacatureNr = $vacature["vacature"];
											echo "<input hidden type='text' name='vacature' value='$vacatureNr'/>";
										echo "</td>"; 
										echo "<td>"; 
											print_r($vacature["functie"]); 
											$functie = $vacature["functie"];
											echo "<input hidden type='text' name='functie' value='$functie'/>";
										echo "</td>"; 
										echo "<td>"; 
											print_r($vacature["datum"]); 
											$commissie = $vacature["commissie"];
											echo "<input hidden type='text' name='commissie' value='$commissie'/>";											
										echo "</td>";
									echo "</form>";
								"</tr>";									
							}
							echo "</table>";
						}
						catch(PDOException $e) {
							echo "<script>alert('Er is iets mis gegaan.');</script>";
						}
					}
					if(isset($_POST["reageer"]) ) {
						$id = $_POST["id"];
						$bedrijf = $_POST["bedrijf"];
						$vacature = $_POST["vacature"];
						$functie = $_POST["functie"];
						$datum = date_create("now");
						$datum = date_format($datum, "d-m-Y");
						$email = $_SESSION["email"];
						$commissie = $_POST["commissie"];
						$query = "INSERT INTO sollicitatiehistory (sollicitant, email, bedrijf, vacature, functie, datum, commissie) VALUES (?,?,?,?,?,?,?)";
						$insert = $database->prepare($query);
						$data = array("$naam", "$email", "$bedrijf", "$vacature", "$functie", "$datum", "$commissie");						
						try {
							$insert->execute($data);
							echo "<script>alert('Je hebt gereageerd op de vacature!');</script>";
						}
						catch(PDOException $e) {
							echo "<script>alert('Er is iets mis gegeaan');</script>";
						}	
					}	
				?>	
	</div>
</body>
</html>

				
				
				
				
				
				
				
				
				
				
				
				