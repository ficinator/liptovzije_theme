<?php
	// $events = EM_Events::get(array(
	// 	'post_id'	=> get_the_ID(),
	// 	'scope'		=> 'all'
	// ));

	global $EM_Event;
	$location_name = $EM_Event->output('#_LOCATIONNAME');
	// foreach($events as $event):
	// 	$start_date = strtotime($event->event_start_date);
	// 	$location = $event->location;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('event clearfix left'); ?>>

	<header class="entry-header">
		<?php
			if (has_post_thumbnail())
				the_cover_image(null, 'large', false);
		?>

		<div class="stripe event<?php if (has_post_thumbnail()) echo ' dark'; ?>">
			<div class="event-date">
				<div class="day"><?php echo $EM_Event->output('#j'); ?></div>
				<div class="month"><?php echo $EM_Event->output('#M'); ?></div>
			</div><!-- .event-date -->
			<div class="stripe-content">
				<?php the_title('<h2 class="entry-title">', '</h2>'); ?>
				<div class="entry-details">
					<span class="date">Pridané <?php echo date('j. n. Y', strtotime($EM_Event->post_date)); ?></span>
					<?php edit_post_link(__('Edit'), '<span class="edit-link">', '</span>'); ?>
				</div><!-- .entry-details -->
			</div><!-- .stripe-content -->
			<?php the_social_share(); ?>
		</div><!-- .stripe -->
	</header><!-- .entry-header -->

	<div class="event-details">
		<div class="top-row">
			<div class="dates"><?php echo $EM_Event->output('#_EVENTDATES') ?></div>
			<div class="times"><?php echo $EM_Event->output('#_EVENTTIMES') ?></div>

			<?php if ($location_name != ''): ?>

			<div class="location">
				<div class="name">
					<?php echo $EM_Event->output('#_LOCATIONLINK'); ?>
				</div><!-- .name -->
				<div class="address">
					<?php
						echo $EM_Event->output('#_LOCATIONADDRESS') . ',';
						$post_code = $EM_Event->output('#_LOCATIONPOSTCODE');
						if ($post_code != null)
							echo ' ' . $post_code;
						echo ' ' . $EM_Event->output('#_LOCATIONTOWN');
						echo ', ' . $EM_Event->output('#_LOCATIONCOUNTRY');
					?>
				</div><!-- .address -->
			</div><!-- .location -->
			<button id="map-toggle">
				<span class="show"><?php _e('Show Map', 'liptovzije'); ?></span>
				<span class="hide"><?php _e('Hide Map', 'liptovzije'); ?></span>
			</button>

			<?php endif; // has location ?>

		</div><!-- .top-row -->

		<?php if ($location_name != ''): ?>

		<div class="map-container">
			<div class="map">
				<?php echo $EM_Event->output('#_LOCATIONMAP{100%,200}') ?>
			</div><!-- .map -->
		</div><!-- .map-container -->

		<?php endif; // has location ?>

	</div><!-- .event-details -->

	<div class="entry-content">
		<?php the_content(); ?>
	</div><!-- .entry-content -->

	<div class="entry-footer">
		<?php
			if (has_category()) {
				echo '<div class="cat-links">';
				echo '<h3 class="title">' . __('Categories') . '</h3>';
				the_custom_categories();
				echo '</div>';
			}
			if (has_tag()) {
				the_tags('<div class="tag-links"><h3 class="title">' . __('Tags') . '</h3>', ', ', '</div>');
			}
		?>
	</div><!-- .entry-footer -->

</article>

<?php //var_dump($EM_Event); ?>
