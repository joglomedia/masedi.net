<?php if ( !defined('ABSPATH') ) die('No direct access allowed');
require_once($opl_theme_path . 'header.php');
?>
<?php if ( $opl_display_header ) : ?>
<div id="opl-header-bg">
	<div id="opl-header" class="full_width_header">
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

<div id="wrapper">
		<?php if ( $opl_top_nav != '' ) : ?>
		<div style="text-align:center">
			<div id="opl-top-nav" class="squeeze-top-nav"><?php echo $opl_top_nav; ?></div>
			<div class="clearfix"></div>
		</div>
		<?php endif; ?>

	<div id="right_col" class="opl-optin-only">
		<div id="optin">
			<div class="optin_body">
				
				<div class="optin_content optin_mini_content">
					<p class="optin_title"><?php echo $opl_optin_title; ?></p>
					<p><?php echo $opl_optin_text; ?></p>
					<?php echo $opl_optin_form; ?>
					
					<?php if ( $opl_fb_subs == 1 ) : ?>
					<div class="optin_facebook">
						<?php if ( $opl_facebook_text != '' ) : ?><p class="optin_fb_text"><?php echo $opl_facebook_text; ?></p><?php endif; ?>
						<button class="opl-facebook-btn" name="opl-connect" id="opl-connect"><?php echo $opl_facebook_label; ?></button>
						<?php opl_facebook_connect($opl_headline); ?>
					</div>
					<?php endif; ?>

					<p class="privacy_notice"><small><?php echo $opl_privacy_text; ?></small></p>
				</div>
			</div>
			<div class="optin_footer"></div>
		</div>
	</div>
	<div class="clearfix"></div>
</div>

<div id="footer-background">
	<div id="footer-content">
		<?php if ( $opl_footer_nav != '' ) : ?><div class="footer-nav"><?php echo $opl_footer_nav; ?></div><?php endif; ?>
		<?php if ( $opl_footer_text != '' ) : ?><div class="footer-text"><?php echo $opl_footer_text; ?></div><?php endif; ?>
		<?php opl_powered(); ?>
	</div>
</div>
<?php echo $opl_social_share; ?>
<?php require_once($opl_theme_path . 'footer.php'); ?>
