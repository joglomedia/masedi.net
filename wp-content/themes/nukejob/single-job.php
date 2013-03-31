<?php
/**
 * Single Job
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
				<?php 
					// <!--do not delete-->
					if (have_posts()) : while (have_posts()) : the_post();

						// Get job meta value
						$job_location = get_post_meta( $post->ID, WPNUKE_PREFIX . 'job_location', true );
						$location = explode(',', $job_location);
						$location = array_reverse($location);
						$country = $location[0];
						$state = $location[1];
						$city = $location[2];
						
						// Get custom job company tax attribute (term meta)
						$jterm = wpnuke_get_term_meta($post->ID, 'job_company', "OBJECT");
						$jstatus = wpnuke_get_jobstatus( $post->ID );
				?>
					<?php if(function_exists('wpnuke_breadcrumbs')) wpnuke_breadcrumbs(); ?><!--breadcrumb-->
					<article class="post-content">
						<header>
							<h1 id="post-<?php the_ID(); ?>" class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
							<div class="meta clearfix">
								<span class="meta-time"><?php the_time(get_option('date_format')); ?></span>
								<span class="meta-category"><?php echo get_the_term_list($post->ID, 'job_category', '', ',', ''); ?></span>
								<span class="meta-availability"><a href="<?php echo get_option('siteurl') . '/?page=job_type&amp;type='. wpnuke_get_jobtype( $post->ID, false ); ?>"><?php echo wpnuke_get_jobtype( $post->ID ); ?></a></span>
								<span class="meta-<?php echo (strtolower($jstatus) == 'expired') ? 'expired' : 'valid'; ?>"><?php echo $jstatus; ?></span>
							</div>
						</header>
						<div class="company-box clearfix">
							<figure class="company-logo">
								<img src="<?php echo wpnuke_get_jobthumb($post->ID); ?>" alt="<?php the_title(); ?>" height="100" width="100" />
							</figure>
							<hgroup>
								<h2 class="company-name"><a href="<?php echo get_term_link($jterm->name, 'job_company'); ?>"><?php echo apply_filters('the_title', $jterm->name); ?></a></h2>
								<div class="company-slogan"><?php echo $jterm->company_slogan; ?></div>
							</hgroup>
							<ul class="company-details">
								<li class="company-site"><a href="<?php echo $jterm->company_url; ?>" rel="nofollow" target="_blank"><?php echo $jterm->company_url; ?></a></li>
								<li class="company-email"><?php echo $jterm->company_email; ?></li>
								<li class="company-phone"><?php echo $jterm->company_phone; ?></li>
								<li class="company-address"><?php echo get_post_meta( $post->ID, WPNUKE_PREFIX . 'job_location', true ); ?></li>
							</ul>
						</div><!--company-box-->
						<div class="entry clearfix">
							<!-- Job Description based on the post content -->
							<h3><?php _e('Job Description', 'wpnuke'); ?></h3>
							<?php the_content('Continue...'); ?>
							
							<!-- Job How to Apply Instruction -->
							<h3><?php _e('How to Apply', 'wpnuke'); ?></h3>
							<?php
								$how_to_apply = get_post_meta( $post->ID, WPNUKE_PREFIX . 'job_instruction', true );
								if ($how_to_apply) {
									echo $how_to_apply;
								} else {
									echo '<p>' . __('If you interested with this job, please click the Apply button below!', 'wpnuke') . '</p>';
								}
							?>
							
							<!-- How to apply Button -->
							<div class="job-application">
							<?php 
							global $current_user;
							$user_role = $current_user->roles[1];
							
							// If not expired job, display the apply button
							if ($jstatus != 'Expired') :
								if ((wpnuke_check_user_role('job_seeker') && is_currentuser_resume($current_user->ID)) || !get_current_user_id()) : 
									// show position filled (if the job has been filled), otherwise show apply button
									$position_filled = get_post_meta($post->ID, WPNUKE_PREFIX . 'job_position_filled', true);
									if($position_filled == 'yes') :
									?>
									<p class="info">
										<?php
										$filled_text = wpnuke_get_option(WPNUKE_PREFIX . 'position_filled');
										if($filled_text){ 
											echo sprintf(__('%s', 'wpnuke'), $filled_text); 
										}else{
											_e('Position: Filled', 'wpnuke');
										}
										?>
									</p>
									<?php
									else :
										// show job application button
										wpnuke_apply_job_button($post->post_author, $post->ID);
									endif;
								elseif (wpnuke_check_user_role('job_seeker') && !is_currentuser_resume($current_user->ID)) :
									echo '<span class="apply-button" style="color:green;">' . sprintf(__('To apply this job click <a href="%s">here</a>!', 'wpnuke'), get_option('siteurl') . '/?page=resume&amp;action=submit') . '</span>';
								else :
									// do nothing
								endif;
							else :
								echo '<p class="error">' . __('Sorry, this job has been expired!', 'wpnuke') . '</p>';
							endif; // end display apply button
							?>
							</div><!--application-button-->
							
							<!-- Job Map Location -->
							<h3><?php _e('Job Location on Map', 'wpnuke'); ?></h3>
							<?php
							$coordinate = get_post_meta($post->ID, WPNUKE_PREFIX . 'map_location', true);
							$address = get_post_meta($post->ID, WPNUKE_PREFIX . 'job_location', true);
							
							if($coordinate) :
								$geo_coord = explode(',', $coordinate);
								$geo_lat = $geo_coord[0];
								$geo_lng = $geo_coord[1];
								
								$map_desc .= '<h3><a href="" class="ptitle" style="color:#444444;font-size:16px;"><span>' . get_the_title() . '</span></a></h3>';
								if($address) {
									$map_desc .= '<span style="font-size:11px;">' . $address . '</span>';
								}
								
								// include preview map script
								locate_template(WPNUKE_INCLUDES_DIR . '/lib/map/preview-map.php', true);
								
								// preview google map
								wpnuke_preview_google_map($geo_lat, $geo_lng, $map_desc);
							else :
							?>
							<div class="responsive-iframe-container">
								<iframe src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=<?php //echo get_post_meta( $post->ID, WPNUKE_PREFIX . 'job_location', true ); ?>&amp;aq=&amp;ie=UTF8&amp;hq=&amp;t=m&amp;z=14&amp;spn=0.093419,0.169086&amp;ll=<?php echo get_post_meta( $post->ID, WPNUKE_PREFIX . 'map_location', true ); ?>&amp;output=embed&amp;iwloc=A" width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
							</div>
							<?php
							endif;
							?>
						</div><!--entry-->
						<section class="tags clearfix">
							<h5>Tags:</h5>
							<?php echo get_the_term_list($post->ID, 'job_tag', '<ul><li>', '</li><li>', '</li></ul>'); ?>
						</section>
						<section class="post-share clearfix">
							<div class="gplus-btn"><div class="g-plusone" data-size="medium" data-href="http://grafisia.com"></div></div>
							<div class="fb-like" data-href="http://grafisia.com" data-send="false" data-layout="button_count" data-width="130" data-show-faces="false"></div>
							<div class="tweet-btn"><a href="https://twitter.com/share" class="twitter-share-button" data-url="http://grafisia.com" data-count="horizontal">Tweet</a></div>
							<div class="linkedin-btn">
								<script src="http://platform.linkedin.com/in.js" type="text/javascript"></script>
								<script type="IN/Share" data-url="http://grafisia.com" data-counter="right"></script>
							</div>
							<div class="email-btn"></div>
							<div class="print-btn"><a href="#" onclick="window.print();return false;"><?php _e('Print', 'wpnuke');?></a></div>
						</section><!--post-share-->
						
						<section class="applicants">
						
						</section><!--job-applicants-->
					</article><!--post-content-->
					<?php
					// show comments
						comments_template();
					?>
				<?php
				// <!--do not delete-->
					endwhile; 
				else:
				?>
				<p><?php _e('Sorry, no jobs matched your criteria.', 'wpnuke'); ?></p>
				<?php endif; ?>
				</div><!--post-->
			</div><!--content-->
			<?php get_sidebar(); ?>
			<div class="clearfix"></div>
		</div><!--container-->
<?php get_footer(); ?>