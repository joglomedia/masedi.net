<div id="sidebar">

<?php if( is_home() || is_single() ) : ?>
<?php if (get_option('p2h_posttop_adcode') != '') : ?>
<div id="text-22" class="section widget-container widget_text"><h3>Sponsored Ads</h3>
<div class="textwidget">
<script type="text/javascript"><!--
google_ad_client = "ca-pub-9328925276485177";
/* me_300x250 */
google_ad_slot = "1129004366";
google_ad_width = 300;
google_ad_height = 250;
//-->
</script>
<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</div>
</div>
<?php endif; ?>
<?php endif; ?>

	<?php 	if ( ! dynamic_sidebar( 'top-sidebar-widgets' ) ) : ?>
		<div class="section">
			<h3><?php _e('Search', 'jenny'); ?></h3>
			<?php get_search_form(); ?>
		</div>
		
		<div class="section widget_categories">
			<h3><?php _e('Categories', 'jenny'); ?></h3>
			<ul>
				<?php wp_list_categories('title_li=&hierarchical=0'); ?>
			</ul>
		</div>
	<?php endif; ?>
	
	<?php
	// A second sidebar for widgets, just because.
	if ( is_active_sidebar( 'secondary-sidebar-widgets' ) ) : ?>
	<?php dynamic_sidebar( 'secondary-sidebar-widgets' ); ?>
	<?php endif; ?>
</div><!--#sidebar-->

<hr />