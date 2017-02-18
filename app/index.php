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

					$username = "admin";
					$password = "cmsurvey";
					$dbname = "survey_responses";
					$dbhost = "localhost";

					// try {
					    // $conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $username, $password);
					    $conn = new PDO("mysql:host=localhost", $username, $rootPw);
					    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					    $db="CREATE DATABASE IF NOT EXISTS $dbname";
					    $conn->exec($db);
					    $dbuse="use $dbname";
					    $conn->exec($dbuse);
					    $columns="firstname VARCHAR(30) NOT NULL, lastname VARCHAR(30), email VARCHAR(30), rate INT, improve VARCHAR(100), favorite VARCHAR(100)";
					    $conn->exec("CREATE TABLE IF NOT EXISTS $dbname.responses ($columns)");
					// } catch(PDOException $e) {
					//     echo 'ERROR: ' . $e->getMessage();
					// }
						echo "<p>for sanity</p>";




					$stmt = $conn->prepare("SELECT * FROM responses");
					$stmt->execute();
					if ($stmt->rowCount() > 0) {
						echo "<p>for sanity</p>";
					}

					class TableRows extends RecursiveIteratorIterator { 
					    function __construct($it) { 
					        parent::__construct($it, self::LEAVES_ONLY); 
					    }

					    function current() {
					        return "<td style='width:150px;border:1px solid black;'>" . parent::current(). "</td>";
					    }

					    function beginChildren() { 
					        echo "<tr>"; 
					    } 

					    function endChildren() { 
					        echo "</tr>" . "\n";
					    } 
					} 
					$result = $stmt->setFetchMode(PDO::FETCH_ASSOC); 
				    foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) { 
				        echo $v;
				    }
					// echo "<p style='font-family=Arial'>Thank you, $firstname! You will be rewarded 10 stars in the next 3 days.";
				}


				if (isset($_POST['submit'])) {
					loadToDB();
				}
					
			?>
		</div>
	</body>
</html>