<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
	<label class="visuallyhidden" for="s"><?php _e('Search for:', 'liptovzije'); ?></label>
	<div class="searchbox-container">
		<input type="text" value="<?php echo get_search_query(); ?>" name="s" placeholder="<?php _e('Search', 'liptovzije'); ?>" />
	</div>
	<button class="erase-search">
		<span class="visuallyhidden"><?php _e('Erase Search', 'liptovzije'); ?></span>
	</button>
	<div class="submit-container">
		<input type="submit" id="search-submit" value="<?php _e('Search', 'liptovzije'); ?>" />
	</div>
</form>