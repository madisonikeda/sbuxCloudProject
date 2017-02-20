<?php

	function loadToDB() {
		$firstname = $_POST["firstname"];
		$lastname = $_POST["lastname"];
		$rate = $_POST["rate"];
		$improve = $_POST["improve"];
		$favorite = $_POST["favorite"];

		$username = "root";
		$password = "cmsurvey";
		$dbname = "survey_responses";
		$dbhost = "localhost";

		try {
		    $conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $username, $password);
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch(PDOException $e) {
		    echo 'ERROR: ' . $e->getMessage();
		}


		$statement = $conn->prepare("INSERT INTO responses(firstname, lastname, rate, improve, favorite)
		    VALUES(:firstname, :lastname, :rate, :improve, :favorite)");
		$statement->execute(array(
		    "firstname" => "$firstname",
		    "lastname" => "$lastname",
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