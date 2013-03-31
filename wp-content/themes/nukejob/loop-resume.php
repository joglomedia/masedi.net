<?php
/**
 * Loop Resume
 * Only for admin, or logged in user
 */
?>
				<div class="listings-wrapper">
					<ul class="listings">
					
					<?php
					$wpn_post_type = 'resume';
					$wpn_per_page = 10;
					$wpn_paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
					$wpn_args = array(
						'post_type' => $wpn_post_type,
						'post_status' => 'publish',
						'paged' => $wpn_paged,
						'posts_per_page' => $wpn_per_page,
						'caller_get_posts' => 1
					);
					$tmp_query = $wp_query;  // Assign original WP Query Post Data to temporary variable for later use
					$wp_query = null;
					$wp_query = new WP_Query();
					$wp_query->query($wpn_args);
					
					if ($wp_query->have_posts()) :
						while ( $wp_query->have_posts() ) : $wp_query->the_post();
					?>
					
					  	<li>
							<a href="<?php the_permalink() ?>">
								<span>
									<?php
										// get company logo
										$logo_id = absint( get_post_meta( get_the_ID(), WPNUKE_PREFIX . 'company_logo', true ) );
										if ($logo_id) {
											$logo_image = wp_get_attachment_image_src( $logo_id, 'company-logo-small' );
											$logo_src = $logo_image[0];
										} else {
											$logo_src = get_bloginfo('template_directory') . '/images/hibiniu.png';
										}
									?>
									<img src="<?php echo $logo_src; ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" height="32px" width="32px" />
									<div class="role">
										<h3><?php the_title(); ?></h3>
										<p><?php echo get_post_meta( get_the_ID(), WPNUKE_PREFIX . 'company_name', true ); ?>&nbsp;-&nbsp;<span><?php $job_location = get_post_meta( get_the_ID(), WPNUKE_PREFIX . 'job_location', true ); $location = explode(',', $job_location); $location = array_reverse($location); $state = $location[1]; echo $job_location; ?></span></p>
									</div>
									<?php
									$job_categories = get_the_terms(get_the_ID(), 'job_category');
			
									if (is_array($job_categories)) {
										foreach($job_categories as $key => $job_category) {
											$cat_link = site_url() . "/" . $job_category->slug . "";
											$job_categories[$key] =  $job_category->name;
										}
										$job_category = implode(' , ', $job_categories);
									} else {
										$job_category = __( 'Uncategorized' );
									}
									?>
									<div class="location"></div>
									<div class="meta">
										<span class="type"><?php $job_type = get_post_meta( get_the_ID(), WPNUKE_PREFIX . 'job_type', true ); switch($job_type) { case 'fulltime': _e('Full Time'); break; case 'parttime': _e('Full Time'); break; case 'freelance': _e('Freelance'); break; default: _e('Full Time'); break; } ?></span>
										<span class="posted"><?php the_time( get_option('date_format') ) ?></span>
									</div>
								</span>
							</a>
						</li>
						
					<?php
						endwhile;
					?>
					
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
					?>
				
				<?php else : ?>
					<h3><?php __('Sorry, no resume yet.', 'nukejob');?></h3>
					<p><?php _e('Please submit your resume here...', 'nukejob');?></p> 
				<?php endif; ?>
				
				</div><!--listings-wrapper-->
