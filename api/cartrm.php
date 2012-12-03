<?php
	require("../config.php");

	$user = $_GET['user'];
	$isbn = $_GET['isbn'];

	try {
	    $conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
	    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
		$sql = "DELETE FROM bazinga.cart WHERE userid = :user AND isbn = :isbn;";
		$qry = $conn->prepare($sql);
	    $qry->execute(array(':user'=>$user,
							':isbn'=>$isbn));
	
		//$res = $qry->fetchAll();
		
		//echo json_encode($res);
	
	} catch(PDOException $e) {
	    echo $e;
	}

?>