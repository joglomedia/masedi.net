<?php
			// Column Structure
			$cols = array(
				'<th scope="col" id="cb" class="manage-column column-cb check-column" style=""><input type="checkbox" /></th>',
				'<th>'.__('ID', OPSEO_TEXT_DOMAIN).'</th>',
				'<th>'.__('Title', OPSEO_TEXT_DOMAIN).'</th>',
				'<th>'.__('On-Page SEO Score', OPSEO_TEXT_DOMAIN).'</th>',
				'<th>'.__('Primary Keyword', OPSEO_TEXT_DOMAIN).'</th>',
				'<th>'.__('Keyword Density', OPSEO_TEXT_DOMAIN).'</th>',
				'<th>'.__('Categories', OPSEO_TEXT_DOMAIN).'</th>',
				'<th>'.__('Date', OPSEO_TEXT_DOMAIN).'</th>',
			);

			// Update Keywords/Scores
			if(isset($_REQUEST['bulk']))
			{
				for($i = 0; $i < sizeof($_REQUEST['bulk']); $i++)
				{
					// Post ID
					$this->postID = $_REQUEST['bulk'][$i];

					// Add/Update Meta Data
					if((isset($_REQUEST['doaction']) && isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit') || (isset($_REQUEST['doaction2']) && isset($_REQUEST['action2']) && $_REQUEST['action2'] == 'edit'))
					{
						if(isset($_REQUEST['keyword-'.$_REQUEST['bulk'][$i]]) && (strlen(trim($_REQUEST['keyword-'.$_REQUEST['bulk'][$i]])) > 0))
						{
							// CORRECT - Better Variable Control
							$_REQUEST['mainkeyword'] = $_REQUEST['keyword-'.$_REQUEST['bulk'][$i]];
							$_REQUEST['allsecondarykeywords'] = $_REQUEST['allsecondarykeywords-'.$_REQUEST['bulk'][$i]];

							$pID = get_post($this->postID);

							// Post Content
							$_REQUEST['content'] = $pID->post_content;

							// Post Title
							$_REQUEST['post_title'] = $pID->post_title;

							$this->saveMetaData($this->postID);
						}
					}
					// Delete Meta Data
					else
					{
						$metaData = get_post_meta($this->postID, $this->postMetaDataName, true);

						// Post Meta Data Already Exists
						if(!empty($metaData)) { delete_post_meta($this->postID, $this->postMetaDataName); }
					}
				}
			}

			$rows = array();

			$myPosts = new WP_Query();

			$paged = isset($_REQUEST['paged']) ? $_REQUEST['paged'] : 1;
			if(!isset($_REQUEST['poststatus']) || (strlen(trim($_REQUEST['poststatus'])) == 0)) { $_REQUEST['poststatus'] = 'publish'; }
			if(!isset($_REQUEST['posttype']) || (strlen(trim($_REQUEST['posttype'])) == 0)) { $_REQUEST['posttype'] = 'any'; }

			//if(isset($_REQUEST['m']) && strlen(trim($_REQUEST['m'])) > 0)
				list($year,$month) = explode('-',$_REQUEST['m']);


			$args = array(
				'post_type'=>$_REQUEST['posttype'],
				'post_status'=>$_REQUEST['poststatus'],
				'paged'=>$paged,
				'posts_per_page'=>$this->options['posts_per_page'],
				'cat'=>$_REQUEST['cat'],
				'monthnum'=>(int)$month,
				'year'=>$year
			);

			// Get Posts/Pages
			$myPosts->query($args);

			while ($myPosts->have_posts()) : $myPosts->the_post();

				$metaData = get_post_meta($myPosts->post->ID, $this->postMetaDataName, true);

				$mainKeyword = '';
				$secondaryKeywords = '';
				$totalScore = 0;
				$kwDensityScore = 0;

				if(is_array($metaData['onpageseo_global_settings']))
				{
					$mainKeyword = $metaData['onpageseo_global_settings']['MainKeyword'];
					$secondaryKeywords = $metaData['onpageseo_global_settings']['SecondaryKeywords'];
					//$totalScore = $metaData[trim(strtolower($mainKeyword))]['TotalScore'];
					$totalScore = $this->getKeywordScore(strtolower($mainKeyword), $metaData);
					$kwDensityScore = $metaData[trim(strtolower($mainKeyword))]['KeywordDensityScore'];
				}

				$category = '';
				foreach(get_the_category($myPosts->post->ID) as $cat)
				{
					if(strlen(trim($category)) > 0) { $category .= ', '; }
					$category .= '<a href="'.get_category_link($cat->cat_ID).'">'.$cat->cat_name.'</a>';
				}

				$scoreColor = 'red';
				if($totalScore > 0)
				{
					if($totalScore >= $this->minimumScore){ $scoreColor = 'green'; }
					$totalScore .= '%';
				}
				else { $totalScore = ''; }

				$kwDensityColor = 'red';
				if($kwDensityScore > 0)
				{
					if(($kwDensityScore <= $this->options['keyword_density_maximum'] && $kwDensityScore >= $this->options['keyword_density_minimum'])){ $kwDensityColor = 'green'; }
					$kwDensityScore .= '%';
				}
				else { $kwDensityScore = ''; }

				$rows[] = array('<th scope="row" class="check-column"><input type="checkbox" name="bulk[]" value="'.$myPosts->post->ID.'" /></th>',
					'<td>'.$myPosts->post->ID.'</td>',
					'<td><a href="'.get_permalink($myPosts->post->ID).'"><strong>'.$myPosts->post->post_title.'</strong></a><br /><div class="row-actions"><span class="edit"><a href="post.php?action=edit&post='.$myPosts->post->ID.'">'.__('Edit', OPSEO_TEXT_DOMAIN).'</a> | </span><span class="view"><a class="submitview" href="'.get_permalink($myPosts->post->ID).'">'.__('View', OPSEO_TEXT_DOMAIN).'</a></span></div></td>',
					'<td><span style="color:'.$scoreColor.'">'.$totalScore.'</span></td>',
					'<td><input type="text" value="'.$mainKeyword.'" name="keyword-'.$myPosts->post->ID.'" size="40" style="background:rgb(109,109,109) url('.OPSEO_PLUGIN_URL.'/images/mainkeywordbg.png) repeat-x 0 0;padding:8px 10px;color:rgb(255,255,255);border-top:1px solid rgb(109,109,109);border-left:1px solid rgb(109,109,109);border-right:1px solid rgb(109,109,109);" /><input type="hidden" name="allsecondarykeywords-'.$myPosts->post->ID.'" value="'.$secondaryKeywords.'" /></td>',
					'<td><span style="color:'.$kwDensityColor.'">'.$kwDensityScore.'</span></td>',
					'<td>'.$category.'</td>',
					'<td>'.$myPosts->post->post_date.'</td>'
				);



			endwhile;


			$this->adminHeader('onpageseo-manage-keywords', __('Manage Keywords', OPSEO_TEXT_DOMAIN));



			echo '<div class="form-wrap">

					<form name="addkeywords" id="addkeywords" method="post" action="?page=onpageseo-manage-keywords">
					<input type="hidden" name="updated" value="true" />
					<input type="hidden" name="paged" value="'.$_REQUEST['paged'].'" />';

					echo '<div class="tablenav">
						<div class="alignleft actions">
							<select name="action" class="postform">
								<option value="edit" selected="selected">'.__('Bulk Actions', OPSEO_TEXT_DOMAIN).'</option>
								<option value="edit">'.__('Update', OPSEO_TEXT_DOMAIN).'</option>
								<option value="delete">'.__('Clear Keywords', OPSEO_TEXT_DOMAIN).'</option>
							</select>
							<input type="submit" value="'.__('Apply', OPSEO_TEXT_DOMAIN).'" name="doaction" id="doaction" class="button-primary action" />

							<select name="posttype" style="margin-right:6px;">
								<option'.$this->selected('posttype','any').' value="any">'.__('View all post types', OPSEO_TEXT_DOMAIN).'&nbsp;</option>
								<option'.$this->selected('posttype','post').' value="post">'.__('Posts', OPSEO_TEXT_DOMAIN).'</option>
								<option'.$this->selected('posttype','page').' value="page">'.__('Pages', OPSEO_TEXT_DOMAIN).'</option>';

								// Post Types
								global $wp_version;
								if (version_compare($wp_version, '2.9', '>='))
								{
									$args = array('public'=>true,'_builtin'=>false);
									$post_types = get_post_types($args); 
									foreach ($post_types  as $postType )
									{
										echo '<option'.$this->selected('posttype',$postType).' value="'.$postType.'">'.ucwords($postType).'</option>';
									}
								}

							echo '</select>';




							$pStatus = isset($_REQUEST['poststatus']) ? (int)$_REQUEST['poststatus'] : 0;
							echo '<select name="poststatus" style="margin-right:6px;">
									<option'.$this->selected('poststatus','publish').' value="publish">'.__('View all published', OPSEO_TEXT_DOMAIN).'&nbsp;</option>
									<option'.$this->selected('poststatus','pending').' value="pending">'.__('Pending', OPSEO_TEXT_DOMAIN).'</option>
									<option'.$this->selected('poststatus','draft').' value="draft">'.__('Draft', OPSEO_TEXT_DOMAIN).'</option>
									<option'.$this->selected('poststatus','future').' value="future">'.__('Future', OPSEO_TEXT_DOMAIN).'</option>
									<option'.$this->selected('poststatus','private').' value="private">'.__('Private', OPSEO_TEXT_DOMAIN).'</option>';

							if(version_compare (get_bloginfo('version'), '2.9', '>='))
							{
								echo '<option'.$this->selected('poststatus','trash').' value="trash">'.__('Trash', OPSEO_TEXT_DOMAIN).'</option>';
							}

							echo '</select>';

							$dropdown_options = array('show_option_all' => __('View all categories', OPSEO_TEXT_DOMAIN), 'hide_empty' => 0, 'hierarchical' => 1, 'show_count' => 0, 'orderby' => 'name', 'selected' => $_REQUEST['cat']);
							wp_dropdown_categories($dropdown_options);



global $wpdb;

$arc_result = $wpdb->get_results($wpdb->prepare("SELECT DISTINCT YEAR(post_date) AS yyear, MONTH(post_date) AS mmonth FROM %s WHERE post_type = 'post' ORDER BY post_date DESC", $wpdb->posts));

$month_count = count($arc_result);

if ( $month_count && !( 1 == $month_count && 0 == $arc_result[0]->mmonth ) ) {
$m = isset($_GET['m']) ? (int)$_GET['m'] : 0;

echo "<select name='m'>
<option value='0'>". __('Show all dates', OPSEO_TEXT_DOMAIN)."</option>";

foreach ($arc_result as $arc_row) {
	if ( $arc_row->yyear == 0 )
		continue;
	$arc_row->mmonth = zeroise( $arc_row->mmonth, 2 );

	if ( $arc_row->yyear . '-' . $arc_row->mmonth == $_REQUEST['m'] )
		$default = ' selected="selected"';
	else
		$default = '';

	echo "<option$default value='" . esc_attr("$arc_row->yyear-$arc_row->mmonth") . "'>";
	echo $this->getMonthName($arc_row->mmonth) . " $arc_row->yyear";
	echo "</option>\n";
}



echo '</select>';
}


							echo '<input type="submit" id="post-query-submit" value="'.__('Filter', OPSEO_TEXT_DOMAIN).'" class="button-secondary" />
						</div>';

$args = array('page'=>$_REQUEST['page'], 'paged'=>'%#%', 'posttype'=>$_REQUEST['posttype'], 'poststatus'=>$_REQUEST['poststatus'], 'cat'=>$_REQUEST['cat'], 'm'=>$_REQUEST['m']);

$page_links = paginate_links( array(
	'base' => add_query_arg($args),
	'format' => '',
	'prev_text' => '&laquo;',
	'next_text' => '&raquo;',
	'total' => $myPosts->max_num_pages,
	'current' => $paged
));?>


<?php if($page_links){?>
<div class="tablenav-pages"><?php $page_links_text = '<span class="displaying-num">' . sprintf(__('Displaying %s&#8211;%s of %s', OPSEO_TEXT_DOMAIN),
	number_format_i18n( ( $paged - 1 ) * $myPosts->query_vars['posts_per_page'] + 1 ),
	number_format_i18n( min( $paged * $myPosts->query_vars['posts_per_page'], $myPosts->found_posts ) ),
	number_format_i18n( $myPosts->found_posts )) . '</span>' . $page_links;

	echo $page_links_text; ?>
<div class="clear"></div>
</div>
<?php }



						echo '</div>';


						echo $this->adminTable($cols,$rows);

						echo '<div class="tablenav">
							<div class="alignleft actions">
								<select name="action2">
									<option value="edit" selected="selected">'.__('Bulk Actions', OPSEO_TEXT_DOMAIN).'</option>
									<option value="edit">'.__('Update', OPSEO_TEXT_DOMAIN).'</option>
									<option value="delete">'.__('Clear Keywords', OPSEO_TEXT_DOMAIN).'</option>
								</select>
								<input type="submit" value="'.__('Apply', OPSEO_TEXT_DOMAIN).'" name="doaction2" id="doaction2" class="button-primary action" />
								<br class="clear" />
							</div>';

?>

<?php if($page_links){?>

<div class="tablenav-pages"><?php $page_links_text = '<span class="displaying-num">' . sprintf(__('Displaying %s&#8211;%s of %s', OPSEO_TEXT_DOMAIN),

	number_format_i18n( ( $paged - 1 ) * $myPosts->query_vars['posts_per_page'] + 1 ),

	number_format_i18n( min( $paged * $myPosts->query_vars['posts_per_page'], $myPosts->found_posts ) ),

	number_format_i18n( $myPosts->found_posts )) . '</span>' . $page_links;

	echo $page_links_text; ?>

<div class="clear"></div>

</div>

<?php }



							echo '<br class="clear" />
							</div>';


					echo '</form>';

				echo '</div>';

				if(!$this->license->isLicenseError()){$this->resetFooter();}


			echo '</div>';
?>