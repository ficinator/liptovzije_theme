<?php
	/**
	 * Template Name: Articles Page
	 */
	$cat_photo = get_category_by_slug('photo-of-the-week');
	$paged = (get_query_var('paged')) ? absint(get_query_var('paged')) : 1;
	$args = array(
		'post_type'			=> 'post',
		'category__not_in'	=> $cat_photo->term_id,
		'paged'				=> $paged
	);
	$query = new WP_Query($args);

	get_header();
	get_sidebar();
?>

<div id="primary">
		<?php
			if ($query->have_posts()) {
				while($query->have_posts()) {
					$query->the_post();
					get_template_part('content', 'thumb');
				}
			}
			else {
				get_template_part('content', 'none');
			}
		?>
	</div><!-- .events-list -->

	<?php the_pagination($query->max_num_pages); ?>

</div><!-- #primary -->

<?php get_footer() ?>