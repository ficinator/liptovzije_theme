<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">

<!-- 		<?php if (has_post_thumbnail()): ?>
			<div class="cover-image-container">
				<?php the_cover_image(null, 'large', false) ?>
			</div>
		<?php endif; ?> -->
		<div class="entry-meta">
			<div class="entry-details">
				<?php edit_post_link(__( 'Edit'), '<span class="edit-link">', '</span>'); ?>				
			</div><!-- .entry-details -->
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content">
    <?php 
        // $sql = "SELECT * FROM `wp_geo_mashup_location_relationships` WHERE object_id = {$post->ID}";
        // $tmp = mysql_fetch_array(mysql_query($sql));
        // if ($tmp) {
        //     $sqlLoc = "SELECT * FROM `wp_geo_mashup_locations` where id = {$tmp['location_id']}";
        //     $location = mysql_fetch_array(mysql_query($sqlLoc));
        //     if ($location) {
        //         $lat = $location['lat'];
        //         $lng = $location['lng'];
        //         $loc[0][0] = $lat;
        //         $loc[0][1] = $lng;
        //         $name = get_the_title();
        //         echo gMap($loc, $name);
        //         echo "<div id=\"map-canvas\"></div>";
        //     }
        // }
        
		the_content();
	?>
	</div><!-- .entry-content -->

	<!-- <div class="entry-footer"> -->

	<?php

		// if (has_category()) {
		// 	echo '<div class="cat-links">' . __('Categories') . ': ';
		// 	the_category(', ');
		// 	echo '</div>';
		// }
		// if (has_tag()) {
		// 	the_tags('<div class="tag-links">' . __('Tags') . ': ', ', ', '</div>');
		// }
	?>

	<!-- </div> --><!-- .entry-footer -->

</article>
