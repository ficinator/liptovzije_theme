jQuery(document).bind('em_maps_location_hook', function(e, map, infowindow, marker) {
	setTimeout(function() {
		infowindow.close();
		map.setCenter(marker.getPosition());
	}, 1000);
});

// Google Analytics
(function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
e=o.createElement(i);r=o.getElementsByTagName(i)[0];
e.src='//www.google-analytics.com/analytics.js';
r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
ga('create','UA-56862049-1','auto');ga('send','pageview');