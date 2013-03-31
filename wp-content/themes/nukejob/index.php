<?php
$page = $_REQUEST['page'];
$action = $_REQUEST['action'];

switch($page) :
	case 'apply':
		if($action == 'add') {
			wpnuke_apply_for_job($_REQUEST['pid']);
		} else {
			wpnuke_remove_from_job($_REQUEST['pid']);
		}
		exit;
	break;
	
	case 'resume':
		if($action == 'submit') {
		
		}
	break;

	default:
?>
<?php get_header(); ?>
		<div id="container">
			<div class="slider-line"></div>
			<section class="slider">
				<div class="flexslider">
					<ul class="slides">
						<li><a href="#"><img src="<?php bloginfo('template_directory'); ?>/assets/slide-1.jpg" /></a></li>
						<li><a href="#"><img src="<?php bloginfo('template_directory'); ?>/assets/slide-2.jpg" /></a></li>
						<li><a href="#"><img src="<?php bloginfo('template_directory'); ?>/assets/slide-3.jpg" /></a></li>
					</ul>
				</div>
			</section><!--slider-->
			<div id="content" role="main">
			<?php get_search_form(); ?>
			<?php
				// all custom query if needed here
				if(isset($_REQUEST['job_type']) && !empty($_REQUEST['job_type'])) {
					echo "Loop for Job type";
				
				} else {
					// If no custom request, include the default job loop
					get_template_part('loop', 'job');
				}
			?>
			</div><!--content-->
			<?php get_sidebar(); ?>
			<div class="clearfix"></div>
		</div><!--container-->
<?php get_footer(); ?>
<?php
	break;
endswitch;
?>