var toolbar_shown = false;

!(function( $ ) {

    // Search Toggle
    $( document ).on( 'click', '.tm-primary-menu .tm-search-toggle', function() {

    	var searchSelector = '.tm-primary-menu .tm-search';

    	$( searchSelector ).toggle();
    	$( '.tm-primary-menu .uk-navbar-nav' ).toggle();

    	if ( $( searchSelector ).is( ':visible' ) ) {

            $( searchSelector ).find( 'input' ).focus();
            $( this ).find( 'i').removeClass( 'uk-icon-search' ).addClass( 'uk-icon-close' );

        } else {

            $( this ).find( 'i').removeClass( 'uk-icon-close' ).addClass( 'uk-icon-search' );
        }

    } );

    // Toolbar toggle
    $(window).scroll(function() {
      var height = $(window).scrollTop();

      if(height  > 300) {
  			if(!toolbar_shown) {
  					$('#tm-toolbar').slideToggle('fast');
  			}
  			toolbar_shown = true;
      }
  		else if(height <= 300) {
  			if(toolbar_shown) {
  					$('#tm-toolbar').slideToggle('fast');
  			}
  			toolbar_shown = false;
  		}
  	});
    
    // FB Nav Bar
    if ($(window).width() < 960) {
        $(window).scroll(function () {
            if ($(window).scrollTop() > 400) {
                $('#fb-nav-bar').addClass('slideDown');
                console.log("Mobile Scroll Down");
                //$('.hideme').slideUp();
            } else {
                $('#fb-nav-bar').removeClass('slideDown');
                //$('.hideme').slideDown();
            }

        });
    }
    var postURL = document.querySelector("link[rel='canonical']").getAttribute("href");
    var postTitle;
    // On Click Fire FB Share
    $('#nav-fb-share').click(function () {
        var fbURL = encodeURIComponent(postURL);
        window.open('https://www.facebook.com/sharer/sharer.php?u=' + fbURL);
    });
    // On Click Fire Tweet
    $('#nav-tweet-share').click(function () {
        postTitle = $('h1.uk-article-title').text();
        window.open('http://twitter.com/share?text=' + postTitle + '&url=' + postURL);
    });

} )( window.jQuery );

//Facebook Share
function fbShare(url, title, descr, image, winWidth, winHeight) {
    var winTop = (screen.height / 2) - (winHeight),
        winLeft = (screen.width / 2) - (winWidth / 2);
    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
        // tasks to do if it is a Mobile Device
        window.open('http://m.facebook.com/sharer.php?u=' + url);
    } else {
        window.open('http://www.facebook.com/sharer.php?s=100&p[title]=' + title + '&p[summary]=' + descr + '&u=' + encodeURIComponent(url) + '&p[images][0]=' + image, 'sharer', 'top=' + winTop + ',left=' + winLeft + ',toolbar=0,status=0,width=' + winWidth + ',height=' + winHeight);
    }
}