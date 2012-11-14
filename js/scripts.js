/*******************************************************************************
 * jQuery Overlay Plugin
 * by Dylan Swartz
 * Written for CIS255 final project.
 *
 * Tuesday, June 7, 2011
 *
 * Usage:
 * 1. Create a overlay like this:
 * <div id="theOverlay" class="bazinga-overlay">
 *     <h1>BAZINGA!!!!</h1>
 *     <p>How do you like them apples?</p>
 *     <a class="close-bazinga-overlay">x</a>
 * </div>
 *
 * 2. Create a link with a custom attribute called "data-overlay-id"
 *    whose value is the same as the id of the overlay you want to display.
 *    Like this:
 * <a href="#" class="testLink" data-overlay-id="theOverlay">
 *     Click me!
 * </a>
 *
 * 3. Style your overlay and overlay background with CSS. Make sure the
 *    visibility is set to "hidden". Like this:
 *
 * .bazinga-overlay-bg {
 *   position: fixed;
 *   top: 0;
 *   left: 0;
 *   height: 100%;
 *   width: 100%;
 *   background: rgba(0,0,0,.8);
 *   z-index: 100;
 *   display: none;
 * }
 *
 * .bazinga-overlay {
 *    visibility: hidden;
 *    background-color: #fff;
 *    z-index: 101;
 * }
 *
 * 4. Whalla! The overlay is now fully functional! :)
 *
 ******************************************************************************/


(function($) {
	 
    /* Listener for data-overlay-id attribute
    * For more info on custom attributes:
    * http://ejohn.org/blog/html-5-data-attributes/ */

    $('a[data-overlay-id]').live('click', function(e) {
        e.preventDefault(); // Stop the link from going to another page
        // Get the value from the link's data-overlay-id attribute
        var overlayLocation = $(this).attr('data-overlay-id');
        // Run the overlay function
        // Passing $(this).data() will maintain the state of this specific overlay
        $('#'+overlayLocation).bazingaOverlay($(this).data());
    });


    /* Extend  jquery with the bazingaOverlay funtiona and execute  it*/
    $.fn.bazingaOverlay = function(options) {
        
        var defaults = {  
            animationspeed: 300, // how long the animation will run
            closeonbgclick: true, // should the overlay close when clicking the background?
            killoverlayclass: 'close-bazinga-overlay' // the class of a button or element that will close an open overlay
    	}; 
    	
        // Extend the options (allows for other developers to add othere settings and such)
        var options = $.extend({}, defaults, options); 
	
        return this.each(function() { // returning "this" maintains chainability for other jquery functions
        
            /* Global Variables */
            // Don't yell at me. I know I shouldn't be using global variables in JS. :/
            var overlay = $(this),
            topMeasure  = parseInt(overlay.css('top')),
            topOffset   = overlay.height() + topMeasure,
            locked      = false,
            overlayBG   = $('.bazinga-overlay-bg');

            /* Create the overlay background */
            if(overlayBG.length == 0) {
                overlayBG = $('<div class="bazinga-overlay-bg" />').insertAfter(overlay);
            }

            /* Open & Close Animations */

            // Open Animation
            overlay.bind('bazingaOverlay:open', function () {
                overlayBG.unbind('click.overlayEvent');
                $('.' + options.killoverlayclass).unbind('click.overlayEvent');
                // only executing when the overlay is unlocked prevents multiple animations from running at the same time
                if(!locked) {
                    lockOverlay(); // sets the locked boolean to true

                    /*
                     * I use the animate function like this:
                     * .animate( properties, animationSpeed, functionToExecuteAfterCompletion )
                     *
                     */
                    overlay.css({'opacity' : 0, 'visibility' : 'visible', 'top': $(document).scrollTop()+topMeasure});
                    overlayBG.fadeIn(options.animationspeed/2);
                    overlay.delay(options.animationspeed/2).animate({
                            "opacity" : 1
                    }, options.animationspeed,unlockOverlay());

                    // This was before I put in the animation
                    /* overlay.css({'visibility' : 'visible', 'top':$(document).scrollTop()+topMeasure});
                    overlayBG.css({"display":"block"});
                    unlockOverlay() */
                }
                overlay.unbind('bazingaOverlay:open');
            });

            // Close Animation
            overlay.bind('bazingaOverlay:close', function () {
                if(!locked) { // make sure an an animation isn't running
                    lockOverlay(); // let everyone know that you're running an animation

                    /*
                     * I use the animate function like this:
                     * .animate( properties, animationSpeed, functionToExecuteAfterCompletion )
                     *
                     */
                    overlayBG.delay(options.animationspeed).fadeOut(options.animationspeed);
                    overlay.animate({
                        "opacity" : 0
                    }, options.animationspeed, function() {
                        overlay.css({'opacity' : 1, 'visibility' : 'hidden', 'top' : topMeasure});
                        unlockOverlay();
                    });
                    

                   // This was before I put in the animation
                   /* overlay.css({'visibility' : 'hidden', 'top' : topMeasure});
                    overlayBG.css({'display' : 'none'}); */
                    
                }
                overlay.unbind('bazingaOverlay:close');
            });
   	
            /* Event listeners */

            // Open the overlay now! >:O
            overlay.trigger('bazingaOverlay:open')
			
            // Event listener for when the close button is clicked
            var closeButton = $('.' + options.killoverlayclass).bind('click.overlayEvent', function () {
              overlay.trigger('bazingaOverlay:close') // Close the overlay
            });

            // Event listener for when the user clicks the background
            // (provided that option is set)
            if(options.closeonbgclick) {
                overlayBG.css({"cursor":"pointer"})
                overlayBG.bind('click.overlayEvent', function () {
                    overlay.trigger('bazingaOverlay:close') // Close that overlay son!
                });
            }
            // Event listener for the escape key
            $('body').keyup(function(e) {
                // The === operator doesn't perform any type coercion
                if(e.which===27){overlay.trigger('bazingaOverlay:close');} // 27 is the keycode for the Escape key
            });
			
            /* Animations Locks */
            // These are set to prevent animations from running simutaniously
            function unlockOverlay() {
                locked = false;
            }
            function lockOverlay() {
                locked = true;
            }
        });
    }
})(jQuery);
        
/*******************************************************************************
 *
 * JQuery Slideshow Plugin
 * by Dylan Swartz
 * Written for CIS255 final project.
 *
 * Sunday, May 22, 2011
 *
 ******************************************************************************/

(function(){
    var Slideshow = function(element, options){
        
        var settings = $.extend({}, $.fn.slideshow.defaults, options);

        var show = $(element);
        var totalWidth=0;
        var positions = new Array();
        var numSlides = show.children();

        show.parent().append('<div id="menu"><ul id="menuItems"></ul></div>')

        /* Traverse through each slide and store their accumulative widths in
         * totalWidth */
        numSlides.each(function(i){

            /* The positions array contains each slide's commulutative offset
             * from the left part of the container */
            positions[i]= totalWidth;
            totalWidth += $(this).width();

            if(!$(this).width())
            {
                alert("Please, fill in width & height for all your images!");
                return false;
            }

            $('#menuItems').append('<li class="menuItem"><a href="">'+
                                   '<img src="img/dots.png" alt="thumbnail" />'+
                                   '</a></li>');

        });

        show.width(totalWidth);

        /* Change the cotnainer div's width to the exact width of all the slides
         *  combined */

        $('#menu ul li a').click(function(e,keepScroll){

            /* On a thumbnail click */

            $('li.menuItem a').removeClass('active').addClass('inactive');
            $(this).addClass('active');

            var pos = $(this).parent().prevAll('.menuItem').length;

            // Start the sliding animation
            show.stop().animate({marginLeft:-positions[pos]+'px'},450);

            // Prevent the link from executing
            e.preventDefault();


            // Stop the auto switching if an menuitem has been clicked
            if(!keepScroll) clearInterval(interval);
        });

        // Mark the first thumbnail as active
        $('#menu ul li.menuItem:first a').addClass('active').siblings().addClass('inactive');

        /* This function will automaticlly swich the slide to the next slide
         * after n number of seconds*/
        var current=1;
        function autoTransition()
        {
            if(current==-1) return false;

            // Pass [true] as the keepScroll parameter of the menuItem click function
            $('#menu ul li a').eq(current%$('#menu ul li a').length).trigger('click',[true]);
            current++;
        }

        /* The number of seconds that the slider will automaticlly switch to
         * the next slide */
        var changeEvery = 10;

        var interval = setInterval(function(){autoTransition()},changeEvery*1000);

    /* End of Slideshow function */
    };

    $.fn.slideshow = function(options) {

        return this.each(function(key, value){
            var element = $(this);
            // Return early if this element already has a plugin instance
            if (element.data('slideshow')) return element.data('slideshow');
            // Pass options to plugin constructor
            var show = new Slideshow(this, options);
            // Store plugin object in this element's data
            element.data('slideshow', show);
        });

    };

    //Default settings
    $.fn.slideshow.defaults = {
        tempvar: "apples"
        // Not yet implemented
    }

})(jQuery);

/*******************************************************************************
 *
 *
 * All of the JavaScript that should excute on page load
 *
 *
 ******************************************************************************/
$(window).load(function() {

    // data structure to store each top seller
    var bookObject = {
        isbn: 0,
        isbn13: 0,
        title: "",
        img: "",
        price: 0,
        listPrice: 0,
        description: "",
        author: "",
        ageRange: 0,
        format: "",
        pubDate: "",
        publisher: "",
        rating: "",
        reviewer: "",
        subjects:  new Array(),
        type: ""
    };

    var page = getShortUrl();

    // Figure out if it is the index page!
    if (page == "" || page == "index") {

    //--------------------------------------------------------------------------
    /* This hunk of js will grab the "top sellers" from the json file and
     * populate the top sellers table with the data.  */
    /*$.getJSON('json/top_sellers.json', function(data) {
        var topSellers = []; // array to store each book

        // do this for every category
        $.each(data.top_sellers, function() {
            var tempBook = Object.create(bookObject);
            tempBook.isbn = this.book;
            //alert(tempBook.isbn);
            topSellers.push(tempBook);
        });

        $.each(topSellers, function(index) {
            //alert("in the functiin...with index: "+index+"..." + topSellers[index].isbn);
            // Get the other book attributes
            //alert(index);

             $.ajax({
                 async: false,
                 url: 'json/book/'+ this.isbn,
                 dataType: "json",
                 success: function(data) {

                    //alert(index+" "+data.price);
                    topSellers[index].price = data.price;
                    topSellers[index].img = "covers/" + data.image;
                    topSellers[index].title = data.title;
                    topSellers[index].description = data.description;

                 }

               });

        });


        // For every book item, put it in the div
            $('#books.homepage tr td').each(function(index) {
                $(this).children('a').attr({
                    "href": "book.html?=" + topSellers[index].isbn
                }).html("<img style='padding: 10px;' width='92' src='" + topSellers[index].img + "'>" );

               // generate overlays
               $("#content").append('<div id="overlay' + (index + 1)  + '" class="bazinga-overlay">\
                                     <h1>'+ topSellers[index].title +'</h1>\
                                     <b><span id="price">' + topSellers[index].price +'</span></b>\
                                     <br/>\
                                     <img align="right" vspace="5px" hspace="10px" src="'+ topSellers[index].img +'"/>\
                                     <p style="clear:none;">'+ topSellers[index].description + '</p>\
                                     <a style="float:right;" href="book.html?isbn='+topSellers[index].isbn +'" class="button orange">More</a>\
                                     <div><a class="close-bazinga-overlay">x</a></div>\
                                     </div>');
            });
        });*/
    }
    //--------------------------------------------------------------------------
    // Determine if on the category page...if so, figure out the category
    // then list all of the books in that category
    else if (page == "category") {
        var cat = urlGetVal("cat");
        $('body h1').html(cat);

        if (cat != "") {
           // $.getJSON('json/category/' + cat, function(data) {
                data = categories[cat];

                var booksInCategory = [];
                var tableStructure = [];
                // do this for every book

                $.each(data, function() {
                    var tempBook = Object.create(bookObject);
                    tempBook.isbn = this.isbn;
                    //alert(tempBook.isbn);
                    booksInCategory.push(tempBook);
                });

                tableStructure.push("<tr>");

                $.each (booksInCategory, function(index) {
                    //isbns += this.isbn + " ";
                    //alert(this.isbn);
                    /*$.ajax({
                     async: false,
                     url: 'json/book/'+ this.isbn,
                     dataType: "json",
                     success: function(data) {*/
                        var data = books[this.isbn];
                        //alert(books[this.isbn].price)
                        //alert(index+" "+data.price);
                        booksInCategory[index].price = data.price;
                        booksInCategory[index].img = "covers/" + data.image;
                        booksInCategory[index].title = data.title;
                        booksInCategory[index].description = data.description;

                        if (index % 4 == 0 && index != 0)
                            tableStructure.push("</tr><tr><td></td>");
                        else
                            tableStructure.push("<td></td>");

                     //}

                   //});

                });

                $('#books').html(tableStructure + "</tr>");

                $('#books tr td').each(function(index) {
                    $(this).append("<a href='book.html?isbn=" +
                        booksInCategory[index].isbn + "'>" +
                        "<img style='padding: 10px;' title='" +
                        booksInCategory[index].title +
                        "' width='92' src='" +
                        booksInCategory[index].img + "'></a>");


                    /*$(this).children('a').attr({
                        "href": "?book=" + booksInCategory[index].isbn
                    }).html("<img style='padding: 10px;' width='92' src='" + booksInCategory[index].img + "'>" );*/

                });

            //});
        } else {
            location.href = "index.html";
        }
    }
    //--------------------------------------------------------------------------
    // Determine if on the book page...if so, display all of the book info
    else if (page == "book") {
        var theBook = Object.create(bookObject);
        theBook.isbn = urlGetVal("isbn");


        /*$.ajax({
                 async: false,
                 url: 'json/book/'+ theBook.isbn,
                 dataType: "json",
                 success: function(data) {*/
                    //alert(index+" "+data.price);
                    var data = books[theBook.isbn];
                    //data = jQuery.parseJSON(books[theBook.isbn]);
                    theBook.isbn13 = data.isbn13
                    theBook.title = data.title;
                    theBook.author = data.author;
                    theBook.img = "covers/" + data.image;
                    theBook.price = data.price;
                    theBook.listPrice = data.listprice;
                    theBook.description = data.description;
                    theBook.pubDate = data.pub_date;
                    theBook.publisher = data.publisher;
                    theBook.type = data.type;
                    theBook.rating = data.rating;


                    //$.each(data.subjects, function() {
                    //    theBook.subjects.push(this.name);
                    //});
                 /*}
       });*/



       $("#content").html("<h1>" + theBook.title + " <span>"+ theBook.author +"</span></h1>");
       $("#content").append("<table class='bookDesc'><tr><td ><img src='"+ theBook.img +
                            "'/></td><td id='dataCell'>"+ theBook.description +
                            "</td></tr></table");

       $("#dataCell").append("<h3><s><b>List Price:</b> "+ theBook.listPrice +"</s></h3>")
       $("#dataCell").append("<h2><b>Price:</b> "+ theBook.price +"</h2>")
       $("#dataCell").append("<p><a href='cart.html?do=buy' "+
                             "data-overlay-id='buyOverlay' class='button orange'>Buy</a></p>")
       $("#content").append("<dl/>");
       $("#content dl").append("<dt><b>Publication Date: </b>" + theBook.pubDate +"</dt>");
       $("#content dl").append("<dt><b>Publisher: </b>" + theBook.publisher +"</dt>");
       $("#content dl").append("<dt><b>Rating: </b>" + theBook.rating +" out of 5 Stars</dt>");
       //if (theBook.subjects.length > 0)
            //$("#content dl").append("<dt><b>Subjects: </b>" + theBook.subjects.join(", ") +"</dt>");
       $("#content dl").append("<dt><b>Type: </b>"+ theBook.type +"</dt>");
       $("#content dl").append("<dt><b>ISBN-10: </b>" + theBook.isbn +"</dt>");
       $("#content dl").append("<dt><b>ISBN-13: </b>" + theBook.isbn13 +"</dt>");

       //$("#content dl").append("<dt><b>Price:</b> "+ theBook.price +"</dt>");
    }

    //--------------------------------------------------------------------------
    /* This hunk of js will grab the "top categories" from the json file and
     * populate the left nav bar with the data.  */
    // For CIS355
    /*$.getJSON('json/top_categories.json', function(data) {
        var items = []; // array to store each list item
        //
        // do this for every category
        $.each(data.top_categories, function() {
            // put the list item on the items array
            items.push("<li><a href='category.html?cat=" + this.category + "'>" + this.category + "</a></li>");
        });
        // join all of the list items
        // put them in the #categories div
        // then wrap the <ul></ul> tags around the list items
        $('#categories').html(items.join('')).wrapInner('<ul/>').prepend("<h2>Categories</h2>");
    });*/
    // For CIS255
    $('#categories').html('<h2>Categories</h2><ul><li><a href="category.html?cat=Fiction">Fiction</a></li><li><a href="category.html?cat=History">History</a></li><li><a href="category.html?cat=Romance">Romance</a></li><li><a href="category.html?cat=Cooking">Cooking</a></li><li><a href="category.html?cat=Gangsters">Gangsters</a></li><li><a href="category.html?cat=Biography">Biography</a></li></ul>');

    //--------------------------------------------------------------------------
    /* Run the slideshow */
    $('#slides').slideshow();
    
});

//--------------------------------------------------------------------------
/* This function returns the value of a specifed get variable */
function urlGetVal(getVar) {
    var substr = getVar+"=";
    var substrIndex = location.href.lastIndexOf(substr);
    if (substrIndex > 0)
        return location.href.substring((substrIndex)+ substr.length);
    else
        return "";
}

//--------------------------------------------------------------------------
/* This function returns the file name in the url i.e "index" for
 * http://localhost/bazinga/index.html/ */
function getShortUrl() {
    var indexOfExt = location.href.lastIndexOf(".html");
    if (indexOfExt > 0) 
        return location.href.substring((location.href.lastIndexOf("/"))+1, indexOfExt);
    else
        return "";
}