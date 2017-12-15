<?php
	get_header();
	get_sidebar();
	get_ads('left');
?>

<div id="primary" class="archive">
	<?php if (have_posts()): ?>

		<header class="page-header">
			<h2 class="page-title"><?php single_cat_title('', true); ?></h2>
			<div class="page-description"><?php the_archive_description(); ?></div>
		</header><!-- .page-header -->

		<div class="entry-list">
			<?php
				// Start the Loop.
				while (have_posts()) {
					the_post();
					if (has_category('photo-of-the-week')) {
						get_template_part('content', 'thumb-photo');
					}
					else {
						if (get_post_type() == EM_POST_TYPE_EVENT) {
							get_template_part('content', 'thumb-event');
						}
						else {
							get_template_part('content', 'thumb');
						}
					}
				}
			else:
				get_template_part('content', 'none');
			endif; ?>
		</div><!-- .ectry-list -->

</div><!-- #primary -->

<?php get_footer(); ?>
