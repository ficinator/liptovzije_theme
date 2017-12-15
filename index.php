<?php

	global $EM_event;

	get_header();
	get_sidebar();
	get_ads('left');

	// query
	$cat_photo = get_category_by_slug('photo-of-the-week');
	$paged = (get_query_var('paged')) ? absint(get_query_var('paged')) : 1;
	$args = array(
		'post_type'			=> array('event', 'post'),
		'category__not_in'	=> $cat_photo->term_id,
		'paged'				=> $paged
	);
	$query = new WP_Query($args);

?>

<div id="primary">

	<?php

		//if ($paged == 1 && $query->have_posts()) {
		//	the_slider($query);
		//}

		if ($query->have_posts()) {

			echo '<div class="entry-list' . ($paged == 1 ? ' first' : '') . '">';
			while ($query->have_posts()) {
				$query->the_post();
				if (get_post_type() == EM_POST_TYPE_EVENT) {
					get_template_part('content', 'thumb-event');
				}
				else {
					get_template_part('content', 'thumb');
				}
			}
			echo '</div>';	// .entry-list

			// Previous/next post navigation.
			if ($query->max_num_pages > 1)
				the_pagination($query->max_num_pages);
		}
		else {
			// If no content, include the "No posts found" template.
			get_template_part('content', 'none');
		}
	?>

</div><!-- #primary -->

<?php get_footer(); ?>
