<!-- 97044742 -->
<!-- Tim Daniëls -->
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="stylesheet" href="style.css">
		<link rel="stylesheet" href="bootstrap.min.css">
</head>
<body>
	<header>
		<a href="javascript:history.back(1)"><h1>PowerJobs vacaturebank</h1></a>
		<ul>
			<li><a href="javascript:history.back(1)">Terug</a></li>
			<li><a href="logout.php">Log uit</a></li>
		</ul>
	</header>
	<div class="inleiding center">
		<p>Wijzig hier uw persoonlijke gegevens. Kies een niewe naam of wachtwoord. Of allbei. Nadat uw gegevens zijn gewijzigd wordt u verzocht om opnieuw in te loggen.</p>
	</div>
	<form name="formulier" method="POST">
		<h2>Profiel wijzigen:</h2>
		<p>Nieuwe gebruikersnaam:</p>
		<input required type="text" name="naam" placeholder="..."/>
		<p>Nieuw wachtwoord:</p>
		<input required type="password" name="password" placeholder="..."/>
		<div class="row">
			<div class="col-6">
				<input type="submit" name="wijzigen" value="Wijzigen" class="btn" onclick="alert('De gegevens zijn gewijzigd!');"/>
			</div>
				<a href="javascript:history.back(1)">
				<div class="col-6">
					<input type="button" name="terug" value="Terug" class="btn float-right"/>
				</div>
			</a>
		</div>
	</form>

</body>
</html>
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
	session_start();
	$email = $_SESSION["email"];
	if(isset($_POST["wijzigen"]) ) {
		$naam = $_POST["naam"];
		$password = $_POST["password"];
		$query = "UPDATE users SET naam = '$naam', wachtwoord = '$password' WHERE email = '$email'";
		$insert = $database->prepare($query);
		$data = array();
		try {
			$insert->execute($data);
			header('Location: login.php');
		}
		catch(PDOException $e) {
			echo "<script>alert('Er is iets mis gegeaan.');</script>";
		}	
	}
		
?>
				
				
				
				
				
				
				
				
				
				
				
				