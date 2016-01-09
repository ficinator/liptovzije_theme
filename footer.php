			</div><!-- .main -->
		</div><!-- #page -->

		<footer id="footer" class="clearfix">
			<div class="content-container">
				<?php
					the_partners();
					the_social();
					the_copyright();
					the_contact();
					dynamic_sidebar('footer');
				?>
			</div><!-- .content-container -->
			<a href="<?php echo admin_url(); ?>" class="admin"><?php _e('Admin'); ?></a>
		</footer>

		<?php wp_footer(); ?>
		
	</body>
</html>