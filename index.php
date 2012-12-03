<?php 
include("overall_header.php");

$inject_js = '
$.getJSON("api/random.php", function(data){
  var books = data;

  $.each(books, function(key, val) {
    $("#book" + key + " h2").html(val.title);
	$("#book" + key + " p:first").html(val.description.substring(0, 128) + "...");
	$("#book" + key + " p:first").prepend("<a href=\"book.php?isbn=" + val.isbn + "\"><img style=\"width:33%;\" src=\"covers/" + val.image +"\" class=\"img-polaroid\"><br/></a>");
	$("#book" + key + " .btn").attr("href", "book.php?isbn=" + val.isbn);
  });
 
});'; 


?>

 <div class="span9">
	
	
   	<div id="myCarousel" class="carousel slide">
	  <!-- Carousel items -->
	  <div class="carousel-inner">
	    <div class="active item"><img src="img/slides/bears.png"></div>
	    <div class="item"><img src="img/slides/cheetahs.png"></div>
	    <div class="item"><img src="img/slides/hippos.png"></div>
	  </div>
	  <!-- Carousel nav -->
	  <a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
	  <a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
	</div>



   <div class="row-fluid">
     <div id="book0" class="span4">
       <h2>Heading</h2>
       <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
       <p><a class="btn" href="#">View details &raquo;</a></p>
     </div><!--/span-->
     <div id="book1" class="span4">
       <h2>Heading</h2>
       <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
       <p><a class="btn" href="#">View details &raquo;</a></p>
     </div><!--/span-->
     <div id="book2" class="span4">
       <h2>Heading</h2>
       <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
       <p><a class="btn" href="#">View details &raquo;</a></p>
     </div><!--/span-->
   </div><!--/row-->
   <div class="row-fluid">
     <div id="book3" class="span4">
       <h2>Heading</h2>
       <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
       <p><a class="btn" href="#">View details &raquo;</a></p>
     </div><!--/span-->
     <div id="book4" class="span4">
       <h2>Heading</h2>
       <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
       <p><a class="btn" href="#">View details &raquo;</a></p>
     </div><!--/span-->
     <div id="book5" class="span4">
       <h2>Heading</h2>
       <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
       <p><a class="btn" href="#">View details &raquo;</a></p>
     </div><!--/span-->
   </div><!--/row-->

<?php include("overall_footer.php") ?>