<?php
	get_header();
	get_sidebar();
?>

<div id="primary" class="search">
	<?php if (have_posts()): ?>

		<header class="page-header">
				<h2 class="page-title"><?php printf(__('Search Results for "%s"', 'liptovzije'), get_search_query()); ?></h2>
		</header><!-- .page-header -->

		<div class="container">
			<?php
				// Start the Loop.
				while (have_posts()) {
					the_post();
					get_template_part('content', 'thumb');
				}
			else:
				get_template_part('content', 'none');
			endif; ?>
		</div><!-- .container -->

</div><!-- #primary -->

<?php get_footer(); ?>
