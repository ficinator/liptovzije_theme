<?php
	/**
	 * Template Name: Cinema
	 */
	get_header();
	get_sidebar();
	// get_the_ga_ads();
?>

<div id="primary" class="cinema">
	<h2 class="page-title"><?php _e('Golden Apple Cinema Weekly Schedule', 'liptovzije') ?></h2>
	<section id="schedule">

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
			// echo $date . ' - ' . key($dates) . '<br />';
			echo '<div id="day-' . $i . '" class="day-schedule">';
			if (array_key_exists($date, $dates)) {
				$hours = $dates[$date];
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
					echo '<tr><th><a href="#' . urlencode($movie) . '">' . $movie . '</a></th>';
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

	<section id="info">
		<?php the_content(); ?>
	</section><!-- #info -->

	<h2 class="page-title"><?php _e('Movie List', 'liptovzije') ?></h2>
	<section id="movie-list">
	<?php get_the_ga_ads(); ?>
	<?php
		$day_names = array('Mon',
											 'Tue',
											 'Wed',
											 'Thu',
											 'Fri',
											 'Sat',
											 'Sun');
		$movies = parse_ga_movies();


		echo '<ul>';
		foreach ($movies as $title => $details) {
			echo '<li id="' . urlencode($title) . '">';
			echo '<h3>' . movie_title($title) . '</h3>';
			echo '<div class="movie-schedule"><table><thead><tr>';
			foreach ($day_names as $day_name) {
				echo '<th>' . __($day_name) . '</th>';
			}
			echo '</tr></thead><tbody>';
			$i = 0;
			while (++$i) {
				$date = key($details['dates']);
				if ($i == 1) {
					echo '<tr>';
				}
				echo '<td>';
				if ($date && $i == date('N', $date)) {
					echo '<div class="date">' . date('j. n.', $date) . '</div>';
					// echo $date . ' ' . $i . ' ' . date('N', $date) . ' ' . date('j. n.', $date);
					$day_details = current($details['dates']);
					echo '<ul class="times">';
				 	foreach ($day_details['times'] as $time => $time_details) {
				 		echo  '<li>' . $time . '</li>';
				 	}
				 	echo '</ul>';
					$day_details = next($details['dates']);
				}
				echo '</td>';
				if ($i == 7) {
					echo '</tr>';
					$i = $day_details ? 0 : -1;
				}
			}
			echo '</tbody></table></div>';	// .movie-schedule
			echo '</li>';
		}
		echo '</ul>';

		// var_dump($movies);
	?>

	</section><!-- #movie-list -->

</div><!-- #primary -->

<?php get_footer() ?>