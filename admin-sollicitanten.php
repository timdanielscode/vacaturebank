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
			<li><a href="admin-bedrijven.php">Bedrijven</a></li>
			<li><a href="admin-vacatures.php">Vacatures</a></li>
			<li><a href="admin-sollicitanten-vacature.php">Sollicitanten per vacature</a></li>
			<li><a href="logout.php">Log uit</a></li>
		</ul>
	</header>
	<div class="inleiding center">
		<p>Op de sollicitantenspagina kunt u als admin CRUD toepassen. Klik op CREATE om nieuwe sollicitanten aan te melden, klik op READ om een tabel te bekijken met alle aangemelden sollicitanten, klik UPDATE om gegevens aan te passen van sollicitanten die zich hebben aangemeld en klik DELETE om sollicitanten te verwijderen.</p>
	</div>
	<form name="formulier" action="" method="POST">
		<h2>Bekijk de sollicitantentabel:</h2>
			<p>Klik op create om een sollicitant aan te melden, read voor een overzicht van sollicitanten, update om sollicitantsgegevens aan te passen en delete om een sollicitant te verwijderen.</p>
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
					echo "<h3>Zie hier alle sollicitanten:</h3>";
					$query = "SELECT naam FROM users WHERE soort = 'sollicitant' ORDER BY naam ASC";
					$vacatures = $database->prepare($query);
					try {
						$vacatures->execute(array());
						$vacatures->setFetchMode(PDO::FETCH_ASSOC);
						echo "<table align='center' class='homepage-table'>
								<tr>
									<th>Sollicitanten</th>
								</tr>";	
						foreach($vacatures as $vacature) {
							echo 
								"<tr>
									<td>"; 
										print_r($vacature['naam']); 
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
					echo '<form name="formulier" method="POST">
					<h3>Sollicitanten aanmelden:</h3>
					<p>Naam:</p>
					<input type="text" name="naam" placeholder="..."/>
					<p>E-mail:</p>
					<input type="email" name="email" placeholder="..."/>
					<p>Wachtwoord:</p>
					<input type="password" name="password" placeholder="..."/>
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
					$query = "INSERT INTO users (naam,email,wachtwoord,soort) values (?,?,?,?)";
					$insert = $database->prepare($query);
					$data = array("$_POST[naam]", "$_POST[email]", "$_POST[password]", "sollicitant");
					try {
						$insert->execute($data);
						echo "<script>alert('uw heeft $_POST[naam] als sollicitant toegevoegd.');</script>";
					}
					catch(PDOException $e) {
						echo "<script>alert('Er is iets mis gegeaan.');</script>";
					}	
				}
				if(isset($_POST["update"]) ) {
					$query = "SELECT naam FROM users WHERE soort = 'sollicitant' ORDER BY naam ASC";
					$insert = $database->prepare($query);
					try {
						$insert->execute(array());
						$insert->setFetchMode(PDO::FETCH_ASSOC);
						$updateArray = array();
						foreach($insert as $value) {
							$update = $value['naam'];
							array_push($updateArray, $update);
						}
							
					}
					catch(PDOException $e) {
						echo "<script>alert('Er is iets mis gegeaan.');</script>";
					}	
					echo '<form name="formulier" method="POST">
					<h3>Sollicitant accounts aanpassen:</h3>
					<p>Kies een account:</p>
					<select name="select"><option></option>';
					foreach( $updateArray as $val){
						print "<option>";
						print($val);	
						echo "</option>";
						}
					echo '
					</select>
					<p>Kies een nieuwe naam:</p>
					<input type="text" name="naam" placeholder="..."/>
					<p>Kies een nieuwe email:</p>
					<input type="email" name="email" placeholder="..."/>
					<p>Kies een nieuw wachtwoord:</p>
					<input type="password" name="password" placeholder="..."/>
					<div class="row">
						<div class="col-6">
							<input type="submit" name="aanpassen" value="Aanpassen" class="btn"/>
						</div>
						<div class="col-6">
							<input type="submit" name="annuleren" value="Annuleren" class="btn"/>
						</div>
					</div>
					</form>';	
				}
				if(isset($_POST["aanpassen"]) ) {
					$select = $_POST["select"];
					$naam = $_POST["naam"];
					$email = $_POST["email"];
					$wachtwoord = $_POST["password"];
					$query = "UPDATE users SET naam='$naam', email='$email',wachtwoord='$wachtwoord' WHERE naam = '$select'";
					$insert = $database->prepare($query);
					$data = array("$_POST[naam]", "$_POST[email]", "$_POST[password]");
					try {
						$insert->execute($data);
						echo "<script>alert('uw heeft account: $_POST[select] aangepast.');</script>";
					}
					catch(PDOException $e) {
						echo "<script>alert('Er is iets mis gegeaan.');</script>";
					}	
				}
				if(isset($_POST["delete"]) ) {
					$query = "SELECT naam FROM users WHERE soort = 'sollicitant' ORDER BY naam ASC";
					$insert = $database->prepare($query);
					try {
						$insert->execute(array());
						$insert->setFetchMode(PDO::FETCH_ASSOC);
						$updateArray = array();
						foreach($insert as $value) {
							$update = $value['naam'];
							array_push($updateArray, $update);
						}
					}
					catch(PDOException $e) {
						echo "<script>alert('Er is iets mis gegeaan.');</script>";
					}	
					echo '<form name="formulier" method="POST">
					<h3>Sollicitant accounts verwijderen:</h3>
					<p>Kies een account:</p>
					<select name="select"><option></option>';
					foreach( $updateArray as $val){
						print "<option class='delete'>";
						print($val);	
						echo "</option>";
						}
					echo '
					</select>
					<div class="row margin-top">
						<div class="col-6">
							<input type="submit" name="verwijderen" value="Verwijderen" class="btn"/>
						</div>
						<div class="col-6">
							<input type="submit" name="annuleren" value="Annuleren" class="btn"/>
						</div>
					</div>
					</form>';
				}
				if(isset($_POST["verwijderen"]) ) {
					$select = $_POST["select"];
					$query = "DELETE FROM users WHERE naam = '$select'";
					$query2 = "DELETE FROM sollicitatiehistory WHERE sollicitant = '$select'";
					$insert = $database->prepare($query);
					$insert2 = $database->prepare($query2);
					$data = array();
					$data2 = array();
					try {
						$insert->execute($data);
						$insert2->execute($data);
						echo "<script>alert('uw heeft account: $_POST[select] verwijderd.');</script>";
					}
					catch(PDOException $e) {
						echo "<script>alert('Er is iets mis gegeaan.');</script>";
					}	
				}
			?>		
	</form>
</body>
</html>

				
				
				
				
				
				
				
				
				
				
				
				