<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Bazinga Books</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
	<link href='http://fonts.googleapis.com/css?family=Bangers' rel='stylesheet' type='text/css'>
    <link href="css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }
    </style>
    <!-- <link href="css/bootstrap-responsive.css" rel="stylesheet"> -->
	<link href="css/default.css" rel="stylesheet">
	
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="index.php"><img height="30px" src="img/bolt.png">Bazinga</a>
          <div class="nav-collapse collapse">
            <div id="loginLink" class="navbar-text pull-right">
              <a href="login.php" class="navbar-link">Login</a> | <a href="signup.php" class="navbar-link">Create an Account</a>
            </div>
			<ul id="loggedinUser" class="hidden pull-right">
            </ul>
            <ul class="nav">
              <li><a href="index.php">Home</a></li>
              <li><a href="category.php">Browse Books</a></li>
              <!-- <li><a href="#contact"></a></li> -->
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container-fluid main">
      <div class="row-fluid">
        <div class="span3">
          <div id="categoriesNav" class="well sidebar-nav">
            <ul class="nav nav-list">
              <li class="nav-header">Categories</li>
				
            </ul>
          </div><!--/.well -->
        </div><!--/span-->