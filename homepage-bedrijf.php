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
		<a href="homepage-bedrijf.php"><h1>PowerJobs vacaturebank</h1></a>
		<ul>
			<li><a href="profile.php">Profiel wijzigen</a></li>
			<li><a href="logout.php">Log uit</a></li>
		</ul>
	</header>
	<div class="inleiding center">
		<?php session_start(); $naam = $_SESSION["naam"]; echo "<p class='ingelogd'>U bent ingelogd als: <span class='naam'>$naam</span><br><br>U kunt nu advertenties plaatsen en ze bekijken. Bekijk ook sollicitanten die op jouw vacature hebben gesoliciteerd. Zie ook facatures van andere bedrijven.</p>"; ?>
	</div>
	<div class="homepage-buttons-row">
		<div class="row">
			<div class="col-4">
				<a href="sollicitanten.php">
					<div class="center">
						<input type="button" name="button" value="Sollicitanten" class="btn">
					</div>
				</a>
			</div>
			<div class="col-4">
				<a href="online-vacaturen.php">
					<div class="center">
						<input type="button" name="button" value="Online facaturen" class="btn">
					</div>
				</a>
			</div>
			<div class="col-4">
				<a href="vacature-plaatsen.php">
					<div class="center">
						<input type="button" name="button" value="Advertentie plaatsen" class="btn">
					</div>
				</a>
			</div>	
		</div>
	</div>
	<form name="formulier" action="" method="POST">
		<h2>Bekijk mijn vacatures:</h2>
		<div class="row">
			<div class="col-6">
				<input type="submit" name="submit" value="Bekijk" class="btn">
			</div>
			<div class="col-6">	
				<input type="submit" name="sluit" value="Sluit" class="btn">
			</div>
		</div>
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
					$email = $_SESSION["email"];
					$query = "SELECT * FROM vacatures WHERE email = '$email' ORDER BY datum ASC, bedrijf ASC, vacature ASC";
					$vacatures = $database->prepare($query);
					try {
						$vacatures->execute(array());
						$vacatures->setFetchMode(PDO::FETCH_ASSOC);
						echo "<table align='center' class='bedrijf-table'>
								<tr>
									<th>Bedrijf</th>
									<th>Vacature</th>
									<th>Functie</th>
									<th>Datum</th>
									<th>Commissie</th>
								</tr>";	
						foreach($vacatures as $vacature) {
							echo 
								"<tr>
									<td>";
										print_r($vacature["bedrijf"]); 
									echo "</td>";
									echo "<td>";
										print_r($vacature["vacature"]); 
									echo "</td>"; 
									echo "<td>"; 
										print_r($vacature["functie"]); 
									echo "</td>"; 
									echo "<td>"; 
										print_r($vacature["datum"]); 
									echo "</td>";
									echo "<td>";
										print_r($vacature["commissie"]); 
									echo "</td>
								</tr>";	
						}
						echo "</table>";
					}
					catch(PDOException $e) {
						echo "<script>alert('Er is iets mis gegeaan.');</script>";
					}
				}
			?>		
	</form>
</body>
</html>

				
				
				
				
				
				
				
				
				
				
				
				