<?php
	require("../config.php");

	$email = $_GET['email'];
	$md5Pass  = $_GET['password'];

	try {
	    $conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
	    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
		$sql = "SELECT id, fname, lname, email FROM bazinga.users WHERE email = :email AND password = :pass";

		$qry = $conn->prepare($sql);
	    $qry->execute(array(':email'=>$email,
					    	':pass'=>$md5Pass));
	
		$res = $qry->fetchAll();
		
		echo json_encode($res);
	
	} catch(PDOException $e) {
	    echo "{'error':'Failed to connect to database'}";
	}

?>