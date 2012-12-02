<?php
	require("../config.php");

	try {
	    $conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
	    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
		$sql = "SELECT category FROM bazinga.categories WHERE category <> \"nyt:combined_print_fiction=2011-05-28\" GROUP BY category ORDER BY count(category) DESC LIMIT 15";
		$qry = $conn->prepare($sql);
	    $qry->execute();
	
		$res = $qry->fetchAll();
		
		echo json_encode($res);
	
	} catch(PDOException $e) {
	    echo "{'error':'Failed to connect to database'}";
	}

?>