<?php
/*
Template Name: Archives
*/
?>
<?php get_header(); ?>

<div id="container">
	<div id="main">
    <div class="title_page">
			<h2>Archives Page</h2>
    </div> <!-- end title -->
    
    <div class="archivespage_tag">
			<?php wp_tag_cloud('smallest=12&largest=22&unit=px&number=100&order=RAND'); ?>
    </div>
		
		<?php
		// This code is brought to you by the author of blog.2i2j.com. With great thanks!
		// http://blog.2i2j.com/2007/11/add-archives-page-to-blog-with-wordpress.html
		// echo archives start
			$lastpost = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_date <'" . current_time('mysql') . "' AND post_status='publish' AND post_type='post' AND post_password='' ORDER BY post_date DESC LIMIT 1");
			$output = get_option('hfy_archives_'.$lastpost);
			if(empty($output)){
			$output = '';
			$wpdb->query("DELETE FROM $wpdb->options WHERE option_name LIKE 'hfy_archives_%'");
			// Get all of the months that have posts
			$monthquery = "SELECT DISTINCT YEAR(post_date) AS year, MONTH(post_date) AS month, count(ID) as posts FROM " . $wpdb->posts . " WHERE post_date <'" . current_time('mysql') . "' AND post_status='publish' AND post_type='post' AND post_password='' GROUP BY YEAR(post_date), MONTH(post_date) ORDER BY post_date DESC";
			$monthresults = $wpdb->get_results($monthquery);

			if ($monthresults) {
				// Loop through each month
				foreach ($monthresults as $monthresult) {
					$thismonth	= zeroise($monthresult->month, 2);
					$thisyear	= $monthresult->year;

			// Get all of the posts for the current month
			$postquery = "SELECT ID, post_date, post_title, comment_count FROM " . $wpdb->posts . " WHERE post_date LIKE '$thisyear-$thismonth-%' AND post_date AND post_status='publish' AND post_type='post' AND post_password='' ORDER BY post_date DESC";
			$postresults = $wpdb->get_results($postquery);
			
			if ($postresults) {
				// The month year title things
				$text = sprintf('%s %d', $month[zeroise($monthresult->month,2)], $monthresult->year);
				$postcount = count($postresults);
				$output .= '<p>' . $text . '&nbsp;(&nbsp;<span class="archivesnumber">' . count($postresults) . '</span>&nbsp;Entries&nbsp;)</p>';
				$output .= "<ul class='archiveslist'>\n";
				
				foreach ($postresults as $postresult) {
					if ($postresult->post_date != '0000-00-00 00:00:00') {
						$url = get_permalink($postresult->ID);
						$arc_title	= $postresult->post_title;
						if ($arc_title)
							$text = wptexturize(strip_tags($arc_title));
						else
							$text = $postresult->ID;
						$title_text = 'Read full post &quot;' . wp_specialchars($text, 1) . '&quot;';
						$output .= '	<li>' . mysql2date('m-d', $postresult->post_date) . ':&nbsp;' . "<a href='$url' title='$title_text'>$text</a>";
						$output .= '&nbsp;(' . $postresult->comment_count . ')';
						$output .= "</li>\n";
					}
				}
				$output .= "</ul>\n\n";
			}
		}
		update_option('hfy_archives_'.$lastpost,$output);
	}else{
		$output = '<strong>'. __('ERROR:') .'</strong> '. __('No items were found to be displayed.') .'';
	}
	
}
			echo $output;
			//echo archives end
		?>
	</div><!-- end main -->
<?php get_sidebar(); ?>
</div><!-- end container -->
<?php get_footer(); ?>