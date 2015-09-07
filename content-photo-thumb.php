
<div class="photo-thumb-container">
	<article id="post-<?php the_ID(); ?>" class="photo-thumb clearfix left">

		<div class="photo-container">
			<?php the_cover_image(null, 'large') ?>

			<header class="stripe dark">
				<a href="<?php esc_url(the_permalink()); ?>" class="stripe-content">
					<h2 class="entry-title"><?php the_title(); ?></h2>
					<div class="entry-details"><?php the_excerpt(); ?></div>
				</a><!-- .stripe-content -->
				<?php the_social_share(); ?>
			</header><!-- .stripe -->

		</div><!-- .photo-container -->

	</article><!-- #post-## -->
</div><!-- .photo-thumb-container -->
