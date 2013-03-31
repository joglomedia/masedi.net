<?php
/**
 * Custom Post Type ftjob (Events) loop template
 * IMPORTANT NOTE: WORDPRESS 3.1 READY. USES:
 * - meta_query (instead of meta_key/value/compare)
 * - tax_query (instead of Multiple Taxonomy Query plugin)
 *
 */

/* 
******************************************************************
					// !FUNCTION RELIST TAXONOMY AS OPTION LIST
******************************************************************
*/ 
// List taxonomy terms as an option list and recall options chosen if applicable
function wpnuke_terms_as_option_list($taxonomy, $args = array()) {
	// set default args
	
	$defaults = array(
		'orderby'		=> 'name', 
		'order'			=> 'ASC',
		'hide_empty'	=> false,
		'hide_if_empty'	=> false,
		'exclude'		=> array(), 
		'exclude_tree'	=> array(), 
		'include'		=> array(),
		'number'		=> '', 
		'fields'		=> 'all', 
		'slug'			=> '', 
		'parent'		=> '',
		'echo'			=> true,
		'selected'		=> '',
		'hierarchical'	=> true, 
		'name'			=> 'cat',
		'id'			=> '',
		'class'			=> 'postform',
		'child_of'		=> 0, 
		'get'			=> '', 
		'name__like'	=> '',
		'pad_counts'	=> false, 
		'offset'		=> '', 
		'search'		=> '', 
		'cache_domain'	=> 'core'
	); 
	$args = wp_parse_args( $args, $defaults );
	
	extract( $args, EXTR_SKIP );
	
	// list terms in taxonomy term
	$tax_terms = get_terms($taxonomy, $args);
	
	$html = '<select name="' . $name . '" id="' . $name . '" class="' . $class . '">';
	// if $tax_selected is true, recall selected options
	foreach ($tax_terms as $tax_term) {
	    $html .= '<option';
		$html .= ' class="' . $tax_term->parent . '"';
	    // Check if option chosen is the current <option> being created
	    if ($selected == $tax_term->name) {
			$html .= ' selected="yes"';
		}
		$html .= ' value="' . $tax_term->term_id . '"';
	    $html .= '>' . $tax_term->name;
		$html .= '</option>';
	}
	$html .= '</select>';
	
	if ($echo)
		echo $html;
	else
		return $html;
}

// Function to echo out date range for Event Custom Post types - Needs CF start
// and end dates passed to it and relies on osu_date_format() function.
function wpnuke_showdates($wpnuke_start_date, $wpnuke_end_date) {
	
	// Reverse the StartEventDate and EndEventDate Custom fields so they display in correct order (dd/mm/yyyy not yyyy/mm/dd)
	$wpnuke_start_date_rev = osu_date_format($wpnuke_start_date);
	$wpnuke_end_date_rev = osu_date_format($wpnuke_end_date);
	
	// No need to display reversed EndEventDate date if job happens on one day only
	if($wpnuke_end_date !== $wpnuke_start_date || $wpnuke_end_date == '') {
	    $wpnuke_end_date_rev = ' - ' . $wpnuke_end_date_rev;
	}
	
	// If no start date at all, display error message
	if(!$wpnuke_start_date) {
	    echo '<span>Event date not available!</span>';
	} else {
	    echo $wpnuke_start_date_rev . $wpnuke_end_date_rev;
	}
}

// Function to convert spaces to hyphens (turn string into slug)
function wpnuke_convert_spaces($convert) {
	$converted = preg_replace("/\s/", "-", strtolower($convert));
	return $converted;
}

// Get post data from filter
if(isset($_POST["fttype"])) {
	$wpnuke_type = $_POST['fttype'];
} else {
	$wpnuke_type = '';
}
if(isset($_POST["ftperiod"])) {
	$wpnuke_period = $_POST['ftperiod'];
} else {
	$wpnuke_period = '';
}
if(isset($_POST["ftduration"])) {
	$wpnuke_duration = $_POST['ftduration'];
} else {
	$wpnuke_duration = '';
}

// If 'All' chosen in options, make option blank so all taxonomy terms returned
if($wpnuke_type == 'All') { $wpnuke_type = ''; }
if($wpnuke_period == 'All') { $wpnuke_period = ''; }
if($wpnuke_duration == 'All') { $wpnuke_duration = ''; }

/* 
******************************************************************
					// !SET THE QUERY
******************************************************************
*/ 

// QUESTION: Paged results - for some reason pagination doesn't appear
// on the results page when the filter form is submitted??
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

// Because pagination isn't working once the form is submitted, we'll show all posts (uses hidden input)
if($_POST['showall']) {
	$jobs_per_page = 100;
} else {
	$jobs_per_page = 3;
}

// Set todays date to check against the custom field StartEventDate
$todays_date = date('Y/m/d');

// Convert spaces in taxonomies and terms into hyphens so that search works correctly (uses slug)
$wpnuke_type_ns = wpnuke_convert_spaces($wpnuke_type);
$wpnuke_period_ns = wpnuke_convert_spaces($wpnuke_period);
$wpnuke_duration_ns = wpnuke_convert_spaces($wpnuke_duration);

// Build query - WP 3.1 only!
// READ MORE ON 'MULTIPLE TAXONOMY HANDLING' HERE:
// http://codex.wordpress.org/Function_Reference/query_posts#Taxonomy_Parameters
$wpnuke_args = array(
	'post_type' => 'jobs',
	'posts_per_page' => $jobs_per_page,
	'paged' => $paged,
	// 'meta_key' is needed to 'orderby' posts by Custom Field StartEventDate
	'meta_key' => 'StartJobsDate',
	'orderby' => 'meta_value',
	'order' => 'ASC',
	// Use meta_query to filter results
	'meta_query' => array(
		array(
			'key' => 'StartJobsDate',
			'value' => $todays_date,
			// Custom field type. Possible values are 'NUMERIC', 'BINARY', 'CHAR', 'DATE', 'DATETIME', 'DECIMAL', 
			// 'SIGNED', 'TIME', 'UNSIGNED'. Default value is 'CHAR'.
			'type' => 'DATE',
			// Operator to test. Possible values are 'LIKE', 'NOT LIKE', 'IN', 'NOT IN', 'BETWEEN', 'NOT BETWEEN'.
			// We choose 'BETWEEN' because we need to know the date has not passed to show the job
			'compare' => '>='
		)
	),
	'tax_query' => array(
		'relation' => 'AND',
		array(
			'taxonomy' => 'fttype',
			'field' => 'slug',
			'terms' => array($wpnuke_type_ns),
			// Operator to test. Possible values are 'LIKE', 'NOT LIKE', 'IN', 'NOT IN', 'BETWEEN', 'NOT BETWEEN'.
			// We choose 'IN' because we need to make sure the term is in the current array of posts
			'operator' => 'LIKE',
		),
		array(
			'taxonomy' => 'ftperiod',
			'field' => 'slug',
			'terms' => array($wpnuke_period_ns),
			'operator' => 'LIKE',
		),
		array(
			'taxonomy' => 'ftduration',
			'field' => 'slug',
			'terms' => array($wpnuke_duration_ns),
			'operator' => 'LIKE',
		),
	)
);

// Create query
//query_posts($wpnuke_args);
?>

<?php 
/* 
******************************************************************
						// !FILTER FORM
******************************************************************
*/ 

// Recall options in form dropdown
$selected_type = $_POST['wpnuke_type'];
$selected_period = $_POST['wpnuke_period'];
$selected_duration = $_POST['wpnuke_duration'];
?>

<?php 
	// Check values in array
	print '<p><pre>';
	print_r( $jb_args );
	print '</pre></p>';
?>

<form action="" method="post" id="jb_filter">
	<fieldset>
		<legend>Filter</legend>
		<ul>
			<li>
				<label>Type</label>
				<select name="wpnuke_type" id="wpnuke_type-select">
					<?php wpnuke_terms_as_option_list('wpnuke_type', $selected_type); ?>
				</select>
			</li>
			<li>
				<label>Period</label>
				<select name="wpnuke_period" id="wpnuke_period-select">
					<option value="all">All</option>
					<?php wpnuke_terms_as_option_list('wpnuke_period', $selected_period); ?>
				</select>
			</li>
			<li>
				<label>Duration</label>
				<select name="wpnuke_duration" id="wpnuke_duration-select">
					<option value="all">All</option>
					<?php wpnuke_terms_as_option_list('wpnuke_duration', $selected_duration); ?>
				</select>
			</li>
			<li class="end">
				<input type="hidden" id="showall" name="showall" value="true" />
				<input type="submit" id="filtersubmit" value="Submit" />
			</li>
		</ul>
	</fieldset>
</form>

<?php 
/* 
******************************************************************
						// !LOOP STARTS
******************************************************************
*/ 
?>

<?php if ( $wpnuke_search->have_posts() ) : ?>

	<?php while ( $wpnuke_search->have_posts() ) : $wpnuke_search->the_post(); ?>

		<div class="job-thumbnail">
			<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'twentyten-child' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php
    			if ( function_exists("has_post_thumbnail") && has_post_thumbnail() ) {
    				the_post_thumbnail('thumbnail');
    			} else { ?>
    				<img src="<?php echo bloginfo('stylesheet_directory'); ?>/images/thumb-default.jpg" alt="thumb-default" width="65" height="65" />
    			<?php } ?>
    		</a>
    	</div> <!-- End div.job-thumbnail -->
    	<div class="taxonomy-terms">
    		<span class="job-tax">Type :</span><?php wpnuke_terms_as_option_list_text('wpnuke_type'); ?>
    		<span class="job-tax">Period :</span><?php wpnuke_terms_as_option_list_text('wpnuke_period'); ?>
    		<span class="job-tax">Duration :</span><?php wpnuke_terms_as_option_list_text('wpnuke_duration'); ?>
    	</div> <!-- End div.taxonomy-terms -->

		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'twentyten-child' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>			
			<p class="job-date"><?php
				// Get dates of job
				$wpnuke_start_date = get_post_meta($post->ID, 'StartJobsDate', true);
				$wpnuke_end_date = get_post_meta($post->ID, 'EndJobsDate', true);
				
				// Display date range in correct order (function reverses date order)
				wpnuke_showdates($wpnuke_start_date, $wpnuke_end_date);
				?>
			</p>
			
			<?php the_excerpt(); ?>

			<div class="entry-utility">
				<span class="comments-link">
					<?php // Hide comments pop up if none available
						if ( comments_open() ) {
							comments_popup_link( __( 'Leave a comment', 'twentyten-child' ), __( '1 Comment', 'twentyten-child' ), __( '% Comments', 'twentyten-child' ) );
						}
					?></span>
				<?php edit_post_link( __( 'Edit', 'twentyten-child' ), '<span class="edit-link">', '</span>' ); ?>
			</div><!-- .entry-utility -->
		</div><!-- #post-## -->

		<?php comments_template( '', true ); ?>
		
	<?php endwhile;  ?>

<?php endif; /* Otherwise, no posts available */ ?>

<?php
/* 
******************************************************************
						// !IF NO POSTS
******************************************************************
*/ 

/* If there are no posts to display, such as an empty archive page */
if ( ! have_posts() ) : ?>
	<div id="post-0" class="post error404 not-found">
		<h1 class="entry-title"><?php _e( 'No listings found', 'twentyten-child' ); ?></h1>
		<div class="entry-content">
			<p><?php _e( 'Apologies, but no tours or jobs were found using those filter options. Please try again.', 'twentyten-child' ); ?></p>
		</div><!-- .entry-content -->
	</div><!-- #post-0 -->
<?php endif; ?>

<?php
/* 
******************************************************************
					// !NAVIGATION LINKS
******************************************************************
*/ 
?>

<?php /* Display navigation to next/previous pages when applicable - NOTE, NAV SWITCHED AROUND AS WANT FUTURE POSTS LINKS TO APPEAR TO THE RIGHT, NOT THE LEFT (MAKES MORE SENSE VISUALLY) */ ?>
<?php if ( $wp_query->max_num_pages > 1 ) : ?>
	<div id="nav-below" class="navigation">
		<div class="nav-previous"><?php next_posts_link( __( 'Future jobs <span class="meta-nav">&gt;</span>', 'twentyten-child' ) ); ?></div>
		<div class="nav-next"><?php previous_posts_link( __( '<span class="meta-nav">&lt;</span> Earlier jobs', 'twentyten-child' ) ); ?></div>
	</div><!-- #nav-above -->
<?php endif; ?>

<?php
// Reset Query
//wp_reset_query();

/* Restore original Post Data 
 * NB: Because we are using new WP_Query we aren't stomping on the 
 * original $wp_query and it does not need to be reset.
*/
wp_reset_postdata();
?>