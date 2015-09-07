<?php
	/**
	 * Template Name: Cinema
	 */
	get_header();
	get_sidebar();
	get_the_ga_ads();
?>

<div id="primary" class="cinema">
	<h2 class="page-title"><?php _e('Golden Apple Cinema Weekly Schedule', 'liptovzije') ?></h2>
	<section id="schedule">
		<p>
			<?php _e('For reservations and more information, visit ', 'liptovzije') ?>
			<a href="http://gacinema.sk/" target="_blank">gacinema.sk</a>.
		</p>
	<?php
		$dates = parse_ga_schedule();

		echo '<ul class="day-tabs">';
		for ($i = 0; $i < 7; $i++) {
		//foreach ($dates as $date => $hours) {
			$date = time() + $i * 86400;
			echo '<li><a href="#day-' . $i . '">';
			echo '<div class="day-name">' . __(date('l', $date)) . '</div>';
			echo '<div class="event-date">';
			echo '<div class="day">' . date('j', $date) . '</div>';
			echo '<div class="month">' . date('M', $date) . '</div>';
			echo '</div>';
			echo '</a></li>';
			next($dates);
		}
		echo '</ul>';	// .day-tabs

		reset($dates);
		for ($i = 0; $i < 7; $i++) {
		//foreach ($dates as $date => $hours) {
			$date = date('d.m.Y', time() + $i * 86400);
			$hours = $dates[$date];
			// echo $date . ' - ' . key($dates) . '<br />';
			echo '<div id="day-' . $i . '" class="day-schedule">';
			if ($hours) {
				ksort($hours);
				$movies = array();
				echo '<table><thead><tr>';
				echo '<th>' . __('Movie', 'liptovzije') . '</th>';
				foreach ($hours as $hour => $movies_in_hour) {
					echo '<th>' . $hour . '</th>';
					foreach ($movies_in_hour as $movie => $details) {
						if (!in_array($movie, $movies)) {
							array_push($movies, $movie);
						}
					}
				}
				echo '</tr></thead><tbody>';
				sort($movies);
				foreach ($movies as $movie) {
					echo '<tr><th>' . $movie . '</th>';
						foreach ($hours as $hour => $movies_in_hour) {
							if (array_key_exists($movie, $movies_in_hour)) {
								$details = $movies_in_hour[$movie];
								echo '<td>' . $details['time'] . '</td>';
							}
							else {
								echo '<td></td>';
							}
						}
					echo '</tr>';
				}
				echo '</tbody></table>';
			}
			else {
				if (!isset($thu)) {
					$thu = strtotime($date);
					$wed = $thu + 7 * 84600;
					$mon = $thu - 3 * 84600;
				}
				echo '<div class="no-schedule">' . sprintf(__('New schedule from Thursday %s to Wednesday %s will be available on Monday %s', 'liptovzije'), date('j. n.', $thu), date('j. n.', $wed), date('j. n.', $mon)) . '</div>';
			}
			echo '</div>';	// #day-#
		}
	?>
	
	</section><!-- #schedule -->

	<?php
		//$movies = parse_ga_movies();

		// echo '<ul>';
		// foreach ($movies as $title => $details) {
		// 	echo '<li>';
		// 	echo '<h3>' . $title . '</h3>';
		// 	echo '<div class="movie-schedule"><table><thead><tr>';
		// 	foreach ($details['dates'] as $date => $times) {
		// 		echo '<th>' . $date . '</th>';
		// 	}
		// 	echo '</tr></thead><tbody>';
		// 	// foreach ($movies as $title => $details) {
		// 	// 	if (!array_key_exists($date, $details['dates']))
		// 	// 		continue;
		// 	// 	echo '<tr><th>' . $title . '</th>';
		// 	// 	foreach ($hours as $hour => $movies_in_hour) {
		// 	// 		if (array_key_exists($title, $movies_in_hour)) {
		// 	// 			$movie = $movies_in_hour[$title];
		// 	// 			echo '<td>' . $movie['time'] . '</td>';
		// 	// 		}
		// 	// 		else {
		// 	// 			echo '<td></td>';
		// 	// 		}
		// 	// 	}
		// 	// 	echo '</tr>';
		// 	// }
		// 	echo '</tbody></table></div>';	// .movie-schedule
		// 	echo '</li>';
		// }
		// echo '</ul>';
	?>

</div><!-- #primary -->

<?php get_footer() ?>