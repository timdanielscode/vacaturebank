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
			<li><a href="login.php">Online facaturen</a></li>
			<li><a href="login.php">Advertentie plaatsen</a></li>
			<li><a href="logout.php">Log uit</a></li>
		</ul>
	</header>
	<div class="inleiding center">
		<p>Bekijk op deze pagina de sollicitanten die op gerageerd hebben op uw vacatures.</p>
	</div>
	<form name="formulier" action="" method="POST">
	<h2>Bekijk deelnemende sollicitanten:</h2>
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
					session_start();
					$bedrijf = $_SESSION['bedrijf'];
					$query = "SELECT * FROM sollicitatiehistory WHERE bedrijf = '$bedrijf' ORDER BY datum ASC, vacature ASC, sollicitant ASC";
					$vacatures = $database->prepare($query);
					try {
						$vacatures->execute(array());
						$vacatures->setFetchMode(PDO::FETCH_ASSOC);
						echo "<table align='center' class='bedrijf-table'>
								<tr>
									<th>Vacature</th>
									<th>Sollicitant</th>
									<th>Functie</th>
									<th>Datum</th>
								</tr>";	
						foreach($vacatures as $vacature) {
							echo 
								"<tr> 
									<td>";
										print_r($vacature["vacature"]); 
									echo "</td>"; 
									echo "<td>"; 
										print_r($vacature["sollicitant"]); 
									echo "</td>"; 
									echo "<td>"; 
										print_r($vacature["functie"]); 
									echo "</td>"; 
									echo "<td>"; 
										print_r($vacature["datum"]); 
									echo "</td>";
								echo "</tr>";	
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

				
				
				
				
				