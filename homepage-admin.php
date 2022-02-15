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
		<a href="homepage-admin.php"><h1>PowerJobs vacaturebank</h1></a>
		<ul>
			<li><a href="admin-bedrijven.php">Bedrijven</a></li>
			<li><a href="admin-sollicitanten.php">Sollicitanten</a></li>
			<li><a href="admin-vacatures.php">Vacatures</a></li>
			<li><a href="admin-sollicitanten-vacature.php">Sollicitanten per vacature</a></li>
			<li><a href="logout.php">Log uit</a></li>
		</ul>
	</header>
	<div class="inleiding center">
		<?php session_start(); $naam = $_SESSION["naam"]; echo "<p class='ingelogd'>U bent ingelogd als: <span class='naam'>$naam</span><br><br>Pas CRUD toe op bedrijven, sollicitanten, vacatures en op een sollicitanten per vacatures.</p>"; ?>
	</div>
	<form name="formulier" action="" method="POST">
		<h2>Bekijk openstaande vacatures:</h2>
			<p>U bent ingelogd als admin. Als u op bekijk klikt ziet u de openstaande vacatures.</p>
		<div class="row buttons">
			

		</div>
		<div class="row">
			<div class="col-6">
				<input type="submit" name="submit" value="Bekijk" class="btn"/>	
			</div>
			<div class="col-6">
				<input type="submit" name="sluit" value="Sluit" class="btn"/>
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
					$query = "SELECT * FROM vacatures ORDER BY datum ASC, bedrijf ASC, vacature ASC, functie ASC";
					$vacatures = $database->prepare($query);
					try {
						$vacatures->execute(array());
						$vacatures->setFetchMode(PDO::FETCH_ASSOC);
						echo "<table align='center' class='homepage-table'>
								<tr>
									<th>Bedrijf</th>
									<th>Vacature</th>
									<th>Functie</th>
									<th>Datum</th>
								</tr>";	
						foreach($vacatures as $vacature) {
							echo 
								"<tr>
									<td>"; 
										print_r($vacature['bedrijf']); 
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
								"</tr>";	
						} 		
						echo "</table>";
					}
					catch(PDOException $e) {
						echo "<script>alert('Er is iets mis gegaan.');</script>";
					}
				}
			?>		
	</form>
</body>
</html>

				
				
				
				
				
				
				
				
				
				
				
				