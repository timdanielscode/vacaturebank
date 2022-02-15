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
			<li><a href="sollicitanten.php">Sollicitanten</a></li>
			<li><a href="online-vacature.php">Online facaturen</a></li>
			<li><a href="logout.php">Log uit</a></li>
		</ul>
	</header>
	<div class="inleiding center">
		<p>Plaats op deze pagina een vacature.</p>
	</div>
	<form name="formulier"  method="POST">
		<h2>Vacature plaatsen:</h2>
		<p>Functie:</p>
		<input required type="text" name="functie" placeholder="..."/>
		<p>Commissie:</p>
		<input required type="text" name="commissie" placeholder="..."/>
		<div class="row">
			<div class="col-6">
				<input type="submit" name="plaatsen" value="Plaatsen" class="btn" onclick="myFunction()"/>
			</div>
			<div class="col-6">
				<a href="homepage-bedrijf.php">
					<input type="button" name="terug" value="Terug" class="btn float-right"/>
				</a>
			</div>
		</div>
	</form>
</body>
</html>
<?php 
				$dbhost = 'localhost';
				$dbname = 'vacaturebank';
				$user = '';
				$pass = "";
	session_start(); 
	$naam = $_SESSION["naam"];
	$email = $_SESSION["email"];
	$datum = date_create("now");
	$datum = date_format($datum, "d-m-Y");
	$komma = ',';
	try {
		$database = new PDO("mysql:host=$dbhost;dbname=$dbname", $user,$pass);
		$database->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	}
	catch(PDOException $e) {
		echo $e->getMessage();
	}			
	if(isset($_POST["plaatsen"]) ) {
		$commissie = $_POST["commissie"];
		$query2 = "SELECT MAX(vacature) FROM vacatures WHERE email = '$email'";
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
		$query = "INSERT INTO vacatures (bedrijf, vacature, functie, commissie, datum, email) values (?,?,?,?,?,?)";
		$insert = $database->prepare($query);
		$data = array("$naam", "$_SESSION[counter]", "$_POST[functie]","$commissie", "$datum", "$email");
		if( strpos($commissie, $komma) == false ) {
			try {
				$insert->execute($data);
				echo "<script>alert('De vacature is succesvol geplaatst.')</script>";
			}	
			catch(PDOException $e) {
				echo "<script>alert('Er is iets mis gegaan.');</script>";
			}
		} else {
			echo "<script>alert('Gebruik een punt in plaats van een komma.')</script>";
		}
	
	}
?>
				
				
				
				
				
				
				
				
				
				
				
				