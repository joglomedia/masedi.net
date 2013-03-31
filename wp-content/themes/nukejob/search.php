<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package WordPress
 * @subpackage Vacancy
 * @since Vacancy 1.0
 */

// grab the search term
$searchterm = get_search_query();
$s = ($searchterm == "Enter jobs title, company name...") ? '' : $searchterm;
$term_id = get_query_var('term');
?>
<?php get_header(); ?>
		<div id="container">
			<div id="content" role="main">
			<?php get_search_form(); ?>
			<?php if(function_exists('wpnuke_breadcrumbs')) wpnuke_breadcrumbs(); ?><!--breadcrumb-->
				<div class="post">
					<article class="post-content">
						<header>
							<h1 class="page-title"><?php printf(__('Search Result for "%s"', 'wpnuke'), $s ); ?></h1>								
							<p class="page-desc"></p>	
						</header>
						<div class="entry clearfix">
							<div class="listings-wrapper">
							<?php
							// WP Query get active jobs
							$wpn_per_page = 10;
							$wpn_paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
							$wpn_args = array(
								's' => $s,
								'post_type' => 'job',
								'post_status' => array('publish', 'expired'),
								'paged' => $wpn_paged,
								'posts_per_page' => $wpn_per_page,
								'ignore_sticky_posts' => 1
							);
							
							// If taxonomy term selected (not all job)
							if ($term_id) {
								$tax_query = array(
									//'relation' => 'OR',
									array(
										'taxonomy' => 'job_category',
										'field' => 'term_id',
										'terms' => $term_id,
										// Operator to test. Possible values are 'LIKE', 'NOT LIKE', 'IN', 'NOT IN', 'BETWEEN', 'NOT BETWEEN'.
										// We choose 'IN' because we need to make sure the term is in the current array of posts
										'operator' => 'IN',
									),
									/*
									array(
										'taxonomy' => 'job_company',
										'field' => 'slug',
										'terms' => array($wpnuke_period_ns),
										'operator' => 'IN',
									),
									array(
										'taxonomy' => 'job_tag',
										'field' => 'slug',
										'terms' => array($wpnuke_duration_ns),
										'operator' => 'IN',
									),
									*/
								);
								
								$wpn_args = array_merge($wpn_args, array('tax_query' => $tax_query));
							}
							
							$tmp_query = $wp_query;  // Assign original WP Query Post Data to temporary variable for later use
							$wp_query = null;
							$wp_query = new WP_Query();
							$wp_query->query($wpn_args);

							// singular or plural for job counter, show only in custom category
							$counter_txt = _n( 'Currently %s job', 'Currently %s jobs', $wp_query->found_posts, 'wpnuke' );
							?>
								<div class="listings-header clearfix">
									<h2 class="listings-title"><?php _e('Jobs Listing', 'wpnuke') ?></h2>
									<div class="listings-counter"><?php printf( $counter_txt, '<span class="count">'. $wp_query->found_posts . '</span>' ); ?></div>
								</div><!--listings-header-->
								<?php
								// Start WP Loop
								if ($wp_query->have_posts()) :
								?>
								<ul class="listings">
								<?php
									while ( $wp_query->have_posts() ) : $wp_query->the_post();
										// Get job meta value
										$job_location = get_post_meta( $post->ID, WPNUKE_PREFIX . 'job_location', true );
										$location = explode(',', $job_location);
										$location = array_reverse($location);
										$country = $location[0];
										$state = $location[1];
										$city = $location[2];
										
										// Get custom job company tax attribute
										$jterm = wpnuke_get_term_meta($post->ID, 'job_company', "OBJECT");
										$jstatus = wpnuke_get_jobstatus( $post->ID );
								?>
									<li>
										<a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>">
											<span>
												<img src="<?php echo wpnuke_get_jobthumb($post->ID, 'company-logo-small'); ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" height="32px" width="32px" />
												<div class="role">
													<h2><?php the_title(); ?></h2>
													<p><?php echo $jterm->name; ?>&nbsp;<span><?php echo $jterm->company_slogan; ?></span></p>
												</div>
												<div class="location"><?php echo $state; ?></div>
												<div class="meta">
													<span class="type"><?php echo wpnuke_get_jobtype( $post->ID ); ?></span>
													<span class="status<?php echo (strtolower($jstatus) == 'expired') ? ' status-expired' : ''; ?>"><?php echo $jstatus; ?></span>
												</div>
											</span>
										</a>
									</li>
									<?php endwhile; ?>
								</ul><!--listings-->
								<?php else : ?>
								<p class="error"><?php _e('Sorry, no search result matched your criteria.', 'wpnuke');?></p>
								<?php endif; ?>
								<?php if(function_exists('wpnuke_pagenavi')) : ?>
								<div class="pagination">
									<?php wpnuke_pagenavi(); ?>
								</div><!--pagination-->
								<?php endif; ?>
								<?php
									// Restore original WP Query Post Data
									$wp_query = null;
									$wp_query = $tmp_query;
									wp_reset_postdata(); // not sure needed because we're using temp query
								?>
							</div><!--listings-wrapper-->
						<div><!--entry-->
					</article><!--article-->
				</div><!--post-->
			</div><!--content-->
			<?php get_sidebar(); ?>
			<div class="clearfix"></div>
		</div><!--container-->
<?php get_footer(); ?>