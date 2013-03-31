			<div id="sidebar">
				<?php
					// get job/resume submit link
					global $current_user, $jobresume_link;
					
					$jobresume_link = wpnuke_submit_job_button(&$current_user);
					if($jobresume_link) {
						echo '<div class="widget">'
							. '<a class="button post-a-job" href="' . $jobresume_link['url'] . '">' . $jobresume_link['anchor'] . '</a>'
							. '</div>';
					}
				?>
				<div class="widget">
					<a href="#"><img src="<?php bloginfo('template_directory'); ?>/assets/banner-1.jpg" alt="" /></a>
				</div>
				
				<?php 
				if ( is_home() ) :
				
					if (! function_exists( 'dynamic_sidebar' ) || ! dynamic_sidebar( 'homepage-sidebar' ) ) :
				?>
				
				<div class="widget">
					<h4>About Us</h4>
					<p>Premium Work is your job board that will help you find the right person for your job opening. Since 1945, we have been helping great companies as well as gifted job seekers to find their way to each other. <a href="#">Read More</a></p>
				</div>
				<div class="widget">
					<img src="<?php bloginfo('template_directory'); ?>/assets/company-logos.jpg" alt="" />
				</div>
				
				<?php 
					endif;
				?>
			
				<?php 
				elseif ( 'job' == get_post_type() ) :
					if (! function_exists( 'dynamic_sidebar' ) || ! dynamic_sidebar( 'job-sidebar' ) ) :
				?>
				
				<div class="widget">
					<h4>Job Widget</h4>
					<p>It is job board widget, you can add widget sidebar here.</p>
				</div>
				<div class="widget">
					<img src="<?php bloginfo('template_directory'); ?>/assets/company-logos.jpg" alt="" />
				</div>
				
				<?php
					endif;
				elseif ( 'resume' == get_post_type() ) :
					if (! function_exists( 'dynamic_sidebar' ) || ! dynamic_sidebar( 'resume-sidebar' ) ) :
				?>
				
				<div class="widget">
					<h4>Resume Widget</h4>
					<p>It is resume widget, you can add widget sidebar here.</p>
				</div>
				<div class="widget">
					<img src="<?php bloginfo('template_directory'); ?>/assets/company-logos.jpg" alt="" />
				</div>
				
				<?php
					endif;
				else :
					if (! function_exists( 'dynamic_sidebar' ) || ! dynamic_sidebar( 'main-sidebar' ) ) :
					endif;
				endif;
				?>

			</div><!--sidebar-->