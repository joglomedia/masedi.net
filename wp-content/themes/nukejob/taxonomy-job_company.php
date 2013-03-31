<?php
/**
 * Taxonomy Job Company
 *
 * @package WPNuke
 * @subpackage Vacancy
 * @since Vacancy 1.0
 */
?>
<?php get_header(); ?>
		<div id="container">
			<div id="content" role="main">
				<?php get_search_form(); ?>
				<div class="post">
					<article class="post-content">
						<?php if(function_exists('wpnuke_breadcrumbs')) wpnuke_breadcrumbs(); ?><!--breadcrumb-->
						<?php
						// grab the taxonomy job company info
						$taxonomy = get_query_var('taxonomy');
						$term = get_term_by('slug', get_query_var('term'), $taxonomy);				
						?>
						<?php if(function_exists('wpnuke_breadcrumb')) wpnuke_breadcrumb(); ?><!--breadcrumb-->
						<header>
							<h1 class="page-title"><?php printf(__('Jobs Listing by "%s"', 'wpnuke'), $term->name ); ?></h1>								
							<p class="page-desc"><?php echo $term->description; ?></p>	
						</header>
						<div class="entry clearfix">
							<div class="listings-wrapper">
							<?php
							// WP Query get active jobs
							$wpn_per_page = 10;
							$wpn_paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
							$wpn_args = array(
								'post_type' => 'job',
								$taxonomy => $term->name,
								'post_status' => array('publish', 'expired'),
								'not_expired_post' => true,
								'paged' => $wpn_paged,
								'posts_per_page' => $wpn_per_page,
								'ignore_sticky_posts' => 1,
								'tax_query' => array(
									'taxonomy' => $taxonomy,
									'field' => $term->term_id,
									'terms' => $term->slug
								)
							);
							
							$tmp_query = $wp_query;  // Assign original WP Query Post Data to temporary variable for later use
							$wp_query = null;
							$wp_query = new WP_Query();
							$wp_query->query($wpn_args);

							// singular or plural for job counter, show only in custom category
							$counter_txt = _n( 'Currently %s active job', 'Currently %s active jobs', $wp_query->found_posts, 'wpnuke' );
							?>
								<div class="listings-header clearfix">
									<h2 class="listings-title"><?php _e('Active Jobs', 'wpnuke') ?></h2>
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
								<p class="error"><?php _e('Sorry, no active jobs matched your criteria.', 'wpnuke');?></p>
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
							</div><!--listings-wrapper-active-job-->
							<!-- # -->
							<div class="listings-wrapper">
							<?php
							// Get expired jobs
							$wpn_per_page = 10;
							$wpn_paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
							$wpn_args = array(
								'post_type' => 'job',
								$taxonomy => $term->name,
								'post_status' => array('expired'),
								//'expired_post' => true,
								'paged' => $wpn_paged,
								'posts_per_page' => $wpn_per_page,
								'ignore_sticky_posts' => 1,
								'tax_query' => array(
									'taxonomy' => $taxonomy,
									'field' => $term->term_id,
									'terms' => $term->slug
								)
							);
								
							$tmp_query = $wp_query;  // Assign original WP Query Post Data to temporary variable for later use
							$wp_query = null;
							$wp_query = new WP_Query();
							$wp_query->query($wpn_args);

							// singular or plural for job counter, show only in custom category
							$counter_txt = _n( 'Currently %s expired job', 'Currently %s expired jobs', $wp_query->found_posts, 'wpnuke' );
							?>
								<div class="listings-header clearfix">
									<h2 class="listings-title"><?php _e('Expired Jobs', 'wpnuke') ?></h2>
									<div class="listings-counter"><?php printf( $counter_txt, '<span class="count">'. $wp_query->found_posts . '</span>' ); ?></div>
								</div><!--listings-head-->
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
								<p class="error"><?php _e('Sorry, no posts matched your criteria.', 'wpnuke');?></p>
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
							</div><!--listings-wrapper-expired-job-->
						</div><!--entry-->
					</article><!--post-content-->
				</div><!--post-->
			</div><!--content-->
			<?php get_sidebar(); ?>
			<div class="clearfix"></div>
		</div><!--container-->
<?php get_footer(); ?>