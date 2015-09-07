<?php
	get_header();
	get_sidebar();
?>

<div id="primary">

	<?php

	while (have_posts()) {
		the_post();
		get_template_part('content', 'page');

		// If comments are open or we have at least one comment, load up the comment template.
		if (comments_open() || get_comments_number())
			comments_template();
	}

	?>

</div><!-- #primary -->

<?php get_footer(); ?>
