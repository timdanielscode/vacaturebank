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
			<li><a href="admin-sollicitanten.php">Sollicitanten</a></li>
			<li><a href="admin-vacatures.php">Vacatures</a></li>
			<li><a href="logout.php">Log uit</a></li>
		</ul>
	</header>
	<div class="inleiding center">
		<p>Op de sollicitantenspagina per vacature kunt u als admin CRUD toepassen. Klik op CREATE om nieuwe sollicitanten aan te melden aan een vacature, klik op READ om een tabel te bekijken met alle sollicitanten die gereageerd hebben op een vacature, klik UPDATE om gegevens aan te passen van sollicitanten die zich hebben op een vacature hebben gereageerd en klik DELETE om sollicitanten van een vacature te verwijderen.</p>
	</div>
	<form name="formulier" action="" method="POST">
		<h2>Bekijk de sollicitanten per vacature:</h2>
			<p>Klik op create om een sollicitant aan een vacature aan te melden, read voor een overzicht van sollicitanten die gesolliciteerd hebben op een vacature, update om gegevens aan te passen en delete om een sollicitant van een vacature te verwijderen.</p>
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
					echo "<h3>Zie hier sollicitanten per vacature:</h3>";
					$query = "SELECT sollicitant, bedrijf, vacature FROM sollicitatiehistory ORDER BY sollicitant ASC, bedrijf ASC, vacature ASC";
					$vacatures = $database->prepare($query);
					try {
						$vacatures->execute(array());
						$vacatures->setFetchMode(PDO::FETCH_ASSOC);
						echo "<table align='center' class='homepage-table'>
								<tr>
									<th>Sollicitant</th>
									<th>Bedrijf</th>
									<th>Vacature</th>
								</tr>";	
						foreach($vacatures as $vacature) {
							echo 
								"<tr>
									<td>"; 
										print_r($vacature['sollicitant']); 
									echo  "</td>"; 
									echo "<td>"; 
										print_r($vacature['bedrijf']); 
									echo  "</td>"; 
									echo "<td>"; 
										print_r($vacature['vacature']); 
									echo  "</td>"; 
								"</tr>";	
						} 		
						echo "</table>";
					}
					catch(PDOException $e) {
						echo "<script>alert('Er is iets mis gegaan.');</script>";
					}
				}
				if(isset($_POST["create"]) ) {
					$query = "SELECT DISTINCT naam FROM users WHERE soort = 'sollicitant'";
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
						echo "<script>alert('Er is iets mis gegaan.');</script>";
					}	
					echo '<form name="formulier" method="POST">
					<h3>Sollicitant op een vacature laten reageren:</h3>
					<p>Kies een sollicitant:</p>
					<select name="sollicitant-CREATE" class="delete"><option></option>';
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
					$_SESSION["sollicitant-CREATE"] = $_POST["sollicitant-CREATE"];
					$sollicitantCREATE = $_SESSION["sollicitant-CREATE"];
					$query = "SELECT * FROM vacatures ORDER BY bedrijf ASC, vacature ASC";
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
									$email = $vacature["email"];
									echo "<input hidden type='text' name='email' value='$email'/>";
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
									echo "</td>";
								"</tr>";	
							echo "</form>";	
						}
							echo "</table>";
					}
					catch(PDOException $e) {
						echo "<script>alert('Er is iets mis gegaan.');</script>";
					}	
				}
				if(isset($_POST["reageer"]) ) {
					session_start();
					$sollicitantCREATE = $_SESSION["sollicitant-CREATE"];
					$id = $_POST["id"];
					$bedrijf = $_POST["bedrijf"];
					$vacature = $_POST["vacature"];
					$functie = $_POST["functie"];
					$datum = date_create("now");
					$datum = date_format($datum, "d-m-Y");
					$email = $_POST["email"];
					$query = "INSERT INTO sollicitatiehistory (sollicitant, email, bedrijf, vacature, functie, datum) VALUES (?,?,?,?,?,?)";
					$insert = $database->prepare($query);
					$data = array("$sollicitantCREATE", "$email", "$bedrijf", "$vacature", "$functie", "$datum");						
					try {
						$insert->execute($data);
						echo "<script>alert('Je hebt gereageerd op de vacature!');</script>";
					}
					catch(PDOException $e) {
						echo "<script>alert('Er is iets mis gegaan.');</script>";
					}	
				}	
				if(isset($_POST["aanmaken"]) ) {
					$query = "INSERT INTO sollicitatiehistory (naam,email,wachtwoord,soort) values (?,?,?,?)";
					$insert = $database->prepare($query);
					$data = array("$_POST[naam]", "$_POST[email]", "$_POST[password]", "sollicitant");
					try {
						$insert->execute($data);
						echo "<script>alert('uw heeft $_POST[naam] als sollicitant toegevoegd.');</script>";
					}
					catch(PDOException $e) {
						echo "<script>alert('Er is iets mis gegaan');</script>";
					}	
				}
				if(isset($_POST["update"]) ) {
					$query = "SELECT DISTINCT sollicitant FROM sollicitatiehistory ORDER BY sollicitant ASC";
					$insert = $database->prepare($query);
					try {
						$insert->execute(array());
						$insert->setFetchMode(PDO::FETCH_ASSOC);
						$updateArray = array();
						foreach($insert as $value) {
							$update = $value['sollicitant'];
							array_push($updateArray, $update);
						}
					}
					catch(PDOException $e) {
						echo "<script>alert('Er is iets mis gegaan.');</script>";
					}	
					echo '<form name="formulier" method="POST">
					<h3>Gegevens aanpassen van een sollicitant per vacature:</h3>
					<p>Kies een sollicitant:</p>
					<select name="sollicitant-UPDATE" class="delete"><option></option>';
					foreach( $updateArray as $val){
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
				if(isset($_POST["kies2"]) ) {
					session_start();
					$_SESSION["sollicitant-UPDATE"] = $_POST["sollicitant-UPDATE"];
					$sollicitantUPDATE = $_SESSION["sollicitant-UPDATE"];
					$query = "SELECT DISTINCT bedrijf FROM sollicitatiehistory WHERE sollicitant = '$sollicitantUPDATE' ORDER BY bedrijf ASC";
					$insert = $database->prepare($query);
					$data = array();
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
						echo "<script>alert('Er is iets mis gegaan.');</script>";
					}	
					try {
						$insert->execute($data);
					}
					catch(PDOException $e) {
						echo "<script>alert('Er is iets mis gegaan.');</script>";
					}	
					echo '<form name="formulier" method="POST">
					<p>Kies het bedrijf van de vacature:</p>
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
					$_SESSION["bedrijf-UPDATE"] = $_POST["bedrijf-UPDATE"];
					$bedrijfUPDATE = $_SESSION["bedrijf-UPDATE"];
					$sollicitantUPDATE = $_SESSION["sollicitant-UPDATE"];
					$query = "SELECT DISTINCT vacature FROM sollicitatiehistory WHERE (bedrijf = '$bedrijfUPDATE' AND sollicitant = '$sollicitantUPDATE') ORDER BY vacature ASC";
					$insert = $database->prepare($query);
					$data = array();
					try {
						$insert->execute(array());
						$insert->setFetchMode(PDO::FETCH_ASSOC);
						$updateArray = array();
						foreach($insert as $value) {
							$update = $value['vacature'];
							array_push($updateArray, $update);
						}
					}
					catch(PDOException $e) {
						echo "<script>alert('Er is iets mis gegaan.');</script>";
					}	
					try {
						$insert->execute($data);
					}
					catch(PDOException $e) {
						echo "<script>alert('Er is iets mis gegaan.');</script>";
					}	
					echo '<form name="formulier" method="POST">
					<p>Kies het vacaturenummer:</p>
					<select name="vacaturenummer-UPDATE" class="delete"><option></option>';
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
					$_SESSION["vacaturenummer-UPDATE"] = $_POST["vacaturenummer-UPDATE"];
					$query = "SELECT * FROM vacatures ORDER BY bedrijf ASC, vacature ASC, functie ASC, datum ASC";
					$vacatures = $database->prepare($query);
					try {
						$vacatures->execute(array());
						$vacatures->setFetchMode(PDO::FETCH_ASSOC);
						echo "<table align='center' class='homepagesoliicitant-table'>
								<tr>
									<th>Update</th>
									<th>Bedrijf</th>
									<th>Vacature</th>
									<th>Functie</th>
									<th>Datum</th>
								</tr>";	
						foreach($vacatures as $vacature) {
							echo "<tr>
									<form name='formulier' method='POST' class='form-sollicitant'>";
									echo "<td class='td-reageer'>"; 
									echo "<input type='submit' name='update-vacature' value='Update' class='button-reageer btn'/>";
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
									echo "</td>";
									echo "<td>"; 
										$commissie = $vacature["commissie"];
										echo "<input hidden type='text' name='commissie' value='$commissie'/>";
									echo "</td>"; 
								"</tr>";	
							echo "</form>";	
						}
							echo "</table>";
					}
					catch(PDOException $e) {
						echo "<script>alert('Er is iets mis gegaan.');</script>";
					}	
				}
				if(isset($_POST["update-vacature"]) ) {
					session_start();
					$vacaturenummerUPDATE = $_SESSION["vacaturenummer-UPDATE"];
					$sollicitantUPDATE = $_SESSION["sollicitant-UPDATE"];
					$bedrijfUPDATE = $_SESSION["bedrijf-UPDATE"];				
					$bedrijf = $_POST["bedrijf"];
					$vacature = $_POST["vacature"];
					$functie = $_POST["functie"];
					$datum = date_create("now");
					$datum = date_format($datum, "d-m-Y");
					$commissie = $_POST["commissie"];
					$query = "UPDATE sollicitatiehistory SET bedrijf='$bedrijf',vacature='$vacature', functie='$functie', datum='$datum', commissie='$commissie' WHERE (sollicitant = '$sollicitantUPDATE' AND bedrijf = '$bedrijfUPDATE' AND vacature = '$vacaturenummerUPDATE')";
					$insert = $database->prepare($query);
					$data = array("$bedrijf", "$vacature", "$functie", "$datum");						
					try {
						$insert->execute($data);
						echo "<script>alert('Je hebt gereageerd op de vacature!');</script>";
					}
					catch(PDOException $e) {
						echo "<script>alert('Er is iets mis gegeaan.');</script>";
					}	
				}	
				if(isset($_POST["delete"]) ) {
					$query = "SELECT DISTINCT sollicitant FROM sollicitatiehistory ORDER BY sollicitant ASC";
					$insert = $database->prepare($query);
					try {
						$insert->execute(array());
						$insert->setFetchMode(PDO::FETCH_ASSOC);
						$updateArray = array();
						foreach($insert as $value) {
							$update = $value['sollicitant'];
							array_push($updateArray, $update);
						}
							
					}
					catch(PDOException $e) {
						echo "<script>alert('Er is iets mis gegaan');</script>";
					}	
					echo '<form name="formulier" method="POST">
					<h3>Sollicitant per vacature verwijderen:</h3>
					<p>Kies een sollicitant:</p>
					<select name="sollicitant-DELETE"><option></option>';
					foreach( $updateArray as $val){
						print "<option class='delete'>";
						print($val);	
						echo "</option>";
						}
					echo '
					</select>
					<div class="row margin-top">
						<div class="col-6">
							<input type="submit" name="kies5" value="Kies" class="btn"/>
						</div>
						<div class="col-6">
							<input type="submit" name="annuleren" value="Annuleren" class="btn"/>
						</div>
					</div>
					</form>';
				}
				if(isset($_POST["kies5"]) ) {	
					session_start();
					$_SESSION["sollicitant-DELETE"] = $_POST["sollicitant-DELETE"];
					$sollicitantDELETE = $_SESSION["sollicitant-DELETE"];
					$query = "SELECT DISTINCT bedrijf FROM sollicitatiehistory WHERE sollicitant = '$sollicitantDELETE' ORDER BY bedrijf ASC";
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
						echo "<script>alert('Er is iets mis gegaan.');</script>";
					}	
					echo '<form name="formulier" method="POST">
					<p>Kies een bedrijf:</p>
					<select name="bedrijf-DELETE" class="delete"><option></option>';
					foreach( $updateArray as $val){
						print "<option class='delete'>";
						print($val);	
						echo "</option>";
						}
					echo '
					</select>
					<div class="row margin-top">
						<div class="col-6">
							<input type="submit" name="kies6" value="Kies" class="btn"/>
						</div>
						<div class="col-6">
							<input type="submit" name="annuleren" value="Annuleren" class="btn"/>
						</div>
					</div>
					</form>';
				}
				if(isset($_POST["kies6"]) ) {
					session_start();
					$_SESSION["bedrijf-DELETE"] = $_POST["bedrijf-DELETE"];
					$bedrijfDELETE = $_SESSION["bedrijf-DELETE"];
					$sollicitantDELETE = $_SESSION["sollicitant-DELETE"];
					$query = "SELECT DISTINCT vacature FROM sollicitatiehistory WHERE (bedrijf = '$bedrijfDELETE' AND sollicitant = '$sollicitantDELETE') ORDER BY vacature ASC";
					$insert = $database->prepare($query);
					try {
						$insert->execute(array());
						$insert->setFetchMode(PDO::FETCH_ASSOC);
						$updateArray = array();
						foreach($insert as $value) {
							$update = $value['vacature'];
							array_push($updateArray, $update);
						}
					}
					catch(PDOException $e) {
						echo "<script>alert('Er is iets mis gegaan.');</script>";
					}	
					echo '<form name="formulier" method="POST">
					<p>Kies een vacaturenummer:</p>
					<select name="vacaturenummer-DELETE" class="delete"><option></option>';
					foreach( $updateArray as $val){
						print "<option>";
						print($val);	
						echo "</option>";
						}
					echo '
					</select>
					<div class="row margin-top">
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
					$sollicitantDELETE = $_SESSION["sollicitant-DELETE"];
					$bedrijfDELETE = $_SESSION["bedrijf-DELETE"];
					$vacaturenummerDELETE = $_POST["vacaturenummer-DELETE"];
					$query = "DELETE FROM sollicitatiehistory WHERE (sollicitant = '$sollicitantDELETE' AND bedrijf = '$bedrijfDELETE' AND vacature = '$vacaturenummerDELETE')";
					$insert = $database->prepare($query);
					$data = array();
					try {
						$insert->execute($data);
						echo "<script>alert('uw heeft account:  verwijderd.');</script>";
					}
					catch(PDOException $e) {
						echo "<script>alert('Er is iets mis gegaan.');</script>";
					}	
				}
			?>		
	</form>
</body>
</html>

				
				
				
				
				
				
				
				
				
				
				
				