<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<div class="stripe">
			<div class="stripe-content">
				<?php the_title('<h2 class="entry-title">', '</h2>'); ?>
				<div class="entry-details">
					<span class="date">Pridané <?php the_date() ?></span>
					<?php edit_post_link(__('Edit'), '<span class="edit-link">', '</span>'); ?>
				</div><!-- .entry-details -->
			</div><!-- .stripe-content -->
			<?php the_social_share(); ?>
		</div><!-- .stripe -->
	</header><!-- .entry-header -->

	<div class="entry-content">
    	<?php the_content(); ?>
	</div><!-- .entry-content -->

	<div class="entry-footer">
		<?php
			if (has_category()) {
				echo '<div class="cat-links">';
				echo '<h3 class="title">' . __('Categories') . '</h3>';
				the_category(', ');
				echo '</div>';
			}
			if (has_tag()) {
				the_tags('<div class="tag-links"><h3 class="title">' . __('Tags') . '</h3>', ', ', '</div>');
			}
		?>
	</div><!-- .entry-footer -->

</article>
