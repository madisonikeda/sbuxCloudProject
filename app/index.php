<!DOCTYPE html>
<html>
	<head>
		<title>Tell us about your Starbucks experience!</title>
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
		<link rel="stylesheet" type="text/css" href="stylesheet.css">

		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<!-- jQuery library -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<!-- Latest compiled JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</head>
	<body>
		<div class="header">
			<h1>Tell us about your Starbucks experience!</h1>
		</div>
		<div class="containerSurvey">
			<form action='index.php' method='post' name='form'>
		  		<div class="form-group">
					<label for="name">First Name:</label>
					<input type="text" class="form-control" name="firstname"/>
				</div>	
				<div class="form-group">
					<label for="name">Last Name:</label>
					<input type="text" class="form-control" name="lastname"/>
				</div>
				<div class="form-group">
					<label for="email">Email Address:</label>
					<input type="text" class="form-control" name="email"/>
				</div>
				<div class="form-group">	
					<label for="rate">Please rate your Starbucks experience (1 is low, 10 is high): </label>
					<br/>
					<input type="radio" name="rate" value="1" checked="checked"/> 1 
					<input type="radio" name="rate" value="2"/> 2 
					<input type="radio" name="rate" value="3"/> 3 
					<input type="radio" name="rate" value="4"/> 4 
					<input type="radio" name="rate" value="5"/> 5 
					<input type="radio" name="rate" value="6"/> 6 			
					<input type="radio" name="rate" value="7"/> 7 
					<input type="radio" name="rate" value="8"/> 8 
					<input type="radio" name="rate" value="9"/> 9 
					<input type="radio" name="rate" value="10"/> 10 
				</div>
				<div class="form-group">
					<label for="improve">Please tell us what we can improve on: </label>
				</div>
				<div class="form-group">
					<textarea rows="4" class="form-control" name="improve"></textarea>
				</div>
				<div class="form-group">
					<label for="favorite">What is your favorite drink?</label>
					<input type="text" class="form-control" name="favorite"/>
				</div>
				<input type="submit" class="btn btn-success active" name="submit"/>
			</form>
			<?php

				function loadToDB() {

					$rootPw = getenv('MYSQL_ENV_MYSQL_ROOT_PASSWORD');
					$tcpAddr = getenv('MYSQL_PORT_3306_TCP_ADDR');
					$tcpPort = getenv('MYSQL_PORT_3306_TCP_PORT');
					echo "$tcpAddr $tcpPort $rootPw";
					// $link = mysql_connect("$tcpAddr:$tcpPort", 'root', $rootPw);

					$firstname = $_POST["firstname"];
					$lastname = $_POST["lastname"];
					$email = $_POST["email"];
					$rate = intval($_POST["rate"]);
					$improve = $_POST["improve"];
					$favorite = $_POST["favorite"];

					$username = "root";
					$password = "cmsurvey";
					$dbname = "survey_responses";
					$dbhost = "localhost";

					try {
					    // $conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $username, $password);
					    $conn = new PDO("mysql:host=$tcpAddr;dbname=$dbname;port=$tcpPort", $username, $rootPw);
					    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					} catch(PDOException $e) {
					    echo 'ERROR: ' . $e->getMessage();
					}


					$statement = $conn->prepare("INSERT INTO responses(firstname, lastname, email, rate, improve, favorite)
					    VALUES(:firstname, :lastname, :email, :rate, :improve, :favorite)");
					$statement->execute(array(
					    "firstname" => "$firstname",
					    "lastname" => "$lastname",
					    "email" => "$email",
					    "rate" => $rate,
					    "improve" => "$improve",
					    "favorite" => "$favorite"
					));
					// echo "<p style='font-family=Arial'>Thank you, $firstname! You will be rewarded 10 stars in the next 3 days.";
				}


				if (isset($_POST['submit'])) {
					loadToDB();
				}
					
			?>
		</div>
	</body>
</html>