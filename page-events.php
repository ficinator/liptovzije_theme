<?php
	/**
	 * Template Name: Events Page
	 */
	$paged = (get_query_var('paged')) ? absint(get_query_var('paged')) : 1;
	$args = array(
		'post_type'	=> 'event',
		'paged'		=> $paged,
		'order'		=> 'ASC',
		'orderby'	=> '_start_ts'
	);
	$date = strtotime(get_query_var('calendar_day'));
	if ($date) {
		$args['meta_query']	= array('relation'	=> 'and',
			array(
				'key' => '_start_ts',
				'value' => $date + 86400,
				'compare' => '<='),
			array(
				'key' => '_end_ts',
				'value' => $date,
				'compare' => '>='));
	}
	else {
		$args['meta_query']	= array('relation'	=> 'or',
			array(
				'key' => '_start_ts',
				'value' => current_time('timestamp'),
				'compare' => '>='),
			array(
				'key' => '_end_ts',
				'value' => current_time('timestamp'),
				'compare' => '>='));
	}
	$query = new WP_Query($args);

	get_header();
	get_sidebar();
?>

<div id="primary" class="events future">

	<?php
		if ($date) {
			echo '<h2 class="page-title">' . sprintf(__('All Events on %s', 'liptovzije'), date('j. n. Y', $date)) . '</h2>';
		}
		else {
			the_events_tabs();
		}
	?>

	<div class="event-list">
		<?php
			if ($query->have_posts()) {
				while($query->have_posts()) {
					$query->the_post();
					get_template_part('content', 'thumb-event');
				}
			}
			else {
				echo '<div class="no-events">' . __('No Events', 'liptovzije') . '</div>';
			}
		?>
	</div><!-- .events-list -->

	<?php the_pagination($query->max_num_pages); ?>

</div><!-- #primary -->

<?php get_footer() ?>