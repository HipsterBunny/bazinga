<?php 
require("config.php");
$p = $_GET['p'];
$form = '
    <h2>Sign Up</h2>
    <form action="signup.php?p=newuser" method="post">
    <label>First Name</label>
    <input type="text" name="firstname" class="span3">
    <label>Last Name</label>
    <input type="text" name="lastname" class="span3">
    <label>Email Address</label>
    <input type="email" name="email" class="span3">
    <label>Password</label>
    <input type="password" name="password" class="span3">
    <label><input type="checkbox" name="terms"> I agree with the <a data-toggle="modal" href="#termModal">Terms and Conditions</a>.</label>
    <input type="submit" value="Sign up" class="btn btn-primary pull-right">
    <div class="clearfix"></div>
    </form>';


if ($p =='newuser') {
		$fname = trim($_POST['firstname']);
		$lname = trim($_POST['lastname']);
		$email = trim($_POST['email']);
		$pass  = trim($_POST['password']);
		$terms = trim($_POST['terms']);
		
		$error = false;
		$success = false;
		$errors = array();
		
		if (!isset($fname) || strlen($fname) < 3) {
			$error = true;
			array_push($errors, "Invalid first name!");
		}
		if (!isset($lname) || strlen($lname) < 3) {
			$error = true;
			array_push($errors, "Invalid last name!");
		}
		if (!isset($email) || strlen($email) < 4) {
			$error = true;
			array_push($errors, "Invalid email address!");
		}
		if (!isset($pass) || strlen($pass) < 4) {
			$error = true;
			array_push($errors, "Your password sux.");
		}
		if (!terms) {
			$error = true;
			array_push($errors, "You can't signup without agreeing to the terms.");
		}
		
		if (!$error) {
		
			try {
			    $conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
			    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				$sql = "INSERT INTO users (fname, lname, email, password) VALUES(:fname, :lname, :email, :pass)";
				$qry = $conn->prepare($sql);
			    $qry->execute(array(':fname'=>$fname,
				                    ':lname'=>$lname,
								    ':email'=>$email,
							    	':pass'=>md5($pass)));
				

				// $res = $qry->fetchAll();

				$success=true;

			} catch(PDOException $e) {
			    $error = true;
				array_push($errors, $e);
			}
			
		}
		
		// if (!$error && !$success) {
		// 	$error = true;
		// 	array_push($errors, "An unknown error occured.");
		// }
		if ($success) {
			header( "refresh:6;url=login.php?p=newuser" );
		}
}


include("overall_header.php");
echo "<div class=\"span9\">";
if ($error) {
	echo "<div class='alert alert-error'>".$errors[0]."</div>";
}
if ($success) {
	echo "<div class='alert alert-success'>Hurray! You made an account!</div>";
	echo '<p>Your browser should redirect you in 5 seconds... ' .
		 'If not, click the button below! <br/><br/><a class="btn btn-large btn-primary" href="login.php?p=newuser" >Login</a></p>';
} else {
	echo $form;
}
echo "</div>";
?>

<div id="termModal" class="modal hide fade">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Terms</h3>
  </div>
  <div class="modal-body">
    <p>You must be human. You must be literate. Also, you must enjoy eating bacon.</p>
  </div>
  <div class="modal-footer">
    <a href="#" data-dismiss="modal" class="btn">Close</a>
  </div>
</div>

<?php 

include("overall_footer.php");

?>