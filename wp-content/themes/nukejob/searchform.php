<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package WordPress
 * @subpackage Vacancy
 * @since Vacancy 1.0
 */

// grab the search term
$searchterm = get_query_var('s');
$s = (! empty($searchterm)) ? $searchterm  : 'Enter jobs title, company name...';
$term_id = get_query_var('term');
?>
			<div class="searchbox">
					<form id="searchform" method="get" action="<?php bloginfo('url'); ?>">
						<h3><?php _e('Search Jobs', 'wpnuke'); ?></h3>
						<input name="s" value="<?php echo $s; ?>" onblur="if (this.value == '') {this.value = 'Enter jobs title, company name...'; }" onfocus="if (this.value == 'Enter jobs title, company name...') {this.value = ''; }" type="text" />
						<?php
							// List drop down taxonomy
							$args = array(
								'show_option_all'    => 'All Job Categories',
								'show_option_none'   => '',
								'orderby'            => 'name', 
								'order'              => 'ASC',
								'show_count'         => false,
								'hide_empty'         => false, 
								'child_of'           => 0,
								'exclude'            => '',
								'echo'               => true,
								'selected'           => $term_id,
								'hierarchical'       => true, 
								'name'               => 'term',
								'id'                 => 'term',
								'class'              => 'postform',
								'depth'              => 3,
								'tab_index'          => 0,
								'taxonomy'           => 'job_category',
								'hide_if_empty'      => false
							);
							wp_dropdown_categories($args);
							//wpnuke_dropdown_categories($args);
						?>
						<input class="button" value="Search" type="submit" />
					</form>
				</div><!--searchbox-->