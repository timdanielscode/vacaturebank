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
			<li><a href="sign-up.php">Aanmelden</a></li>
		</ul>
		<ul class="terug">
			<li><a href="homepage.php">Terug</a></li>
		</ul>
	</header>
	<form name="formulier" action="" method="POST">
		<h2>Inloggen:</h2>
		<p>E-mail:</p>
		<input required type="text" name="email" placeholder="..."/>
		<p>Wachtwoord:</p>
		<input required type="password" name="password" placeholder="..."/>
		<div class="row">
			<div class="col-6">
				<a href="inloggen.php">
					<input type="submit" name="submit" value="Inloggen" class="btn"/>
				</a>
			</div>
			<div class="col-6">
				<a href="homepage.php">
					<input type="button" name="annuleren" value="Annuleren" class="btn float-right"/>
				</a>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<a href="sign-up.php" class="a-sign-up">Nog geen account?</a>
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

	if(isset($_POST["submit"]) ) {
				
		$email = $_POST["email"];
		$password = $_POST["password"];
		if(empty($_POST["email"]) || empty($_POST["password"])) {
			echo "geen email of wachtwoord ingevoerd";
		} else {
			
			$query = "SELECT * FROM users WHERE email = :email AND wachtwoord = :password";
			$statement = $database->prepare($query);
			$statement->execute(array('email' => $_POST["email"],'password' => $_POST["password"]));
			$count = $statement->rowCount();
			
			if($count > 0) {
				
				foreach($statement as $value) {
									
					session_start();
					$_SESSION["email"] = $_POST["email"];
					$_SESSION["naam"] = $value['naam'];
					$_SESSION['id'] = $value['id'];
				
					if($value['soort'] == "admin") {
						header('Location: homepage-admin.php');
					}
					if($value['soort'] == "bedrijf") {
						header('Location: homepage-bedrijf.php');
					}
					if($value['soort'] == "sollicitant") {
						header('Location: homepage-sollicitant.php');
					}
				}
				
				$query2 = "SELECT bedrijf FROM vacatures WHERE email = '$email'";
				$statement2 = $database->prepare($query2);
				try {
					$statement2->execute(array());
					$statement2->setFetchMode(PDO::FETCH_ASSOC);
					foreach($statement2 as $value2) {
						$_SESSION["bedrijf"] = $value2["bedrijf"];
					}
					if($_SESSION["bedrijf"] == "") {
						$_SESSION["bedrijf"] = "leeg";
					}
				}
				catch(PDOException $e) {
					echo "<script>alert('Er is iets mis gegaan.');</script>";
				}
					
			} else {
				echo "<script>alert('Gerbuikersnaam of wachtwoord is onjuist')</script>";
			}
		}
		


	}
	
	
	
	
	
?>
				
				
				
				
				
				
				
				
				
				
				
				