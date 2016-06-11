function parallax() {
	var scrollPosition = $(window).scrollTop();
	$('#parallax').css('top',(0 - (scrollPosition * 0.3))+'px' ); // bg image moves at 50% of scrolling speed
}

$(document).ready(function() {

	/* ========== PARALLAX BACKGROUND ========== */

	$(window).on('scroll', function(e) {
		parallax();
	});


	/* ========== FITVIDS PLUGIN ========== */
	
	$('.fitvids').fitVids();



	/* ========== BOOTSTRAP SCROLLSPY ========== */
	
	$('section').scrollspy();



	/* ========== SMOOTH SCROLLING BETWEEN SECTIONS ========== */
	
	$('a[href*=#]:not([href=#])').not('#myCarousel a, #testimonials a, .modal-trigger a, .panel a').click(function(o) {
	    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') 
	        || location.hostname == this.hostname) {

	        var target = $(this.hash);
	        target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
	           if (target.length) {
	           	if ($(".navbar").css("position") == "fixed" ) {
	             $('html,body').animate({
	                 scrollTop: target.offset().top-72
	            }, 700, 'swing');
	         } else {
	             $('html,body').animate({
	                 scrollTop: target.offset().top
	            }, 700, 'swing');
	         }
	            return false;
	        }
	    }
	});



	/* ========== NEWSLETTER SIGNUP ========== */

    $("#newsletter-signup").submit(function() {
		var str = $(this).serialize();
		$.ajax({
			type: "POST",
			url: "assets/newsletter.php",
			data: str,
			success: function(msg) {
				if(msg == 'OK') {
					result = '<div class="alert alert-success">Yeeha, you are signed up!"</div>';
					setTimeout("location.reload(true);",7000);
			  	} else {
					result = msg;
			  	}
			  	$('#error-info').html(result);
		    }
		});
		return false;
	});



	/* ========== CONTACT FORM ========== */

    $("#contact-form").submit(function() {
		var str = $(this).serialize();
		$.ajax({
			type: "POST",
			url: "assets/contact.php",
			data: str,
			success: function(msg) {
				if(msg == 'OK') {
					result = '<div class="alert alert-success">All good, message sent!"</div>';
					$(".input-group").hide();
					setTimeout("location.reload(true);",7000);
			  	} else {
					result = msg;
			  	}
			  	$('#contact-error').html(result);
		    }
		});
		return false;
	});



	/* ========== TWITTER FEED ========== */
	
	$("#tweets-feed").tweet({
	  join_text: false,
	  username: "envato", // Change username here
	  modpath: './assets/twitter/', 
	  avatar_size: false,
	  count: 1, // number of tweets
	  loading_text: "loading tweets...",
	  seconds_ago_text: "about %d seconds ago",
	  a_minutes_ago_text: "about a minute ago",
	  minutes_ago_text: "about %d minutes ago",
	  a_hours_ago_text: "about an hour ago",
	  hours_ago_text: "about %d hours ago",
	  a_day_ago_text: "about a day ago",
	  days_ago_text: "about %d days ago",
	  view_text: "view tweet on twitter"
	});

	

	/* =========== CUSTOM STYLE FOR SELECT DROPDOWN ========== */

	$("select").selectpicker({style: 'btn-hg btn-primary', menuStyle: 'dropdown'});

	// style: select toggle class name (which is .btn)
	// menuStyle: dropdown class name

	// You can always select by any other attribute, not just tag name.
	// Also you can leave selectpicker arguments blank to apply defaults.



	/* ========== TOOLTIPS & POPOVERS =========== */

	$("[data-toggle=tooltip]").tooltip();

	$('.popover-trigger').popover('hide');




    /* ========== MAGNIFIC POPUP ========== */

    $('.gallery-item, .gallery-popup').magnificPopup({
	  	delegate: 'a', // child items selector, by clicking on it popup will open
	  	type: 'image',
	  	closeOnContentClick: 'true',
		mainClass: 'mfp-with-zoom', // this class is for CSS animation below
	  	zoom: {
		    enabled: true, // By default it's false, so don't forget to enable it
		    duration: 300, // duration of the effect, in milliseconds
		    easing: 'ease-in-out', // CSS transition easing function 

		    // The "opener" function should return the element from which popup will be zoomed in
		    // and to which popup will be scaled down
		    // By defailt it looks for an image tag:
		    opener: function(openerElement) {
		      // openerElement is the element on which popup was initialized, in this case its <a> tag
		      // you don't need to add "opener" option if this code matches your needs, it's defailt one.
		      return openerElement.is('img') ? openerElement : openerElement.find('img');
		    }
		}
	});



	/* ========== END OF SCRIPTS ========== */

});


/* ========== ISOTOPE FILTERING ========== */

$(window).load(function(){

	var $container = $('#gallery-items'),
        $select = $('#filters select');

    $container.isotope({
        itemSelector: '.gallery-item'
    });

    $select.change(function() {
        var filters = $(this).val();
;
        $container.isotope({
            filter: filters
        });
    });
    
})