<?php
	require("../config.php");

	$user = $_GET['user'];

	try {
	    $conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
	    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
		$sql = "SELECT title, image, price, cart.isbn FROM `cart` LEFT OUTER JOIN books ON books.isbn = cart.isbn WHERE userid = :user";
		$qry = $conn->prepare($sql);
	    $qry->execute(array(':user'=>$user));
	
		$res = $qry->fetchAll();
		
		echo json_encode($res);
	
	} catch(PDOException $e) {
	    echo "{'error':'Failed to connect to database'}";
	}

?>