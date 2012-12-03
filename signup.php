<?php 
include("overall_header.php");
?>

<div class="span9">
    <h2>Sign Up</h2>
    <form>
    <label>First Name</label>
    <input type="text" name="firstname" class="span3">
    <label>Last Name</label>
    <input type="text" name="lastname" class="span3">
    <label>Email Address</label>
    <input type="email" name="email" class="span3">
    <label>Username</label>
    <input type="text" name="username" class="span3">
    <label>Password</label>
    <input type="password" name="password" class="span3">
    <label><input type="checkbox" name="terms"> I agree with the <a data-toggle="modal" href="#termModal">Terms and Conditions</a>.</label>
    <input type="submit" value="Sign up" class="btn btn-primary pull-right">
    <div class="clearfix"></div>
    </form>
</div>

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