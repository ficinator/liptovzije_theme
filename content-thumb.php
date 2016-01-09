
<div class="thumb-container">
	<article id="post-<?php the_ID(); ?>" class="post-thumb clearfix left">

		<?php if (has_post_thumbnail()): ?>

		<div class="cover-image-container">
			<?php the_cover_image(null, 'large') ?>
		</div>

		<?php endif; ?>

		<div class="post-details">
			<header class="entry-header">
				<h2 class="entry-title"><a href="<?php esc_url(the_permalink()); ?>"><?php the_title(); ?></a></h2>
			</header><!-- .entry-header -->

			<section class="excerpt">
				<?php echo get_my_excerpt(); ?>
			</section>

			<footer class="entry-meta">
				<?php
					the_date('j. n. Y', '<span class="date-created">Pridané ', '</span>');
					edit_post_link(__('Edit'), '<span class="edit-link">', '</span>');
					// if (comments_open()) {
					// 	echo '<span class="comments-link">';
					// 	comments_popup_link(__('Leave a comment'), __('1 Comment'), __('% Comments'));
					// 	echo '</span>';	// .comments-link
					// }
				?>
			</footer><!-- .entry-meta -->
		</div><!-- .post-details -->
	</article><!-- #post-## -->
</div><!-- .thumb-container -->
