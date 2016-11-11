$(document).ready(function() {
	"use strict";

  // ------------- Pre-loader--------------  

  // makes sure the whole site is loaded

  $(window).load(function() {
      // will first fade out the loading animation
      $(".preloader").fadeOut();
      //then background color will fade out slowly
      $("#faceoff").delay(200).fadeOut("slow");
  });

  //-------Appearence of navigation----------

  $('header .nav').onePageNav({
    scrollThreshold: 0.2, // Adjust if Navigation highlights too early or too late
    scrollOffset: 90 //Height of Navigation Bar
  });

 
  //var winWidth = $(window).width();
  $(window).scroll(function() {
    //if (winWidth > 767) {
      var $scrollHeight = $(window).scrollTop();
      if ($scrollHeight > 600) {
        $('#home').slideDown(400);
      }else{
        $('#home').slideUp(400);
      }
    //}
	
	//got o top
	  if ($(this).scrollTop() > 200) {
			$('#go-to-top a').fadeIn('slow');
		  } else {
			$('#go-to-top a').fadeOut('slow');
	  }  
  });
  
  //-------scroll to top---------
  
   $('#go-to-top a').click(function(){
  	$("html,body").animate({ scrollTop: 0 }, 750);
  	return false;
  });
  
  //--------------- SmoothSroll--------------------

  var scrollAnimationTime = 1200,
      scrollAnimation = 'easeInOutExpo';
  $('a.scrollto').bind('click.smoothscroll', function (event) {
      event.preventDefault();
      var target = this.hash;
      $('html, body').stop().animate({
          'scrollTop': $(target).offset().top
      }, scrollAnimationTime, scrollAnimation, function () {
          window.location.hash = target;
      });
  });

  // ------------- Owl Carousel--------------

  $("#owl-demo").owlCarousel({
    navigation : true,
    slideSpeed : 300,
    pagination: false,
    autoPlay: 5000,
    items : 4,
  });

  //--------------- for navigation---------------------
  
  $('.navbar-collapse ul li a').click(function() {
    $('.navbar-toggle:visible').click();
  });
  
  //--------------- -Loading the map ------------------

  $(document).on('click','.contact-map',function(event){
    event.preventDefault();
    initialize();
  });

  // ------------- Magnific--------------

  $('.test-popup-link').magnificPopup({
    type:'image',
    closeBtnInside:true,
    // Delay in milliseconds before popup is removed
    removalDelay: 300,

    // Class that is added to popup wrapper and background
    // make it unique to apply your CSS animations just to this exact popup
    mainClass: 'mfp-fade',
    gallery: {
      enabled: true, // set to true to enable gallery

      preload: [0,2], // read about this option in next Lazy-loading section

      navigateByImgClick: true,

      //arrowMarkup: '<button title="%title%" type="button" class="mfp-arrow mfp-arrow-%dir%"></button>', // markup of an arrow button

      closeMarkup: '<button title="%title%" class="mfp-close"><i class="mfp-close-icn">&times;</i></button>',

      tPrev: 'Previous (Left arrow key)', // title for left button
      tNext: 'Next (Right arrow key)', // title for right button
      //tCounter: '<span class="mfp-counter">%curr% of %total%</span>' // markup of counter
    }
  });
 
  // ------------------Carousel-------------- 

  $('#myCarousel, #myCarousel2').carousel({
    interval: 4000,
    pause: "null"
  })

//-----------Text Slider on Banner-----------

  $('.flex_text').flexslider({
    animation: "slide",
    selector: ".slides li",
    controlNav: false,
    directionNav: false,
    slideshowSpeed: 4000,
    touch: true,
    useCSS: false,
    direction: "vertical",
    before: function(slider) {        
      var height = $('.flex_text').find('.flex-viewport').innerHeight();
      $('.flex_text').find('li').css({ height: height + 'px' });
    }
  });

  // ----------initializing the wow.js ---------
  // Animate and WOW Animation
  var wow = new WOW({
    //offset: 50,
    mobile: false
    // live: true
  });
  wow.init();

  //------------------video popup---------------

  $('.play').magnificPopup({
    disableOn: 700,
    type: 'iframe',
    mainClass: 'mfp-fade',
    removalDelay: 160,
    preloader: false,
    fixedContentPos: false
  });

    
  // --------------Newsletter-----------------------

  $(".newsletter-signup").ajaxChimp({
    callback: mailchimpResponse,
    url: "http://codepassenger.us10.list-manage.com/subscribe/post?u=6b2e008d85f125cf2eb2b40e9&id=6083876991" // Replace your mailchimp post url inside double quote "".  
  });

  function mailchimpResponse(resp) {
     if(resp.result === 'success') {
      $('.newsletter-success').html(resp.msg).fadeIn().delay(3000).fadeOut();  
    } else if(resp.result === 'error') {
      $('.newsletter-error').html(resp.msg).fadeIn().delay(3000).fadeOut();
    }
  };

  // --------------Contact Form Ajax request-----------------------

  $('.form-horizontal').on('submit', function(event) {
    event.preventDefault();

    $this = $(this);

    var data = {
      first_name: $('#first_name').val(),
      last_name: $('#last_name').val(),
      email: $('#email').val(),
      subject: $('#subject').val(),
      message: $('#message').val()
    };

    $.ajax({
      type: "POST",
      url: "email.php",
      data: data,
      success: function(msg){
       $('.contact-success').fadeIn().delay(3000).fadeOut();
      }
    });
  });

  $('#banner').parallax("50%", 0.5, true);
  $('#feature').parallax("50%", 0.5, true);
  $('#video').parallax("50%", 0.5, true);
  $('#subscription').parallax("50%", 0.5, true);
  $('#review').parallax("50%", 0.5, true);
  $('#download').parallax("50%", 0.5, true);
  $('#footer').parallax("50%", 0.5, true);

});


var fullScreenHome = function() {
    if(matchMedia( "(min-width: 992px) and (min-height: 500px)" ).matches) {
      "use strict"; //RUN JS IN STRICT MODE
    var height = $(window).height();
      contH = $(".banner .col-sm-12").height(),
      contH = $(".banner-carousel .col-sm-12").height(),
      contMT = (height / 2) - (contH / 2);
    $(".banner-carousel").css('min-height', height + "px");
    $(".trans-bg").css('min-height', height + "px");
    $(".banner .col-sm-12").css('margin-top', (contMT - 270) + "px");
    $(".banner-carousel .col-sm-12").css('margin-top', (contMT - 10) + "px");
  }
}

$(document).ready(fullScreenHome);
$(window).resize(fullScreenHome);

  // --------Google map---------------
  var map;
  function initialize() {  
    // Create an array of styles.
    var styles = [
    {
      stylers: [
      { hue: "#0AABE1" },
      { saturation: 0 }
      ]
    },
    {
      featureType: 'water',
      stylers: [
       { visibility: "on" },
       { color: "#9a9efd" },
       { weight: 2.2 },
       { gamma: 2.54 }
      ] 
    },
    {
      featureType: "road",
      elementType: "geometry",
      stylers: [
      { lightness: 100 },
      { visibility: "simplified" }
      ]
    },{
      featureType: "road",
      elementType: "labels",
      stylers: [
      { visibility: "off" }
      ]
    }
    ];

    // Create a new StyledMapType object, passing it the array of styles,
    // as well as the name to be displayed on the map type control.
    var styledMap = new google.maps.StyledMapType(styles,
    {name: "Styled Map"});

    // Create a map object, and include the MapTypeId to add
    // to the map type control.
    var losAngeles = new google.maps.LatLng(33.8030716,-118.0725641);
    var mapOptions = {
    zoom: 13,
    center: losAngeles,
    mapTypeControlOptions: {
      mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'map_style']
    },
    scrollwheel: false,
    };
    var map = new google.maps.Map(document.getElementById('map'),
    mapOptions);
    

    //Associate the styled map with the MapTypeId and set it to display.
    map.mapTypes.set('map_style', styledMap);
    map.setMapTypeId('map_style');

    // To add the marker to the map, use the 'map' property
    var image = 'assets/images/map_icon_3.png';
    var marker = new google.maps.Marker({
      position: losAngeles,
      map: map,
      title:"GRAPE App Store!",
      icon: image
    });
  }