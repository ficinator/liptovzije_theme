<?php

if (!isset($content_width))
	$content_width = 700;

if (!function_exists('liptovzije_setup')):

function liptovzije_setup() {

	load_theme_textdomain('liptovzije', get_template_directory() . '/languages');

	show_admin_bar(false);

	add_theme_support('title-tag');

	add_theme_support('post-thumbnails');
	set_post_thumbnail_size(150, 150);

	register_nav_menus(array(
		'main' => __('Top primary menu', 'liptovzije')
	));

	add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));

	add_theme_support('post-formats', array('aside', 'image', 'video', 'audio', 'quote', 'link', 'gallery'));

	add_theme_support('custom-header');
}

endif;

add_action('after_setup_theme', 'liptovzije_setup');

function liptovzije_scripts() {
	wp_enqueue_style('roboto', 'http://fonts.googleapis.com/css?family=Roboto:400,300,700,900');
	//wp_enqueue_style('genericons', get_template_directory_uri() . '/genericons/genericons.css');
	wp_enqueue_style('font-awesome', get_template_directory_uri() . '/font-awesome/css/font-awesome.min.css');
	wp_enqueue_style('liptovzije-style', get_stylesheet_uri());

	wp_enqueue_script('jquery-ui-script', '//code.jquery.com/ui/1.11.4/jquery-ui.js', array('jquery'));
	wp_enqueue_script('bootstrap-script', get_template_directory_uri() . '/js/bootstrap.min.js');
	//wp_enqueue_script('sticky-kit-script', get_template_directory_uri() . '/js/sticky-kit.min.js', array('jquery'));
	wp_enqueue_script('hc-sticky-script', get_template_directory_uri() . '/js/jquery.hc-sticky.min.js', array('jquery'));
	//wp_enqueue_script('jwplayer-script', 'http://jwpsrv.com/library/eVCHtN1jEeSszA4AfQhyIQ.js');
	wp_enqueue_script('maps-script', get_template_directory_uri() . '/js/maps.js', array('jquery'));

	wp_enqueue_script('enquire-script', get_template_directory_uri() . '/js/enquire.min.js', false, false, true);
	wp_enqueue_script('liptovzije-script', get_template_directory_uri() . '/js/functions.js', array('jquery'), false, true);
}

add_action('wp_enqueue_scripts', 'liptovzije_scripts');

function liptovzije_widgets_init() {
	register_sidebar(array(
		'name'          => __('Primary Sidebar'),
		'id'            => 'sidebar',
		'description'   => __('Main sidebar that appears on the right.'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	));
	register_sidebar(array(
		'name'          => __('Footer Sidebar'),
		'id'            => 'footer',
		'description'   => __('Footer sidebar that appears on the right down.'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	));
}

add_action('widgets_init', 'liptovzije_widgets_init');

function add_events($query) {
	$post_types = array(
		'post',
		'nav_menu_item',
		'event'
	);
	if (is_archive())
		$query->set('post_type', $post_types);
	return $query;
}
add_filter('pre_get_posts', 'add_events');

function get_my_excerpt($id = false, $length = 20) {
    global $post;

    $old_post = $post;
    if ($id != $post->ID) {
        $post = get_page($id);
    }

    if (!$excerpt = trim($post->post_excerpt)) {
        $excerpt = $post->post_content;
        $excerpt = strip_shortcodes($excerpt);
        $excerpt = apply_filters('the_content', $excerpt);
        $excerpt = str_replace(']]>', ']]&gt;', $excerpt);
        $excerpt = strip_tags($excerpt);
        $excerpt_length = apply_filters('excerpt_length', $length);
        $excerpt_more = apply_filters('excerpt_more', '...');

        $words = preg_split("/[\n\r\t ]+/", $excerpt, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY);
        if (count($words) > $excerpt_length) {
            array_pop($words);
            $excerpt = implode(' ', $words);
            $excerpt = $excerpt . $excerpt_more;
        } else {
            $excerpt = implode(' ', $words);
        }
    }

    $post = $old_post;

    return $excerpt;
}

function register_event_taxonomies() {
	register_taxonomy_for_object_type('category', 'event');
	register_taxonomy_for_object_type('post_tag', 'event');
}
add_action('init', 'register_event_taxonomies');

function the_custom_categories($separator = ', ') {
	$cats = get_the_terms(get_the_ID(), 'category');
	$i = 0;
	foreach ($cats as $id => $cat) {
		echo '<a href="' . esc_url(get_category_link($id)) . '">' . $cat->name . '</a>';
		if ($i < sizeof($cats) - 1) {
			echo $separator;
			$i++;
		}
	}
}

function get_page_slug($id = null) {
	if ($id == null)
		$id = get_the_ID();
	$slug = get_page_template_slug($id);
	$tmp = explode('.', $slug);
	return str_replace('page-', '', $tmp[0]);
}

function current_nav_class($classes, $item) {
	if (is_single()) {
		$cat_photo = get_category_by_slug('photo-of-the-week');
		// photo-of-the-week
	    if (has_category($cat_photo->cat_ID)) {
	    	if ($item->object == 'category' && $item->object_id == $cat_photo->cat_ID) {
	    		$classes[] = 'current-menu-item';
	    	}
	    }
	    // everything else
	    else {
	    	if ($item->object == 'page') {
		    	if (get_post_type() == 'event' && get_page_slug($item->object_id) == 'events') {
		    		$classes[] = 'current-menu-item';
		    	}
		    	if (get_post_type() == 'post' && get_page_slug($item->object_id) == 'articles') {
			    	$classes[] = 'current-menu-item';
			    }
			}
		}
	}

    return $classes;
}

add_filter('nav_menu_css_class', 'current_nav_class', 10, 2);

function get_cover_image_uri($id, $size = 'large') {
	$thumb = wp_get_attachment_image_src(get_post_thumbnail_id($id), $size);
	return empty($thumb) ? null : $thumb['0'];
	// $url = get_template_directory_uri() . '/images/logo.jpg';
}

function the_cover_image($id = null, $size = 'large', $link_to_post = true, $date = null) {
	$default = false;
	if ($id == null)
		$id = get_the_ID();
	$url = get_cover_image_uri($id, $size);
	if (!$url) {
		$default = true;
		$url = get_template_directory_uri() . '/images/placeholder.svg';
	}
	echo '<a href="' . ($link_to_post ? esc_url(get_permalink($id)) : $url) . '" og:image class="cover-image ' . $size . ' ';
	if ($default)
		echo 'default';
    echo '" style="background-image:url(' . $url . ')">';
    if ($date) {
		echo '<div class="event-date">';
		echo '<div class="day">' . date('j', $date) . '</div>';
		echo '<div class="month">' . date('M', $date) . '</div>';
		echo '</div>';
    }
    echo '</a>';
}

function the_events_tabs() {
	$tab_names = array('Udalosti', 'Uplynulé', 'Kalendár');

	echo '<ul class="event-tabs">';
	foreach ($tab_names as $tab_name) {
		$page = get_page_by_title($tab_name);
		$tab_name = $tab_name == 'Udalosti' ? 'Budúce' : $tab_name;
		echo '<li' . ($page->ID == get_the_ID() ? ' class="current"' : '') . '><a href="' . esc_url(get_the_permalink($page->ID)) . '">' . $tab_name . '</a></li>';
	}
	echo '</ul>';	// .events-tabs
}

function the_pagination($max_num_pages) {
	echo '<div class="pagination">';
	echo paginate_links(array(
		'total'		=> $max_num_pages,
		'prev_text'	=> __('Previous', 'liptovzije'),
		'next_text'	=> __('Next', 'liptovzije')
	));
	echo '</div>';	// .pagination
}

function the_prev_next_posts($in_same_term = false, $excluded_terms = array()) {
	$posts = array(
		'prev'	=> get_previous_post($in_same_term, $excluded_terms),
		'next'	=> get_next_post($in_same_term, $excluded_terms));

	echo '<nav class="post-navigation">';
	echo '<h3 class="visuallyhidden">' . __('Previous and Next Posts', 'autop') . '</h3>';
	echo '<div class="nav-links">';

	echo '<div class="container prev">';
	if (($prev = $posts['prev'])) {
		echo '<a href="' . esc_url(get_permalink($prev->ID)) . '"';
		if (($url = get_cover_image_uri($prev->ID, 'medium')))
			echo ' style="background-image:url(' . $url . ')"';
		echo '>';
		echo '<div class="overlay">';
		if ($prev->post_type == 'event') {
			$events = EM_Events::get(array(
				'post_id'	=> $prev->ID,
				'scope'		=> 'all'
			));
			$EM_Event = $events[0];
			echo '<div class="event-date">';
			echo '<div class="day">' . $EM_Event->output('#j') . '</div>';
			echo '<div class="month">' . $EM_Event->output('#M') . '</div>';
			echo '</div>';
		}
		echo '<div class="title">' . $prev->post_title . '</div>';
		echo '</div>';	// .overlay
		echo '</a>';
	}
	echo '</div>';	// .container

	echo '<div class="container next">';
	if (($next = $posts['next'])) {
		echo '<a href="' . esc_url(get_permalink($next->ID)) . '"';
		if (($url = get_cover_image_uri($next->ID, 'medium')))
			echo ' style="background-image:url(' . $url . ')"';
		echo '>';
		echo '<div class="overlay">';
		echo '<div class="title">' . $next->post_title . '</div>';
		if ($next->post_type == 'event') {
			$events = EM_Events::get(array(
				'post_id'	=> $next->ID,
				'scope'		=> 'all'
			));
			$EM_Event = $events[0];
			echo '<div class="event-date">';
			echo '<div class="day">' . $EM_Event->output('#j') . '</div>';
			echo '<div class="month">' . $EM_Event->output('#M') . '</div>';
			echo '</div>';
		}
		echo '</div>';	// .overlay
		echo '</a>';
	}
	echo '</div>';	// .container

	echo '</div>';	// .nav-links
	echo '</nav>';	// .post-navigation
}

function get_the_social($title, $url) {
	$title = urlencode($title);
	$url = esc_url($url);
	return array(
		'facebook'	=> 'http://www.facebook.com/sharer/sharer.php?u=' . $url . '&title=' . $title,
		'plus'		=> 'https://plus.google.com/share?url=' . $url,
		'twitter'	=> 'http://twitter.com/intent/tweet?status=' . $title . '+' . $url
	);
}

function the_social() {
	$social = array(
		'facebook'	=> 'https://www.facebook.com/liptovzije',
		'youtube'	=> 'https://www.youtube.com/channel/UCguBWbIAbPzgTgE-RS8mf_g',
		'instagram'	=> 'https://instagram.com/liptovzije/'
	);
	echo '<aside class="social">';
	echo '<h4 class="title">' . __('Social') . '</h4>';
	echo '<ul>';
	foreach ($social as $name => $url) {
		echo '<li class="' . $name . '">';
		echo '<a href="' . $url . '" target="_blank"><span class="visuallyhidden">' . __($name, 'autop') . '</span></a>';
		echo '</li>';	// .name
	}
	echo '</ul>';
	echo '</aside>';	// .social
}

function the_social_share() {
	$permalink = get_the_permalink();
	echo '<div class="social-share">';
	echo '<h4 class="title">' . __('Share This', 'liptovzije') . '</h4>';
	echo '<ul>';
	echo '<li class="like">';
	echo '<div class="fb-like"
		data-href="' . esc_url($permalink) . '"
		data-layout="button_count"
		data-action="like"
		data-show-faces="false"
		data-share="false"></div>';
	echo '</li>';	// .like
	foreach (get_the_social(get_the_title(), $permalink) as $name => $url) {
		echo '<li class="' . $name . '">';
		echo '<a href="' . $url . '" onclick="window.open(\'' . $url . '\', \'newwindow\', \'width=400, height=300\'); return false;">';
		echo '<span class="visuallyhidden">' . $name . '</span>';
		echo '</a>';
		echo '</li>';	// .name
	}
	echo '</ul></div>';	// .social-share
}

function the_slider($query, $number = 4) {

	$posts = array();
	$i = 0;

	echo '<div id="slider" class="carousel slide" data-ride="carousel">';
	echo '<div class="slide-container">';
	while ($query->have_posts() && $i < $number) {
		$query->the_post();
		$posts[$i] = array(
			'id'		=> get_the_ID(),
			'title'		=> get_the_title(),
			'thumb'		=> get_the_post_thumbnail($id, 'thumbnail')
		);
		if (get_post_type() == 'event') {
			$events = EM_Events::get(array(
				'post_id'	=> get_the_ID(),
				'scope'		=> 'all'
			));
			$EM_Event = $events[0];
			$posts[$i]['day'] = $EM_Event->output('#j');
			$posts[$i]['month']	= $EM_Event->output('#M');
			$post_date = date('j. n. Y', strtotime($EM_Event->post_date));
		}
		else {
			$post_date = get_the_date('j. n. Y');
		}

		echo '<div class="item';
		if ($i == 0)
			echo ' active';
		echo '">';
		echo '<div class="photo-container">';
		if (has_post_thumbnail())
			the_cover_image($id, 'large');
		echo '</div>';	// .photo-container
		echo '<div class="stripe dark';
		if (!empty($posts[$i]['day'])) {
			echo ' event">';
			echo '<div class="event-date">';
			echo '<div class="day">' . $posts[$i]['day'] . '</div>';
			echo '<div class="month">' . $posts[$i]['month'] . '</div>';
			echo '</div>';	// .event-date
		}
		else
			echo '">';
		echo '<div class="stripe-content">';
		echo '<a href="' . esc_url(get_the_permalink()) . '">';
		echo '<h2 class="entry-title">' . get_the_title() . '</h2>';
		echo '<div class="entry-details">' . get_my_excerpt() . '</div>';
		echo '</a>';
		echo '</div>';	// .stripe-content
		echo '</div>';	// .stripe.dark
		echo '</div>';	// .item

		$i++;
	}
	echo '</div>';	// .slide-container

	echo '<ul class="nav">';
	foreach ($posts as $i => $p) {
		echo '<li data-target="#slider" data-slide-to="' . $i . '"';
		if ($i == 0)
			echo 'class="active"';
		echo '>';
		echo '<a href="#">';
		echo '<div class="container">';
		echo '<div class="thumb">';
		if (!empty($p['day'])) {
			echo '<div class="event-date">';
			echo '<div class="day">' . $posts[$i]['day'] . '</div>';
			echo '<div class="month">' . $posts[$i]['month'] . '</div>';
			echo '</div>';	// .event-date
		}
		echo $p['thumb'];
		echo '</div>';	// .thumb
		echo '<h3 class="title">' . $p['title'] . '</h3>';
		echo '</div>';	// .container
		echo '</a>';
		echo '</li>';
	}
	echo '</ul>';	// .nav

	echo '</div>';	// #slider
}

function the_photo_of_the_week() {
	$cat = get_category_by_slug('photo-of-the-week');
	$args = array( 
		'post_type'	=> 'post',
		'cat'		=> $cat->cat_ID,
		'limit'		=> 1
	);
	$photo_query = new WP_Query($args);

	echo '<aside class="widget photo-of-the-week">';
	echo '<h3 class="widget-title">' . __('Golden Apple Cinema Photo of the Week', 'liptovzije') . '</h3>';
	if ($photo_query->have_posts()) {
		$photo_query->the_post();
		echo '<div class="photo-container">';
		echo '<a href="' . esc_url(get_category_link($cat->cat_ID)) . '">';
		echo '<img src="' . get_cover_image_uri(get_the_ID(), 'medium') . '" alt="' . $cat->name . '" class="cover-image" />';
		echo '<div class="stripe dark">';
		echo '<div class="stripe-content">';
		echo '<h2>' . get_the_title() . '</h2>';
		echo '<div class="entry-details">' . get_my_excerpt() . '</div>';
		echo '</div>';	// .stripe-content
		echo '</div>';	// .stripe
		echo '</a>';
		echo '</div>';	// .photo-container
	}
	echo '</aside>';	// .widget.photo-of-the-week
	wp_reset_query();
}

function the_partners() {
	$partners = array(
		'ga-cinema'		=> 'http://www.gacinema.sk/',
		'freerideLM'	=> 'http://freeridelm.sk/',
		'radio-liptov'	=> 'http://www.radioliptov.sk/index.php',
		'liptov-lasers'	=> 'http://www.liptovlasers.com/sk',
	);

	echo '<section class="partners">';
	// echo '<h4 class="title">' . __('Partners', 'liptovzije') . '</h4>';
	echo '<ul>';
	foreach ($partners as $name => $url) {
		echo '<li class="' . $name . '">';
		echo '<a href="' . $url . '" target="_blank">';
		echo '<div class="visuallyhidden">' . __($name, 'liptovzije') . '</div>';
		echo '</a>';
		echo '</li>';	// $name
	}
	echo '</ul>';
	echo '</section>';	// .partners
}

function the_copyright() {
	$year = 2015;
	echo '<aside class="copyright">';
	echo '<div class="logo-z">';
	include(get_template_directory() . '/images/logo_Z.svg');
	echo '</div>';		// .logo-z
	echo '<div class="year">Liptov Žije &copy; ' . $year . '</div>';
	echo '</aside>';
}

function the_contact() {
	$email = 'liptovzije@liptovzije.sk';
	echo '<aside class="contact">';
	echo '<h4 class="title">' . __('Contact', 'liptovzije') . '</h4>';
	echo '<p class="email">';
	echo '<a href="mailto:' . $email . '" target="_top">' . $email . '</a>';
	echo '</p>';		// .email
	echo '</aside>';	// .contact
}

function get_og_meta() {
	$og_meta = array(
		'og:site_name'	=> get_bloginfo('name'),
		'fb:app_id'	=> 797125726976626,
		'og:locale'	=> 'sk_SK'
	);
	if (is_home()) {
		$og_meta['og:url'] = esc_url(home_url());
	}
	else {
		$og_meta['og:url'] = esc_url(get_the_permalink());
	}
	if (is_single()) {
		$og_meta['og:image'] = get_cover_image_uri(get_the_ID());
		$og_meta['og:title'] = get_the_title();
		$og_meta['og:description'] = get_my_excerpt();
		$og_meta['og:type'] = 'article';
	}
	else {
		$og_meta['og:image'] = get_template_directory_uri() . '/images/liptov_zije_fb.png';
		$og_meta['og:title'] = $og_meta['og:site_name'];
		$og_meta['og:description'] = 'Nuda na Liptove? Tak s tou je koniec! Vitajte na liptovskom portáli, na ktorom nájdete aktuálne udalosti z Liptova, súťaže a veľa prekrásnych inšpirácii.';
		$og_meta['og:type'] = 'website';
	}
	return $og_meta;
}

function radio_l() {
	$url = 'http://www.radioliptov.sk/index.php';
	$stream_url = 'http://95.105.254.157:80/radioliptov';
	$stream_url2 = 'http://www.radioliptov.sk/stream.m3u';

	echo '<aside class="widget radio-liptov-stream">';
	echo '<a href="' . $url . '" target="_blank" class="radio-logo">';
	echo '<img src="' . get_template_directory_uri() . '/images/radio_liptov.png" alt="' . __('Radio Liptov', 'liptovzije') . '" />';
	echo '</a>';
	echo '<div class="radio-container">';
	echo '<audio id="radio-l-stream" preload="none">'; 
	echo '<source src="' . $stream_url . '">';
	echo '<p>' . __('Your browser doesn\'t support HTML audio. Sorry.') . '</p>';
	echo '</audio>';
	echo '<button id="play-pause"><span class="visuallyhidden">' . __('Play/Pause', 'liptovzije') . '</span></button>';
	echo '<button id="mute"><span class="visuallyhidden">' . __('Mute', 'liptovzije') . '</span></button>';
	echo '<div id="volume"></div>';
	echo '<a href="' . $stream_url2 . '" target="_blank" class="note">' . __('If the stream doesn\'t work, click here.', 'liptovzije') . '</a>';
	echo '</div>';		// .radio-container
	echo '</aside>';	// .widget.radio-liptov-stream
}

function radio_pre_zivot() {
	$url = 'http://radioprezivot.sk/';
	$stream_url = 'http://www.internetoveradio.sk/radioplayer.swf';

	echo '<aside class="widget radio-pre-zivot-stream">';
	echo '<a href="' . $url . '" target="_blank" class="radio-logo">';
	echo '<img src="' . get_template_directory_uri() . '/images/radio_pre_zivot.png" alt="' . __('Rádio pre Život', 'liptovzije') . '" />';
	echo '</a>';
	echo '<div class="radio-container">';
	echo '<h3 class="widget-title"><a href="' . $url . '" target="_blank">' . __('Rádio pre Život') . '</a></h3>';
	echo '<embed type="application/x-shockwave-flash" src="' . $stream_url . '" id="radio-pre-zivot-stream" quality="high" allowfullscreen="false" allowscriptaccess="always" flashvars="file=http://server1.internetoveradio.sk:8824/;stream.nsv&amp;type=mp3&amp;volume=60" width="192px" height="20">';
	echo '<a href="' . $url . '" target="_blank" class="note">' . __('If the stream doesn\'t work, click here.', 'liptovzije') . '</a>';
	echo '</div>';		// .radio-container
	echo '</aside>';	// .widget.radio-liptov-stream	
}

function get_ads() {
	if (has_category('photo-of-the-week'))
		get_the_ga_ads('ads left');
}

function parse_ga_movies() {
	$url = 'http://www.disdata.cz/exportxml/533401.xml';
	//$url = get_template_directory() . '/ga_schedule.xml';
	$document = new DomDocument;
	$document->loadXML(file_get_contents($url));
	$e_list = $document->getElementsByTagName('titul');
	$movies = array();
	foreach ($e_list as $e_movie) {
		$id = $e_movie->getElementsByTagName('id')->item(0)->textContent;
		$title = $e_movie->getElementsByTagName('nazov')->item(0)->textContent;
		$date = $e_movie->getElementsByTagName('datum')->item(0)->textContent;
		$time = $e_movie->getElementsByTagName('hodina')->item(0)->textContent;
		$room = $e_movie->getElementsByTagName('sala')->item(0)->textContent;

		if (!array_key_exists($title, $movies)) {
			$movies[$title] = array(
				'dates' => array()
			);
		}
		$date = strtotime($date);
		if (!array_key_exists($date, $movies[$title]['dates'])) {
			$movies[$title]['dates'][$date] = array(
				'times' => array()
			);
		}
		$movies[$title]['dates'][$date]['times'][$time] = array(
			'id'	=> $id,
			'room'	=> $room
		);
		//echo $date;
	}
	return $movies;
}

function parse_ga_schedule() {
	$url = 'http://www.disdata.cz/exportxml/533401.xml';
	//$url = get_template_directory() . '/ga_schedule.xml';
	$document = new DomDocument;
	$document->loadXML(file_get_contents($url));
	$e_list = $document->getElementsByTagName('titul');
	$dates = array();
	foreach ($e_list as $e_movie) {
		$id = $e_movie->getElementsByTagName('id')->item(0)->textContent;
		$title = $e_movie->getElementsByTagName('nazov')->item(0)->textContent;
		$date = $e_movie->getElementsByTagName('datum')->item(0)->textContent;
		$time = $e_movie->getElementsByTagName('hodina')->item(0)->textContent;
		$room = $e_movie->getElementsByTagName('sala')->item(0)->textContent;

		if (!array_key_exists($date, $dates)) {
			$dates[$date] = array();
		}
		$hour = explode(':', $time)[0];
		if (!array_key_exists($hour, $dates[$date])) {
			$dates[$date][$hour] = array();
		}
		$dates[$date][$hour][$title] = array(
			'id'	=> $id,
			'time'	=> $time,
			'room'	=> $room
		);
		//echo $date;
	}
	return $dates;
}

function get_the_ga_ads($classes = '') {
	$url = 'http://gacinema.sk/';
	$document = new DomDocument;
	libxml_use_internal_errors(true);
	$document->loadHtml(file_get_contents($url));
	$e_ads = $document->getElementById('seznam_reklama');
	$ads = array();

	foreach ($e_ads->childNodes as $e_ad) {
		// a
		if ($e_ad->nodeName == 'a') {
			if ($img = $e_ad->getElementsByTagName('img')->item(0)) {
				$img->setAttribute('src', $url . $img->getAttribute('src'));
				array_push($ads, $e_ad);
			}
		}
		else if ($e_ad->nodeName == 'object') {
			if ($embed = $e_ad->getElementsByTagName('embed')->item(0)) {
				$embed->setAttribute('src', $url . $embed->getAttribute('src'));
				array_push($ads, $e_ad);
			}
		}
		// img
		else if ($e_ad->nodeName == 'img') {
			$e_ad->setAttribute('src', $url . $e_ad->getAttribute('src'));
			array_push($ads, $e_ad);
		}
    }

	echo '<div id="ga-ads" class="' . $classes . '">';
    foreach ($ads as $ad) {
    	echo $document->saveHTML($ad);
    }
	echo '</div>';	// #ads-left

	// echo $doc->saveHTML($node);
}

function movie_title($title) {
	$fks_url = '#';
	return str_replace('FKS', '<a href="' . $fks_url . '">FKS</a>', $title);
}
	
?>	