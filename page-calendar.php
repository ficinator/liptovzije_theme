<?php
	/**
	 * Template Name: Calendar Page
	 */
	get_header();
	get_sidebar();
?>

<div id="primary" class="events calendar">

	<?php
		the_events_tabs();

		if (have_posts()) {
			the_post();
			get_template_part('content', 'page');
		}
	?>

</div><!-- #primary -->

<?php get_footer() ?>