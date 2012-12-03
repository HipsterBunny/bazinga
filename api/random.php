<?php
	require("../config.php");

	try {
	    $conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
	    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
		$sql = "SELECT * FROM bazinga.books WHERE CHAR_LENGTH(title) < 14 ORDER BY RAND() LIMIT 6;";
		$qry = $conn->prepare($sql);
	    $qry->execute();
	
		$res = $qry->fetchAll();
		
		echo json_encode($res);
	
	} catch(PDOException $e) {
	    echo "{'error':'Failed to connect to database'}";
	}

?>