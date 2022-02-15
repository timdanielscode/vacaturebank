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
			<li><a href="login.php">Login</a></li>
		</ul>
		<ul class="terug">
			<li><a href="homepage.php">Terug</a></li>
		</ul>
	</header>
	<div class="inleiding center">
		<p>Meld je hier aan als sollicitant of bedrijf. Als sollicitant kun je iedere openstaande vacature bekijken en hierop reageren. Als bedrijf kun je vacatures plaatsen. Al een account? <a href="login.php" class="color-white">Log snel in!</a></p>
	</div>
	<form name="formulier" method="POST">
		<h2>Aanmelden:</h2>
		<select name="soort">
			<option value="sollicitant">sollicitant</option>
			<option value="bedrijf">bedrijf</option>
		</select>
		<p>Naam:</p>
		<input required type="text" name="naam" placeholder="Naam"/>
		<p>E-mail:</p>
		<input required type="email" name="email" placeholder="e-mail"/>
		<p>Wachtwoord:</p>
		<input required type="password" name="password" placeholder="Wachtwoord"/>
		<div class="row">
			<div class="col-6">
				<input type="submit" name="aanmelden" value="Aanmelden" class="btn"/>
			</div>
			<div class="col-6">
				<a href="login.php">
				<input type="button" name="login" value="Login" class="btn"/>
				</a>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<a href="login.php" class="a-sign-up">Heb je al een account?</a>
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
	}			
	if(isset($_POST["aanmelden"]) ) {
		$query = "INSERT INTO users (naam,email,wachtwoord,soort) values (?,?,?,?)";
		$insert = $database->prepare($query);
		$data = array("$_POST[naam]", "$_POST[email]", "$_POST[password]", "$_POST[soort]");
		try {
			$insert->execute($data);
			echo "<script>alert('uw heeft zich aangemeld');</script>";
			header('Location: login.php');
		}
		catch(PDOException $e) {
			echo "<script>alert('Er is iets mis gegaan.');</script>";
		}	
	}
	
?>
				
				
				
				
				
				
				
				
				
				
				
				