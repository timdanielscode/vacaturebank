<!-- 97044742 -->
<!-- Tim Daniëls -->
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type"
		content="text/html;
		charset=UTF-8">
	<link rel="stylesheet" href="style.css">
		<link rel="stylesheet" href="bootstrap.min.css">
</head>
<body>
	<header>
		<a href="javascript:history.back(1)"><h1>PowerJobs vacaturebank</h1></a>
	</header>
	<form name="formulier" action="" method="POST">
		<h2>Log uit:</h2>
		<div class="row">
			<div class="col6">
				<a>
					<input type="submit" name="submit" value="Uitloggen" class="btn"/>
				</a>
			</div>
			<div class="col6">
				<input type="button" name="annuleren" value="Annuleren" onclick="history.back()" class="btn"/>
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
		header('Location: homepage.php');
		$_SESSION = array();
		if (ini_get("session.use_cookies")) {
			$params = session_get_cookie_params();
			setcookie(session_name(), '', time() - 42000,
				$params["path"], $params["domain"],
				$params["secure"], $params["httponly"]
			);
		}
		session_destroy();
	}
?>
				
				
				
				
				
				
				
				
				
				
				
				