<?php if ( !defined('ABSPATH') ) die('No direct access allowed');
require_once($opl_theme_path . 'header.php');
?>
<?php if ( $opl_display_header ) : ?>
<div id="opl-header-bg">
	<div id="opl-header" class="full_width_header" style="width:<?php echo $opl_single_width; ?>px; max-width:98%">
		<?php if ( $opl_header == 1 ) : ?>
		<?php if ( $opl_logo_type == 'text' ) { ?>
			<div id="opl-logo" class="opl-text-logo"><?php echo $opl_text_logo; ?></div>
		<?php } else { ?>
			<div id="opl-logo"><img src="<?php echo $opl_logo_url; ?>" border="0" /></div>
		<?php } ?>
		<?php endif; ?>
	</div>
</div>
<?php endif; ?>

<div id="out-wrapper">
<div id="wrapper">
	<div id="video_col">
		<?php if ( $opl_top_nav != '' ) : ?>
		<div style="text-align:center">
			<div id="opl-top-nav" class="squeeze-top-nav"><?php echo $opl_top_nav; ?></div>
			<div class="clearfix"></div>
		</div>
		<?php endif; ?>

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<?php if ( $opl_launchnav_pos == 'top' ) { ?>
			<div class="opl-launch-video">
				<div id="opl-main-video">
					<?php if ( $opl_headline != '' ) echo '<div class="opl-headline">' . $opl_headline . '</div>' . "\n\n"; ?>
					<div class="opl-main-video opl-vid-shadow" <?php echo $opl_main_vid_size; ?>>
						<?php echo $opl_show_video; ?>
					</div>
				</div>
			</div>
			<div class="opl-launch-bar-top"><?php echo $opl_launch_bar; ?></div>
			<div class="clearfix"></div>
		<?php } else { ?>
			<div id="opl-main-video">
				<?php if ( $opl_headline != '' ) echo '<h1 class="opl-headline">' . $opl_headline . '</h1>' . "\n\n"; ?>
				<div class="opl-main-video opl-vid-shadow" <?php echo $opl_main_vid_size; ?>>
					<?php echo $opl_show_video; ?>
				</div>
			</div>
		<?php } ?>
				
		<div id="full_width_col" style="width:<?php echo $opl_single_width; ?>px; max-width:98%">
			<div id="opl-main">
				<div class="opl-content">
					<?php if ( $opl_launchnav_pos == 'bottom' ) { ?>
						<div class="opl-launch-content">
							<?php the_content(); ?>
							<?php echo $opl_comment_title; ?>
							<?php echo $opl_facebook_comment; ?>
							<?php echo $opl_disqus_comment; ?>
						</div>
						<div class="opl-launch-bar"><?php echo $opl_launch_bar; ?></div>
						<div class="clearfix"></div>
					<?php } else { ?>
						<?php the_content(); ?>
						<?php echo $opl_comment_title; ?>
						<?php echo $opl_facebook_comment; ?>
						<?php echo $opl_disqus_comment; ?>
					<?php } ?>

					
				</div>
			</div>
		</div>
		<?php endwhile; endif; ?>
	</div>
</div>
</div>

<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>

<div id="footer-background">
	<div id="footer-content">
		<?php if ( $opl_footer_nav != '' ) : ?><div class="footer-nav"><?php echo $opl_footer_nav; ?></div><?php endif; ?>
		<?php if ( $opl_footer_text != '' ) : ?><div class="footer-text"><?php echo $opl_footer_text; ?></div><?php endif; ?>
		<?php opl_powered(); ?>
	</div>
</div>
<?php echo $opl_social_share; ?>
<?php require_once($opl_theme_path . 'footer.php'); ?>
