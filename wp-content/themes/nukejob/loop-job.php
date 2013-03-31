<?php
/**
 * The loop that displays the job listing.
 *
 * @package WPNuke
 * @subpackage Vacancy
 * @since Vacancy 1.0
 */
?>
				<div class="listings-wrapper">
				<?php
				global $more; $more = 0;
				
				$wpn_per_page = 10;
				$wpn_paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
				$wpn_args = array(
					'post_type' => 'job',
					'post_status' => array('publish', 'expired'),
					//'not_expired_post' => true,
					'paged' => $wpn_paged,
					'posts_per_page' => $wpn_per_page,
					'ignore_sticky_posts' => 1
				);
				
				$tmp_query = $wp_query;  // Assign original WP Query Post Data to temporary variable for later use
				$wp_query = null;
				$wp_query = new WP_Query();
				$wp_query->query($wpn_args);

				// Start WP Loop
				if ($wp_query->have_posts()) :
				?>
					<ul class="listings">
					<?php
						while ($wp_query->have_posts()) : $wp_query->the_post();
						
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
					<?php else : ?>
					<p class="error"><?php _e('Sorry, no posts matched your criteria.', 'wpnuke');?></p>
					<?php endif; ?>
				</div><!--listings-wrapper-->