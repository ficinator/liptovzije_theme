<?php
	/**
	 * Template Name: Past Events Page
	 */
	$paged = (get_query_var('paged')) ? absint(get_query_var('paged')) : 1;
	$args = array(
		'post_type'		=> 'event',
		'paged'			=> $paged,
		'orderby'		=> '_start_ts',
		'order'			=> 'DESC',
		'meta_query'	=> array('relation'	=> 'and',
			array(
				'key' => '_start_ts',
				'value' => current_time('timestamp'),
				'compare' => '<'),
			array(
				'key' => '_end_ts',
				'value' => current_time('timestamp'),
				'compare' => '<')));
	$query = new WP_Query($args);

	get_header();
	get_sidebar();
?>

<div id="primary" class="events past">

	<?php the_events_tabs() ?>

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