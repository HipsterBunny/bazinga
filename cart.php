<?php 
include("config.php");
$isbn = $_GET['isbn'];
$user = $_GET['user'];
$errors = array();
if ($user == "undefined") {
	header( "refresh:0;url=login.php?p=newuser" );
}

if (isset($isbn) && isset($user)) {
	try {
	    $conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
	    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$sql = "INSERT INTO cart (userid, isbn) VALUES(:userid, :isbn)";
		$qry = $conn->prepare($sql);
	    $qry->execute(array(':userid'=>$user,
					    	':isbn'=>$isbn));
	
		// $res = $qry->fetchAll();

		$success=true;

	} catch(PDOException $e) {
	    $error = true;
		array_push($errors, $e);
	}
}
include("overall_header.php");
?>

<div class="span9">
	<h2>Shopping Cart</h2>
	<table class="table table-bordered">
	  <thead>
	    <tr>
	      <th>Title</th>
	      <th>Cover</th>
		  <th>Price</th>
		  <th>Remove?</th>
	    </tr>
	  </thead>
	  <tbody id="cartTable">
		<tr><td colspan='5'><i>No books in yer cart...</i></td></tr>
	  </tbody>
	</table>
	<a href="#" class="btn btn-primary btn-large"> Checkout </a>
</div>

<?php
include("overall_footer.php"); 
?>