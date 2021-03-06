<!-- sidebar START -->
<div id="sidebar">
<!-- Style Switcher START -->
<?php
	$options = get_option('elegantbox_options');
	if($options['style_switcher']) {
		// Get the styles folder listing
		$styleFolder = TEMPLATEPATH . '/styles/';
		$styleArray = array();
		$objStyleFolder = dir($styleFolder);
		$styleTotal = 0;
		while(false !== ($styleFile = $objStyleFolder->read())) {
			if(is_dir($styleFolder . $styleFile) && $styleFile != '.' &&  $styleFile != '..') {
				$styleArray[] = $styleFile;
				$styleTotal += 1;
			}
		}
		$objStyleFolder->close();
		// When the styles more than one, display style switcher
		if($styleTotal > 1) {
?>
<div class="widget">
	<div id="styleswitcher">
		<span id="style-text"><?php _e('Theme Styles : ', 'elegantbox'); ?></span>
<?php
			// Display all the styl
			if (is_array($styleArray)) {
				foreach ($styleArray as $style) {
?>
			<span id="style-<?php echo($style); ?>" class="color"><a onclick="TSS.setActiveStyleSheet('<?php echo($style); ?>');" href="javascript:void(0);" title="<?php _e('Switch to ', 'elegantbox'); echo($style); ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/transparent.gif" alt="" /></a></span>
<?php
				}
		}
?>
		<div class="fixed"></div>
	</div>
</div>
<?php
		}
	}
?>
<!-- Style Switcher END -->
		<!-- showcase -->
		<?php if( $options['showcase_content'] && (
			($options['showcase_registered'] && $user_ID) || 
			($options['showcase_commentator'] && !$user_ID && isset($_COOKIE['comment_author_'.COOKIEHASH])) || 
			($options['showcase_visitor'] && !$user_ID && !isset($_COOKIE['comment_author_'.COOKIEHASH]))
		) ) : ?>
			<div class="widget">
				<div class="showcase">
					<?php echo($options['showcase_content']); ?>
				</div>
			</div>
		<?php endif; ?>		
		<ul id="widgets">
<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : ?>
			<!-- recent posts -->
			<li class="widget widget_pages">
				<h3>Recent Posts</h3>
				<ul>
					<?php $posts = get_posts('numberposts=10&orderby=post_date'); foreach($posts as $post) : setup_postdata($post); ?>
						<li>
							<span class="sidedate"><?php the_time('y/m/d') ?></span>
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</li>
					<?php endforeach; $post = $posts[0]; ?>
				</ul>
			</li>

			<!-- recent comments -->
			<?php if( function_exists('wp_recentcomments') ) : ?>
				<li class="widget">
					<h3>Recent Comments</h3>
					<ul>
						<?php wp_recentcomments('length=14&post=false&avatar_position=left'); ?>
					</ul>
				</li>
			<?php elseif( function_exists('get_recentcomments') ) : ?>
				<li class="widget">
					<h3>Recent Comments</h3>
					<ul>
						<?php get_recentcomments('length=14&post=false&avatar_position=left'); ?>
					</ul>
				</li>
			<?php endif; ?>
			<!-- tag cloud -->
			<li class="widget widget_tag_cloud">
				<h3>Tag Cloud</h3>
				<?php wp_tag_cloud('smallest=8&largest=16'); ?>
			</li>

			<!-- categories -->
			<li class="widget widget_categories">
				<h3>Categories</h3>
				<ul>
					<?php wp_list_cats('sort_column=name&optioncount=1'); ?>
				</ul>
			</li>

			<!-- archives -->
			<li class="widget widget_archive">
				<h3>Archives</h3>
				<ul>
					<?php wp_get_archives('type=monthly'); ?>
				</ul>
			</li>

			<!-- blogroll -->
			<li class="widget widget_links">
				<h3>Blogroll</h3>
				<ul>
					<?php if( function_exists( 'wp_multicollinks' ) ) : ?>
						<?php wp_multicollinks('orderby=rand&columns=2&limit=20'); ?>
					<?php else : ?>
						<?php wp_list_bookmarks('title_li=&categorize=0&orderby=rand'); ?>
					<?php endif; ?>
				</ul>
			</li>

			<!-- w3c validators -->
			<li class="widget">
				<h3>W3C validators</h3>
				<ul>
					<li><a href="http://validator.w3.org/check?uri=referer">XHTML 1.0 Transitional</a></li>
					<li><a href="http://jigsaw.w3.org/css-validator/check/referer?profile=css3">CSS level 3</a></li>
				</ul>
			</li>
<?php endif; ?>			<!-- STT -->				<?Php if( function_exists('stt_recent_terms') ) : ?>				<li id="stt2-widget" class="widget widget_stt2"><h2 class="widgettitle" style="font-size:90%;">Latest Searched Softwares</h2>					<ul>						<li>							<?php								$sttcount = '25';								//echo stt_recent_terms($sttcount);								global $post;								//$options = pk_stt2_function_stripslashes_options($options);								$options['auto_link'] = 2;								$options['show_count'] = FALSE;								$options['before_keyword'] = ', ';								$popular == FALSE;								$searchterms = pk_stt2_db_get_recent_terms($sttcount);								foreach($searchterms as $term){									if ( 0 == $options['auto_link'] ){										$toReturn .= $options['before_keyword'].$term->meta_value;									} else {												if( !$popular ){											if ( 1 == $options['auto_link'] ){									   											   $permalink = get_permalink( $post->ID );		// permalink to the current post											} elseif ( 2 == $options['auto_link']){			// permalink to search page 												$permalink = get_bloginfo( 'url' ).'/search/'.user_trailingslashit(pk_stt2_function_sanitize_search_link($term->meta_value));											}										} else {											$permalink = get_permalink($term->post_id);		// permalink to each posts										}												$toReturn .= $options['before_keyword']."<a href=\"$permalink\" title=\"$term->meta_value\">$term->meta_value</a>";									}											$options['show_count'] == true ? $toReturn .= " ($term->meta_count)".$options['after_keyword'] : $toReturn .= $options['after_keyword'];								}								$toReturn = trim($toReturn,', ');										$toReturn .= '';								echo htmlspecialchars_decode($toReturn);							?>							<span>&nbsp;</span>						</li>					</ul>				</li>				<?Php endif; ?>				<!-- end STT -->
		</ul>

		<!-- showcase 2 -->
		<?php if( $options['showcase_2_content'] && (
			($options['showcase_2_registered'] && $user_ID) || 
			($options['showcase_2_commentator'] && !$user_ID && isset($_COOKIE['comment_author_'.COOKIEHASH])) || 
			($options['showcase_2_visitor'] && !$user_ID && !isset($_COOKIE['comment_author_'.COOKIEHASH]))
		) ) : ?>
			<div class="widget">
				<div class="showcase">
					<?php echo($options['showcase_2_content']); ?>
				</div>
			</div>
		<?php endif; ?>
</div>
<!-- sidebar END -->