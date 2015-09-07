<?php
	$events = EM_Events::get(array(
		'post_id'	=> get_the_ID(),
		'scope'		=> 'all'
	));
	foreach ($events as $EM_Event):
		//var_dump($EM_Event);
		//echo current_time('timestamp') . ' - ' . $EM_Event->end . '<br/>';
?>

<div class="thumb-container">
	<article id="post-<?php the_ID(); ?>" class="event-thumb clearfix left">

		<div class="cover-image-container">
			<?php the_cover_image(null, 'large', true, $EM_Event->start) ?>
		</div><!-- .post-cover-image -->

		<div class="post-details">
			<header class="entry-header">
				<h2 class="entry-title"><a href="<?php esc_url(the_permalink()); ?>"><?php the_title(); ?></a></h2>
			</header><!-- .entry-header -->

			<section class="excerpt">
				<?php echo get_my_excerpt() ?>
			</section>

			<footer class="entry-meta">
				<span class="date-created">Pridané <?php echo date('j. n. Y', strtotime($EM_Event->post_date)); ?></span>
				<?php
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

<?php endforeach; ?>
