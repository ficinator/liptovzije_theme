<?php
	if (is_active_sidebar('sidebar')):
?>

	<div id="sidebar" class="clearfix">

		<div id="primary-sidebar">

			<?php
				if (!has_category('photo-of-the-week') || is_home())
					the_photo_of_the_week();
				radioL();
				dynamic_sidebar('sidebar');
			?>

			<aside class="widget facebook">
				<h3 class="widget-title"><?php _e('Find us on Facebook', 'liptovzije'); ?></h3>
				<div class="fb-like-container">
					<div class="fb-like"
						data-href="https://www.facebook.com/liptovzije"
						data-layout="standard"
						data-action="like"
						data-show-faces="true"
						data-share="true"
						data-width="260">
					</div>
				</div><!-- .fb-like-container -->
			</aside>

		</div><!-- #primary-sidebar -->

		<!-- <div id="footer-sidebar"> -->
		<!-- </div> --><!-- @footer-sidebar -->

	</div><!-- #sidebar -->
	
<?php endif; ?>
