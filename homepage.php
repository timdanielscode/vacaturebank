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
		<a href="homepage.php"><h1>PowerJobs vacaturebank</h1></a>
		<ul>
			<li><a href="login.php">Log in</a></li>
			<li><a href="sign-up.php">Aanmelden</a></li>
			<li><a href="wachtwoord.php">Wachtwoord vergeten?</a></li>
		</ul>
	</header>
	<div class="inleiding center">
		<p>Meld je aan als sollicitant en solliciteer op alle openstaande vacatures die door PowerJobs openbaar worden gemaakt. Meld je aan als bedrijf om vacatures te plaatsen. Al een account? <a href="login.php" class="color-white">Log snel in!</a></p>
	</div>
	<form name="formulier" action="" method="POST">
		<h2>Bekijk een aantal openstaande vacatures:</h2>
			<p>De homepagina is openbaar en toont een overzicht van minimaal drie tot zes open vacatures.</p>
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
					$query = "SELECT * FROM vacatures ORDER BY datum ASC";
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
						$count = 0;
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
							$count++;	
							if ($count == 6) break;
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

				
				
				
				
				
				
				
				
				
				
				
				