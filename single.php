<?php
	$cat_photo = get_category_by_slug('photo-of-the-week');

	get_header();
	get_sidebar();
	if (has_category($cat_photo->cat_ID)) {
		get_the_ga_ads();
	}
	//var_dump($post);

?>

<div id="primary">
	<?php
		while (have_posts()) {
			the_post();
			if (($is_photo = has_category($cat_photo->cat_ID))) {
				get_template_part('content', 'photo');
			}
			else {
				if (get_post_type() == EM_POST_TYPE_EVENT) {
					get_template_part('content', 'event');
				// else if (has_category('photo-of-the-week')) {
				// 	get_template_part('content', 'photo');
				}
				else {
					get_template_part('content', get_post_format());
				}
			}

			// Previous/next post navigation.
			if ($is_photo) {
				the_prev_next_posts(true);
			}
			else {
				the_prev_next_posts(false, array($cat_photo->cat_ID));
			}

			// If comments are open or we have at least one comment, load up the comment template.
			if (comments_open() || get_comments_number()) {
				comments_template();
			}
		}
	?>

</div><!-- #primary -->

<?php get_footer(); ?>
