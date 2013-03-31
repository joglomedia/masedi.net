<?php
require_once dirname( __FILE__ ) . '/form_process.php';
get_header( ); 
include_classified_form( );
?>

	<div class="content">
	
		<ul id="catnav">
            <li<?php if ( is_home() ) { echo " class=\"current-cat\""; } ?>><a href="<?php bloginfo('url'); ?>" ><?php _e('Latest Listings','cp'); ?></a></li>
			<?php wp_list_categories('show_count=0&hide_empty=true&orderby=name&order=asc&title_li='); ?>
			<li><div class="clear"></div></li>
        </ul>
		
		<?php if ( is_category() && function_exists('bcn_display')) { ?>	
			<div class="subnav">
				<small><?php if(function_exists('bcn_display')) { bcn_display(); } ?></small>
			</div>
		<?php } ?>
		
		<div class="main">
		
			<div class="listing">
				<div class="head">
				
					<span class="name">
					<?php _e('Item Name','cp'); ?>
					<a href="?sort=title&order=asc"><img src="<?php bloginfo('template_url'); ?>/images/sortup.gif" border="0" /></a><a href="?sort=title&order=desc"><img src="<?php bloginfo('template_url'); ?>/images/sortdown.gif" border="0" /></a>
					</span>
					
					<span class="price">
					<?php _e('Price','cp'); ?>
					<a href="?sort=meta_value&key=price&order=asc"><img src="<?php bloginfo('template_url'); ?>/images/sortup.gif" border="0" /></a><a href="?sort=meta_value&key=price&order=desc"><img src="<?php bloginfo('template_url'); ?>/images/sortdown.gif" border="0" /></a>
					</span>
					
					<span class="location">
					<?php _e('Location','cp'); ?>
					<a href="?sort=meta_value&key=location&order=asc"><img src="<?php bloginfo('template_url'); ?>/images/sortup.gif" border="0" /></a><a href="?sort=meta_value&key=location&order=desc"><img src="<?php bloginfo('template_url'); ?>/images/sortdown.gif" border="0" /></a>
					</span>
					
					<span class="date">
					<?php _e('Posted','cp'); ?>
					<a href="?sort=date&order=asc"><img src="<?php bloginfo('template_url'); ?>/images/sortup.gif" border="0" /></a><a href="?sort=date&order=desc"><img src="<?php bloginfo('template_url'); ?>/images/sortdown.gif" border="0" /></a>					
					</span>
					
					<div class="clear"></div>
				</div>
				<div class="list">
					<?php 
					$i = 1; 
					$loopcount = 1;
					
					if(!empty($_GET['sort']))
					{
					$orderby=trim($_GET['sort']);
					$order=trim($_GET['order']);
					$key=trim($_GET['key']);
					
					// create the sort by injection
					$posts = query_posts($query_string . '&orderby='.$orderby.'&meta_key='.$key.'&order='.$order.'');
					}
					
					if (have_posts()) : ?>
					
					<?php while (have_posts()) : the_post(); ?>
					
					<?php if ($i % 2 == 0) { $alt = " class=\"alt\""; } else { $alt = " class=\"no\""; } echo "<div" . $alt;
					if (is_sticky()) { echo " id='sticky' "; } echo ">"; 
					?>
						
					<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
									
					<?php if ( get_option('main_page_img') != "no" ) { ?>

						<span class="image">	
							<?php $images = get_post_meta($post->ID, "images", true);
								if (empty($images)) {?>
								    <div class="main_page_no_img"><img src="<?php bloginfo('template_url'); ?>/images/no-pic.png" alt="No Photo" border="0" /></div></span>
								<?php } else { ?>
								<div class="main_page_img" style="background: #FFF url(<?php echo get_bloginfo('template_url')."/includes/img_resize.php?width=50&height=50&url=";?><?php
										  if ( strstr($images, ',')) {  
											$matches = explode(",", $images);
											$img_single = $matches[0];
											$img_single = explode(trailingslashit(get_option('siteurl')) . "wp-content/uploads/classipress/", $img_single);
											echo $img_single[1];
										  } else {
											$img_single2 = $images;
											echo $img_single2;
												}?>) center no-repeat"></div></span>
								<?php 
								} 
									} else {
										$ii = 1;
										echo "<span class='cat_image'>";
										foreach((get_the_category()) as $category) {
											if ($ii == "1") {
												$cat_image = get_bloginfo('template_url')."/images/category-icons/".get_option("cat$category->cat_ID").".png";
												echo "<img src=" . $cat_image . ">";
												$ii++;
											}
										}
										echo "</span>";
									} ?>
								
								<span class="item"><div style="text-decoration:underline; font-weight:bold;"><?php if ( strlen(get_the_title()) > 65 ) { echo substr(get_the_title(), 0, 65)."..."; } else { the_title(); } ?></div>
								<?php echo substr(strip_tags($post->post_content), 0, 190)."...";?></span>
								<span class="price"><?php echo get_option('currency'); ?><?php echo get_post_meta($post->ID, "price", true); ?></span>
								<span class="location"><?php echo get_post_meta($post->ID, "location", true); ?></span>
								<span class="date"><?php echo classi_time($post->post_date); ?></span>
							</a>
							<div class="clear"></div>
						</div>
						
						<!-- Start ADS -->
						<?php if ($loopcount == 1) : $i++; ?>
						
							<?php
							if ($i % 2 == 0) { $alt = " class=\"alt\""; $ga_color_bg = "EEEEEE"; } else { $alt = " class=\"no\""; $ga_color_bg = "F8F8F8"; } echo "<div" . $alt. ">"; 
							?>
							
						<a href="http://ads.masedi.net/#" title="Special Offers for Career &amp; Job Opportunities">
									
					
						<span class="image">	
							<div class="main_page_no_img"><img src="http://ads.masedi.net/wp-content/themes/classipress/images/no-pic.png" alt="No Photo" border="0"></div>
						</span>
																
							<span class="item">
							
								<script type="text/javascript"><!--
								google_ad_client = "pub-9328925276485177";
								/* ads_indexlist_halfbanner234x60 */
								google_ad_slot = "0587491347";
								google_ad_width = 234;
								google_ad_height = 60;
								google_color_border = "<?php echo $ga_color_bg; ?>";
								google_color_bg = "<?php echo $ga_color_bg; ?>";
								//-->
								</script>
								<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
								</script>


							</span>
							<span class="price">$0</span>

							<span class="location"></span>
							<span class="date"><?php echo classi_time($post->post_date); ?></span>
						</a>
						<div class="clear"></div>
					</div>
					<!-- End ADS -->
						
					<?php endif; ?>
						
					<?php $i++; $loopcount++; unset($alt); ?>
					
					<?php endwhile; ?>
					

						<div class="navigation1">
						<div class="navigation2">
						
						<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } else {  ?>
						
							<div class="alignleft">
								<?php next_posts_link('<div class="next_post_link"></div>') ?>
							</div>
							<div class="alignright">
								<?php previous_posts_link('<div class="previous_post_link"></div>') ?>
							</div>
							
						<?php  } ?>
						
						</div>
						<div style="clear:both;"></div>
						</div>
					<div style="clear:both;"></div>
					
					<?php endif; ?>
					
				</div>
			</div>

		</div>


					<!-- start ADS -->
					<div class="main"><div class="" style="width:730px; margin:15px auto; background:#eee;">
					
						<script type="text/javascript"><!--
						google_ad_client = "pub-9328925276485177";
						/* ads_index728x90 */
						google_ad_slot = "7200483576";
						google_ad_width = 728;
						google_ad_height = 90;
						//-->
						</script>
						<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
						</script>
					
					</div></div>
					<!-- end ADS -->


	</div>
	
<?php
//code to prune posts.
if (get_option("post_prun") == "yes" && get_option("prun_period") != "" && get_option("post_prun") != "") {
	$prun_period = get_option("prun_period");
	$sql = "SELECT `ID` FROM $wpdb->posts WHERE `post_date`<'".date('Y-m-d h:i:s', strtotime("-$prun_period days"))."' AND `post_status`='publish' AND `post_type`='post' LIMIT 10";
	$sql = mysql_query($sql);
	while ($row=mysql_fetch_array($sql)){
		$post_id = (int)$row['ID'];

		if (get_option("prun_status") == "1") {
			$my_post = array();
			$my_post['ID'] = $post_id;
			$my_post['post_status'] = 'draft';
			wp_update_post( $my_post );
		} else if (get_option("prun_status") == "2") {
			wp_delete_post($post_id);
		}
	}
}
?>	
	
<?php get_footer(); ?>