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
			<li><a href="homepage-sollicitant.php">Terug</a></li>
		</ul>
	</header>
	<div class="inleiding center">
	<p class='ingelogd'>Bekijk uw sollicitaties hieronder.</p>
	</div>
	<div class="formulier-vacatures">
		<form name="formulier" method="POST" class="form-sollicitant">
			<h2 class="center">Bekijk uw sollicitatie history:</h2>
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
						session_start();
						$email = $_SESSION["email"];
						$query = "SELECT * FROM sollicitatiehistory WHERE email = '$email' ORDER BY datum ASC, bedrijf ASC, vacature ASC, functie ASC";
						$vacatures = $database->prepare($query);

						try {
							$vacatures->execute(array());
							$vacatures->setFetchMode(PDO::FETCH_ASSOC);
							echo "<table align='center' class='homepagesoliicitant-table'>
									<tr>
										<th>Sollicitant</th>
										<th>Bedrijf</th>
										<th>Vacature</th>
										<th>Functie</th>
										<th>Datum</th>
										<th>Commissie</th>
									</tr>";	

							foreach($vacatures as $vacature) {
								echo "<tr>";
									echo "<form name='formulier' method='POST'>";
										echo "<td>";
											print_r($vacature["sollicitant"]);
										echo  "</td>"; 
										echo "<td>";
											print_r($vacature["bedrijf"]);
										echo  "</td>"; 
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
										echo "</td>";
									echo "</form>";	
								echo "</tr>";
							}
							echo "</table>";
						}
						
						catch(PDOException $e) {
							echo "<script>alert('Er is iets mis gegaan.');</script>";
						}
						
					}	
						
				?>	
	</div>
</body>
</html>

				
				
				
				
				
				
				
				
				
				
				
				