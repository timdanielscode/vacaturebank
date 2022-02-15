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
			<li><a href="homepage-admin.php">Home</a></li>
			<li><a href="admin-sollicitanten.php">Sollicitanten</a></li>
			<li><a href="admin-bedrijven.php">Bedrijven</a></li>
			<li><a href="admin-sollicitanten-vacature.php">Sollicitanten per vacature</a></li>
			<li><a href="logout.php">Log uit</a></li>
		</ul>
	</header>
	<div class="inleiding center">
		<p>Op de vacaturepagina kunt u als admin CRUD toepassen. Klik op CREATE om nieuwe vacature toe te voegen, klik op READ om een tabel te bekijken met alle vacatures, klik UPDATE om gegevens aan te passen van vacature en klik DELETE om vacatures te verwijderen.</p>
	</div>
	<form name="formulier" action="" method="POST">
		<h2>Bekijk de vacaturetabel:</h2>
			<p>Klik op create om een vacature toe te voegen, read voor een overzicht van vacatures, update om vacatures aan te passen en delete om een vacature te verwijderen.</p>
		<div class="row buttons">
		</div>
		<div class="row">
			<div class="col-6">
				<input type="submit" name="create" value="Create" class="btn"/>	
			</div>
			<div class="col-6">
				<input type="submit" name="read" value="Read" class="btn"/>
			</div>
		</div>
		<div class="row">
			<div class="col-6">
				<input type="submit" name="update" value="Update" class="btn"/>	
			</div>
			<div class="col-6">
				<input type="submit" name="delete" value="Delete" class="btn"/>
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
				if(isset($_POST["read"])) {
					echo "<h3>Zie hier vacatures:</h3>";
					$query = "SELECT * FROM vacatures ORDER BY datum ASC, bedrijf ASC, vacature ASC";
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
									<th>Commissie</th>
									<th>email</th>
								</tr>";	
						foreach($vacatures as $vacature) {
							echo 
								"<tr>
									<td>"; 
										print_r($vacature['bedrijf']); 
									echo  "</td>"; 
									echo "<td>"; 
										print_r($vacature['vacature']); 
									echo  "</td>"; 
									echo "<td>"; 
										print_r($vacature['functie']); 
									echo  "</td>"; 
									echo "<td>"; 
										print_r($vacature['datum']); 
									echo  "</td>"; 
									echo "<td>"; 
										print_r($vacature['commissie']); 
									echo  "</td>"; 
									echo "<td>"; 
										print_r($vacature['email']); 
									echo  "</td>"; 
								"</tr>";	
						} 		
						echo "</table>";
					}
					catch(PDOException $e) {
						echo "<script>alert('Er is iets mis gegaan.');</script>";
					}
				}
				if(isset($_POST["create"])) {
					$query = "SELECT DISTINCT bedrijf FROM vacatures";
					$insert = $database->prepare($query);
					try {
						$insert->execute(array());
						$insert->setFetchMode(PDO::FETCH_ASSOC);
						$updateArray = array();
						foreach($insert as $value) {
							$update = $value['bedrijf'];
							array_push($updateArray, $update);
						}
					}
					catch(PDOException $e) {
						echo "<script>alert('Er is iets mis gegeaan');</script>";
					}	
					echo '<form name="formulier" method="POST">
					<h3>Vacature aanmaken:</h3>
					<p>Kies een bedrijf:</p>
					<select name="bedrijf-UPDATE" class="delete"><option></option>';
					foreach( $updateArray as $val){
						print "<option>";
						print($val);	
						echo "</option>";
					}
					echo '
					</select>';
					echo '<div class="row margin-top">
							<div class="col-6">
								<input type="submit" name="kies4" value="Kies" class="btn"/>
							</div>
							<div class="col-6">
								<input type="submit" name="annuleren" value="Annuleren" class="btn"/>
							</div>
						</div>
					</form>';
				}
				if(isset($_POST["kies4"]) ) {
					session_start();
					$_SESSION["bedrijf-UPDATE"] = $_POST["bedrijf-UPDATE"];
					echo '<form name="formulier" method="POST">
					<p>Functie:</p>
					<input type="text" name="functie" placeholder="..."/>
					<p>Commissie:</p>
					<input type="text" name="commissie" placeholder="..."/>
					<div class="row">
						<div class="col-6">
							<input type="submit" name="aanmaken" value="Aanmaken" class="btn"/>
						</div>
						<div class="col-6">
							<input type="submit" name="annuleren" value="Annuleren" class="btn"/>
						</div>
					</div>
					</form>';
				}
				if(isset($_POST["aanmaken"]) ) {
					session_start();
					$bedrijfUpdate = $_SESSION["bedrijf-UPDATE"];
					$query2 = "SELECT MAX(vacature) FROM vacatures WHERE bedrijf = '$bedrijfUpdate'";
					$insert2 = $database->prepare($query2);
					$data = array();
					try {
						$insert2->execute($data);				
						foreach($insert2 as $value) {
							$_SESSION['counter'] = $value["MAX(vacature)"];
							$_SESSION['counter']++; 	
						}
					}
					catch(PDOException $e) {
						echo "<script>alert('Er is iets mis gegaan.');</script>";
					}	
					$query3 = "SELECT email FROM users WHERE naam = '$bedrijfUpdate'";
					$insert3 = $database->prepare($query3);
					$data = array();
					try {
						$insert3->execute($data);				
						foreach($insert3 as $value3) {
							$_SESSION["emailUPDATE"] = $value3["email"];
						}
					}
					catch(PDOException $e) {
						echo "<script>alert('Er is iets mis gegaan');</script>";
					}					
					$datum = date_create("now");
					$datum = date_format($datum, "d-m-Y");
					$query = "INSERT INTO vacatures (bedrijf,vacature,functie,datum,commissie, email) values (?,?,?,?,?,?)";
					$insert = $database->prepare($query);
					$data = array("$bedrijfUpdate", "$_SESSION[counter]", "$_POST[functie]", "$datum", "$_POST[commissie]", "$_SESSION[emailUPDATE]");
					try {
						$insert->execute($data);
						echo "<script>alert('uw heeft een nieuwe vacature aangemaakt voor: $bedrijfUpdate.');</script>";
					}
					catch(PDOException $e) {
						echo "<script>alert('Er is iets mis gegeaan.');</script>";
					}	
				}
				if(isset($_POST["update"]) ) {
					$query = "SELECT DISTINCT bedrijf FROM vacatures ORDER BY bedrijf ASC";
					$insert = $database->prepare($query);
					try {
						$insert->execute(array());
						$insert->setFetchMode(PDO::FETCH_ASSOC);
						$updateArray = array();
						$updateArray2 = array();
						foreach($insert as $value) {
							$update = $value['bedrijf'];
							array_push($updateArray, $update);
						}
					}
					catch(PDOException $e) {
						echo "<script>alert('Er is iets mis gegeaan.');</script>";
					}	
					echo '<form name="formulier" method="POST">
					<h3>Vacatures aanpassen:</h3>
					<p>Kies een bedrijf:</p>
					<select name="bedrijf-UPDATE"><option></option>';
					foreach( $updateArray as $val){
						print "<option>";
						print($val);	
						echo "</option>";
					}
					echo '
					</select>';
					echo '<div class="row margin-top">
							<div class="col-6">
								<input type="submit" name="kies" value="Kies" class="btn"/>
							</div>
							<div class="col-6">
								<input type="submit" name="annuleren" value="Annuleren" class="btn"/>
							</div>
						</div>
					</form>';
				}
				if(isset($_POST["kies"])) {
					session_start();
					$_SESSION["bedrijf-UPDATE"] = $_POST["bedrijf-UPDATE"];
					$bedrijfUPDATE = $_SESSION["bedrijf-UPDATE"];
					$query = "SELECT vacature FROM vacatures WHERE bedrijf='$bedrijfUPDATE' ORDER BY vacature ASC";
					$insert = $database->prepare($query);
					try {
						$insert->execute(array());
						$insert->setFetchMode(PDO::FETCH_ASSOC);
						$updateArray2 = array();
						foreach($insert as $value) {
							$update2 = $value['vacature'];
							array_push($updateArray2, $update2);
						}	
					}
					catch(PDOException $e) {
						echo "<script>alert('Er is iets mis gegeaan.');</script>";
					}	
					echo '<form name="formulier" method="POST">
					<p>Kies een vacature nummer:</p>
					<select name="vacature-UPDATE"><option></option>';
					foreach( $updateArray2 as $val){
						print "<option>";
						print($val);	
						echo "</option>";
					}
					echo '
					</select>';
					echo '<div class="row margin-top">
							<div class="col-6">
								<input type="submit" name="kies2" value="Kies" class="btn"/>
							</div>
							<div class="col-6">
								<input type="submit" name="annuleren" value="Annuleren" class="btn"/>
							</div>
						</div>
					</form>';
				}
				if(isset($_POST["kies2"])) {
					session_start();
					$_SESSION["vacature-UPDATE"] = $_POST["vacature-UPDATE"];
					echo '<form name="formulier" method="POST">
					<h3>Bedrijf accounts aanpassen:</h3>
					<p>Kies een nieuwe bedrijfsnaam:</p>
					<input type="text" name="bedrijfsnaam" placeholder="..."/>
					<p>Kies een nieuw vacaturenummer:</p>
					<input type="text" name="vacaturenummer" placeholder="..."/>
					<p>Kies een nieuwe functie:</p>
					<input type="text" name="functie-UPDATE" placeholder="..."/>
					<p>Kies een nieuwe commissie:</p>
					<input type="text" name="commissie-UPDATE" placeholder="..."/>
					<p>Kies een nieuwe email:</p>
					<input type="email" name="email-UPDATE" placeholder="..."/>					
					<div class="row">
						<div class="col-6">
							<input type="submit" name="aanpassen" value="Aanpassen" class="btn"/>
						</div>
						<div class="col-6">
							<input type="submit" name="annuleren" value="Annuleren" class="btn"/>
						</div>
					</div></form>';	
				}
				if(isset($_POST["aanpassen"])) {
					session_start();
					$bedrijfUPDATE = $_SESSION["bedrijf-UPDATE"];
					$vacatureUPDATE = $_SESSION["vacature-UPDATE"];
					$bedrijfsnaam = $_POST["bedrijfsnaam"];
					$vacaturenummer = $_POST["vacaturenummer"];
					$functieUPDATE = $_POST["functie-UPDATE"];
					$commissieUPDATE = $_POST["commissie-UPDATE"];
					$emailUPDATE = $_POST["email-UPDATE"];
					$query = "UPDATE vacatures SET bedrijf='$bedrijfsnaam', vacature='$vacaturenummer', functie='$functieUPDATE', commissie='$commissieUPDATE', email='$emailUPDATE' WHERE (bedrijf = '$bedrijfUPDATE' AND vacature = '$vacatureUPDATE')";
					$insert = $database->prepare($query);
					$data = array("$bedrijfsnaam", "$vacaturenummer", "$functieUPDATE", "$commissieUPDATE", "$emailUPDATE");
					try {
						$insert->execute($data);
						echo "<script>alert('uw heeft account: aangepast.');</script>";
					}
					catch(PDOException $e) {
						echo "<script>alert('Er is iets mis gegeaan.');</script>";
					}	
				}
				if(isset($_POST["delete"]) ) {
					$query = "SELECT DISTINCT bedrijf FROM vacatures ORDER BY bedrijf ASC";
					$insert = $database->prepare($query);
					try {
						$insert->execute(array());
						$insert->setFetchMode(PDO::FETCH_ASSOC);
						$updateArray = array();
						foreach($insert as $value) {
							$update = $value['bedrijf'];
							array_push($updateArray, $update);
						}
					}
					catch(PDOException $e) {
						echo "<script>alert('Er is iets mis gegeaan.');</script>";
					}	
					echo '<form name="formulier" method="POST">
					<h3>Vacatures verwijderen:</h3>
					<p>Kies een bedrijf:</p>
					<select name="bedrijf-DELETE"><option></option>';
					foreach( $updateArray as $val){
						print "<option class='delete'>";
						print($val);	
						echo "</option>";
						}
					echo '
					</select>
					<div class="row margin-top">
						<div class="col-6">
							<input type="submit" name="kies3" value="Kies" class="btn"/>
						</div>
						<div class="col-6">
							<input type="submit" name="annuleren" value="Annuleren" class="btn"/>
						</div>
					</div>
					</form>';
				}
				if(isset($_POST["kies3"]) ) {
					session_start();
					$_SESSION["bedrijf-DELETE"] = $_POST["bedrijf-DELETE"];
					$bedrijfDELETE = $_SESSION["bedrijf-DELETE"];
					$query = "SELECT vacature FROM vacatures WHERE bedrijf='$bedrijfDELETE' ORDER BY vacature ASC";
					$insert = $database->prepare($query);
					try {
						$insert->execute(array());
						$insert->setFetchMode(PDO::FETCH_ASSOC);
						$updateArray2 = array();
						foreach($insert as $value) {
							$update2 = $value['vacature'];
							array_push($updateArray2, $update2);
						}
					}
					catch(PDOException $e) {
						echo "<script>alert('Er is iets mis gegeaan.');</script>";
					}	
					echo '<form name="formulier" method="POST">
					<h3>Bedrijf accounts aanpassen:</h3>
					<p>Kies een vacature nummer:</p>
					<select name="vacature-DELETE"><option></option>';
					foreach( $updateArray2 as $val){
						echo "<option>";
						print($val);	
						echo "</option>";
					}
					echo '
					</select>';
					echo '<div class="row margin-top">
							<div class="col-6">
								<input type="submit" name="verwijderen" value="Verwijder" class="btn"/>
							</div>
							<div class="col-6">
								<input type="submit" name="annuleren" value="Annuleren" class="btn"/>
							</div>
						</div>
					</form>';
				}
				if(isset($_POST["verwijderen"]) ) {
					session_start();
					$bedrijfDELETE = $_SESSION["bedrijf-DELETE"];
					$vacatureDELETE = $_POST["vacature-DELETE"];
					$query = "DELETE FROM vacatures WHERE (bedrijf = '$bedrijfDELETE' AND vacature = '$vacatureDELETE')";
					$insert = $database->prepare($query);
					$data = array();
					try {
						$insert->execute($data);
						echo "<script>alert('uw heeft de vacature van bedrijf: $bedrijfDELETE met als vacaturenummer: $vacatureDELETE verwijderd.');</script>";
					}
					catch(PDOException $e) {
						echo "<script>alert('Er is iets mis gegeaan.');</script>";
					}	
				}
			?>		
	</form>
</body>
</html>

				
				
				
				
				
				
				
				
				
				
				
				