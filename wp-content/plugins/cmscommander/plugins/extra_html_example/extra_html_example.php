<?php
if(basename($_SERVER['SCRIPT_FILENAME']) == "extra_html_example.php"):
    exit;
endif;
// add filter for the stats structure
add_filter('cmsc_stats_filter', cmsc_extra_html_example);

function cmsc_extra_html_example($stats)
 {
        $count_posts = wp_count_posts();
     
        $published_posts = $count_posts->publish;
        
        // add 'extra_html' element. This is what gets displayed in the dashboard
 	$stats['extra_html'] = '<p>Hello from '.get_bloginfo('name').' with '.$published_posts.' published posts.</p>';
 	
 	// return the whole array back
 	return $stats;
 }
?>