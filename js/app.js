window.onload = function() {
  $.getJSON("api/categories.php", function(data){
    var cat = [];

    $.each(data, function(key, val) {
      cat.push('<li><a href="category.php?cat=' +  val.category + '">' + val.category + '</a></li>');
    });

    
    $('<ul/>', {
          html: cat.join(''),
          class: "nav nav-list"
    }).appendTo('#categoriesNav');
    
  });
  

  
}