<?php 
include("overall_header.php");
$cat = $_GET['cat'];
$inject_js = '
$.getJSON("api/category.php?cat='.$cat.'", function(data){
  var books = [];

  $.each(data, function(key, val) {
    books.push(\'<li class="span3"><a href="book.php?isbn=\'+val.isbn+\'" class="thumbnail"><img src="covers/\' + val.image + \'"></a></li>\');
  });

  $(\'<ul/>\', {
        html: books.join(\'\'),
        class: "thumbnails"
  }).appendTo(\'#thumbContainer\');
 
});'; 

echo "<div id='thumbContainer' class='span9'>
	  <div><h2>$cat Books</h2></div>
	  </div>";

include("overall_footer.php"); 
?>