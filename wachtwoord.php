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
			<li><a href="sign-up.php">Aamelden</a></li>
			<li><a href="login.php">Login</a></li>
		</ul>
		<ul class="terug">
			<li><a href="homepage.php">Terug</a></li>
		</ul>
	</header>
	<div class="inleiding center">
		<p>Op deze pagina kunt u uw wachtwoord opvragen.</p>
	</div>
	<form name="formulier" method="POST">
		<h2>Wachtwoord vergeten?</h2>
		<p>Email:</p>
		<input required type="text" name="email" placeholder="..."/>
		<div class="row">
			<div class="col-6">
				<input type="submit" name="opvragen" value="Opvragen" class="btn"/>
			</div>
			<div class="col-6">
				<a href="homepage.php">
				<input type="button" name="terug" value="Terug" class="btn"/>
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
	try {
		$database = new PDO("mysql:host=$dbhost;dbname=$dbname", $user,$pass);
		$database->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	}
	catch(PDOException $e) {
		echo $e->getMessage();
		echo "Verbinding NIET gemaakt.";
	}			
	if(isset($_POST["opvragen"]) ) {
		$email = $_POST["email"];
		$query = "SELECT wachtwoord FROM users WHERE email = '$email'";
		$insert = $database->prepare($query);
		$data = array();
		try {
			$insert->execute($data);
			foreach($insert as $wachtwoord) {
				$wachtwoord = $wachtwoord["wachtwoord"];		
				echo "<script>alert('uw wachtwoord is: $wachtwoord');</script>";				
			}
		}
		catch(PDOException $e) {
			echo "<script>alert('Er is iets mis gegeaan.');</script>";
		}	
	}
?>
				
				
				
				
				
				
				
				
				
				
				
				