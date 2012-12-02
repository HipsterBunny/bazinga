<?php 
include("overall_header.php");
$isbn = $_GET['isbn'];
$inject_js = '
$.getJSON("api/book.php?isbn='.$isbn.'", function(data){
  var book = data[0];

	$("#title").html(book.title);
	$("#author").html(book.author);
	$("#cover").attr("src", "covers/"+book.image);
	$("#desc").html(book.description);
	$("#listprice").html(book.listprice);
	$("#price").html(book.price);
	$("#details").html("Publication Date: " + book.pub_date + "<br/>" +
					   "Publisher: "+ book.publisher + "<br/>" +
					   "Type: " + book.type + "<br/>" +
					   "ISBN-10: " + book.isbn + "<br/>" +
					   "ISBN-13: " + book.isbn13 + "<br/>");
 
});'; 
?>

<div class="span9">
	<hr/>

	<div class="media">
	  <a class="pull-left" href="#">
	    <img id="cover" class="media-object" src="http://placehold.it/64x64">
	  </a>
	  <div class="media-body">
	    <h2 id="title" class="media-heading">Media heading</h2>
		<h4 id="author"></h4>
	    <p id="desc"></p>
		<div class="pull-right">
			<h4 id="listprice"></h4>
			<h3 id="price"></h3>
			
		</div>
	  </div>
	<hr/>
	<div id="details"></div>
	
	</div>
</div>

<?php
include("overall_footer.php"); 
?>