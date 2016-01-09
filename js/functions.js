(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=616388971794628&version=v2.3";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

(function($) {

	function esc_jq(str) {
		return str.replace(/([;&,\.\+\*\~':"\!\^$%@\[\]\(\)=>\|])/g, '\\$1');
	}

	$screenTiny		= 450;
	$screenSmaller	= 600;
	$screenSmall	= 720;
	$screenMedium	= 800;
	$screenBig		= 1044;
	$screenBigger	= 1200;
	$screenHuge		= 1720;
	$topBarHeight = 50;

	$player = $('#radio-l-stream')[0];
	$volume = 0.5;

	$('.main-menu-toggle').click(function() {
		$(this).toggleClass('clicked');
		$('.main-menu-container').slideToggle();
	});

	$('.search-toggle').click(function() {
		$(this).toggleClass('clicked');
		$('.menu-bar .search-form').toggle().find('input[type=text]').focus();
	});

	$('.sidebar-toggle').click(function() {
		$(this).toggleClass('clicked');
		$('#sidebar').slideToggle();
	});

	// slider
	$('#slider').carousel({ interval: 5000 });
	var clickEvent = false;
	$('#slider').on('click', '.nav a', function() {
			clickEvent = true;
			$('.nav li').removeClass('active');
			$(this).parent().addClass('active');		
	}).on('slid.bs.carousel', function(e) {
		if(!clickEvent) {
			var count = $('.nav').children().length -1;
			var current = $('.nav li.active');
			current.removeClass('active').next().addClass('active');
			var id = parseInt(current.data('slide-to'));
			if(count == id) {
				$('.nav li').first().addClass('active');	
			}
		}
		clickEvent = false;
	});

	$('#map-toggle').click(function() {
		$(this).toggleClass('clicked').closest('.event-details').find('.map-container').stop().toggleClass('visible');
	});

	$('#schedule').tabs();

	$('.day-schedule a').click(function(){
    $('html, body').animate({
        scrollTop: $(esc_jq($(this).attr('href'))).offset().top - $topBarHeight - 10
    }, 500);
    return false;
	});

	// responsive scripts
	enquire
	// .register('screen and (max-width: ' + $screenSmaller + 'px)', {
	// 	match: function() {
	// 		$('#header').stick_in_parent();
	// 	},
	// 	unmatch: function() {
	// 		$('#header').trigger('sticky_kit:detach');
	// 	}
	// })
	.register('screen and (min-width: ' + ($screenSmaller + 1) + 'px)', {
		match: function() {
			$topBarHeight = 40;
			$('.main-menu-container, .menu-bar .search-form, #sidebar').show();
			$('.sub-menu').hide();
			$('.menu-item-has-children').hover(function() {
				$(this).find('.sub-menu').stop().slideToggle();
			});

			$('.menu-bar-container').hcSticky({ stickTo: document });
		},
		unmatch: function() {
			$('.main-menu-toggle, .search-toggle, .sidebar-toggle').removeClass('clicked');
			$('.main-menu-container, .menu-bar .search-form, #sidebar').hide();
			$('.sub-menu').show();
			$('.menu-item-has-children').unbind('mouseenter mouseleave');
			$('.menu-bar-container, #sidebar, #primary .entry-header .stripe').hcSticky('off');
		}
	})
	.register('screen and (min-width: ' + ($screenSmaller + 1) + 'px) and (max-width: ' + $screenHuge + 'px)', {
		match: function() {
			$topBarHeight = 40;
			// $('#ga-ads').hcSticky({ top: 50 });
			$('#sidebar').hcSticky({ top: $topBarHeight + 10 });
			$('#primary .entry-header .stripe').hcSticky({
				stickTo: '#primary',
				top: $topBarHeight
			});
		},
		unmatch: function() {
			//$('#sidebar, .entry-header .stripe').hcSticky('off');
		}
	})
	.register('screen and (min-width: ' + ($screenHuge + 1) + 'px)', {
		match: function() {
			$topBarHeight = 50;
			// $('#ga-ads').hcSticky({ top: $topBarHeight });
			$('#sidebar').hcSticky({ top: $topBarHeight + 10 });
			$('#primary .entry-header .stripe').hcSticky({
				stickTo: '#primary',
				top: $topBarHeight
			});
		},
		unmatch: function() {
			//$('#sidebar, .entry-header .stripe').hcSticky('off');
		}
	});

	// $(window).resize(function() {
	// 	$('.entry-header .stripe').hcSticky('reinit');
	// });

	$player.volume = $volume;
	$player.onplaying = function() {
		$('#play-pause').removeClass('loading').addClass('playing');
	};
	$player.onvolumechange = function() {
		$('#mute').removeClass('muted high');
		$('#volume .ui-slider-range').width(($player.volume * 100) + '%');
		if ($player.volume == 0)
			$('#mute').addClass('muted');
		else {
			if ($player.volume > 0.5)
				$('#mute').addClass('high');
		}
	};
	$('#play-pause').click(function() {
    	if ($player.paused) {
        	$player.play();
        	$(this).addClass('loading');
    	}
    	else {
        	$player.pause();
        	$(this).removeClass('playing loading');
    	}
	});
	$('#mute').click(function() {
		if ($player.volume == 0)
			$player.volume = $volume;
		else {
			$volume = $player.volume;
			$player.volume = 0;
		}
	});
	$('#volume').slider({
		min: 0,
		max: 100,
		value: 50,
		animate: true,
		range: 'min',
		slide: function(e, ui) {
			$player.muted = false;
			$player.volume = ui.value / 100;
		}
	});

})(jQuery);
