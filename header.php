<?php
	// set the cover image for fb or other social networks
	$favicon = get_stylesheet_directory_uri() . '/images/favicon.ico';
	$og_meta = get_og_meta();
?>
<!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="description" content="<? echo $og_meta['og:description']; ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<?php
			foreach ($og_meta as $property => $content) {
				echo '<meta property="' . $property . '" content="' . $content . '" />';
			}
		?>
		<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCwLYX2iURWnQMwmGfHDcQ2rqNXfvECQbI"></script>
		<!-- <link rel="apple-touch-icon" href="apple-touch-icon.png"> -->
		<!-- <link rel="shortcut icon" href="<?php echo $favicon; ?>" /> -->
		<?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?>>
		<!--[if lt IE 8]>
			<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
		<![endif]-->
		<div id="fb-root"></div>

		<div id="page" class="clearfix">

			<header id="header">
				<div class="top-bar-container" style="background-image:url(<?php echo get_header_image() ?>)">
					<div id="top-bar">
						<button class="main-menu-toggle">
							<span class="visuallyhidden"><?php echo __('Main menu', 'liptvozije') ?></span>
						</button>
						<a href="<?php echo esc_url(home_url('/')); ?>" class="main-title">
							<div class="main-logo">
								<?php include(get_template_directory() . '/images/logo_small.svg'); ?>
								<h1 class="site-title visuallyhidden"><?php bloginfo('title') ?></h1>
							</div>
							<p class="site-description"><?php echo get_bloginfo('description') ?></p>
						</a>
						<button class="sidebar-toggle">
							<span class="visuallyhidden"><?php echo __('Sidebar', 'liptovzije') ?></span>
						</button>
						<button class="search-toggle">
							<span class="visuallyhidden"><?php echo __('Search', 'liptovzije') ?></span>
						</button>
					</div><!-- #top-bar -->
				</div><!-- .top-bar-container -->

				<div class="menu-bar-container">
					<div class="menu-bar">
						<a href="<?php echo esc_url(home_url('/')); ?>" class="small-title">
							<div class="main-logo">
								<?php include(get_template_directory() . '/images/logo_small.svg'); ?>
								<h1 class="visuallyhidden"><?php echo get_bloginfo('title') ?></h1>
							</div>
						</a>
						<div class="search-social-container">
							<?php
								the_social();
								get_search_form();
							?>
						</div><!-- .search-social-container -->
						<div class="main-menu-container">
							<?php
								wp_nav_menu(array(
									'theme_location'	=> 'main',
									'container'			=> 'nav',
									'container_id'		=> 'main-menu'
								));
							?>
						</div><!-- .main-menu-container -->
					</div><!-- .menu-bar -->
				</div><!-- .menu-bar-container -->
			</header><!-- #header -->

			<div id="main" class="clearfix">
