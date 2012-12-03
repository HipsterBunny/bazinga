<?php 
include("overall_header.php");
?>



<div class="span9">
	<form class="form-horizontal" action='' method="POST">
	  <fieldset>
	    <div id="legend">
	      <legend class="">Login</legend>
	    </div>
	    <div class="control-group">
	      <!-- Username -->
	      <label class="control-label"  for="email">Email</label>
	      <div class="controls">
	        <input type="text" id="email" name="email" placeholder="jen@bazingabooks.com" class="input-xlarge">
	      </div>
	    </div>

	    <div class="control-group">
	      <!-- Password-->
	      <label class="control-label" for="password">Password</label>
	      <div class="controls">
	        <input type="password" id="password" name="password" placeholder="************" class="input-xlarge">
	      </div>
	    </div>


	    <div class="control-group">
	      <!-- Button -->
	      <div class="controls">
	        <button id="loginBtn" class="btn btn-primary">Login</button>
	      </div>
	    </div>
	  </fieldset>
	</form>
</div>

<?php
include("overall_footer.php"); 
?>