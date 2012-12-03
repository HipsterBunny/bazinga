<?php
	include("../config.php");

	$user = $_GET['user'];
	$isbn = $_GET['isbn'];
	$comment = $_GET['comment'];

	try {
	    $conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
	    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$sql = "INSERT INTO reviews(userid, isbn, comment) VALUES(:userid, :isbn, :comment)";
		$qry = $conn->prepare($sql);
	    $qry->execute(array(':userid'=>$user,
						    ':isbn'=>$isbn,
					    	':comment'=>$comment));
		

		// $res = $qry->fetchAll();

		$success=true;

	} catch(PDOException $e) {
	    $error = true;
		array_push($errors, $e);
	}

?>