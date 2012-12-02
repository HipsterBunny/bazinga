<?php
	require("../config.php");

	$cat = $_GET['cat'];

	try {
	    $conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
	    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
		if ($cat) {
			$sql = "SELECT * FROM bazinga.books WHERE isbn IN (SELECT isbn FROM bazinga.categories WHERE category = '$cat');";
		} else {
			$sql = "SELECT * FROM bazinga.books WHERE isbn IN (SELECT isbn FROM bazinga.categories);";
		}
		$qry = $conn->prepare($sql);
	    $qry->execute();
	
		$res = $qry->fetchAll();
		
		echo json_encode($res);
	
	} catch(PDOException $e) {
	    echo "{'error':'Failed to connect to database'}";
	}

?>