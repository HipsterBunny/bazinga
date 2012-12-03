<?php
	include("../config.php");

	$isbn = $_GET['isbn'];

	try {
	    $conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
	    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$sql = "SELECT userid, comment, reviews.timestamp, fname, lname FROM reviews LEFT OUTER JOIN users ON reviews.userid = users.id WHERE isbn = :isbn";
		$qry = $conn->prepare($sql);
	    $qry->execute(array(':isbn'=>$isbn));
		

		$res = $qry->fetchAll();
		
		echo json_encode($res);

		$success=true;

	} catch(PDOException $e) {
	    $error = true;
		array_push($errors, $e);
	}

?>