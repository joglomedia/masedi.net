<?php
			// Column Structure
			$cols = array(
				'<th scope="col" id="cb" class="manage-column column-cb check-column" style=""><input type="checkbox" /></th>',
				'<th>'.__('ID', OPSEO_TEXT_DOMAIN).'</th>',
				'<th>'.__('Title', OPSEO_TEXT_DOMAIN).'</th>',
				'<th>'.__('On-Page SEO Score', OPSEO_TEXT_DOMAIN).'</th>',
				'<th>'.__('Keyword Density', OPSEO_TEXT_DOMAIN).'</th>',
				'<th>'.__('Primary Keyword', OPSEO_TEXT_DOMAIN).'</th>',
				'<th>'.__('Date', OPSEO_TEXT_DOMAIN).'</th>',
			);

			// Update Keywords/Scores
			if(isset($_REQUEST['bulk']))
			{
				for($i = 0; $i < sizeof($_REQUEST['bulk']); $i++)
				{
					// Post ID
					$url_id = $_REQUEST['bulk'][$i];

					// Add/Update Meta Data
					if((isset($_REQUEST['doaction']) && isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit') || (isset($_REQUEST['doaction2']) && isset($_REQUEST['action2']) && $_REQUEST['action2'] == 'edit'))
					{
						if(isset($_REQUEST['keyword-'.$_REQUEST['bulk'][$i]]) && (strlen(trim($_REQUEST['keyword-'.$_REQUEST['bulk'][$i]])) > 0))
						{
							// CORRECT - Better Variable Control
							$_REQUEST['mainkeyword'] = $_REQUEST['keyword-'.$_REQUEST['bulk'][$i]];
							$_REQUEST['allsecondarykeywords'] = $_REQUEST['allsecondarykeywords-'.$_REQUEST['bulk'][$i]];

							// Get URL Info
							$this->getNonPostURL($url_id);

							// Analyze URL
							$this->saveMetaDataURL($_REQUEST['nonpost-url']);

							// Update URL
							$this->editNonPostURL($url_id);
						}
					}
					// Delete URLs
					elseif((isset($_REQUEST['doaction']) && isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete') || (isset($_REQUEST['doaction2']) && isset($_REQUEST['action2']) && $_REQUEST['action2'] == 'delete'))
					{
						$this->deleteNonPostURL($url_id);
					}
					// Clear Keywords
					else
					{
						$this->clearNonPostURL($url_id);
					}
				}
			}

			$rows = array();


			// Global Variables
			global $wpdb;
			global $blog_id;

			$urls = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."onpageseo_urls WHERE blog_id='".$blog_id."'");

			foreach($urls as $url)
			{
				$mainKeyword = '';
				$secondaryKeywords = '';
				$totalScore = 0;
				$keywordDensityScore = '';

				$metaData = $this->preUnSerialize($url->score);

				if(is_array($metaData['onpageseo_global_settings']))
				{
					$mainKeyword = $metaData['onpageseo_global_settings']['MainKeyword'];
					$secondaryKeywords = $metaData['onpageseo_global_settings']['SecondaryKeywords'];
					$totalScore = $this->getKeywordScore(strtolower($mainKeyword), $metaData);
					$keywordDensityScore = $metaData[strtolower($metaData['onpageseo_global_settings']['MainKeyword'])]['KeywordDensityScore'];
				}

				// Total Score
				$scoreColor = 'red';
				if($totalScore > 0)
				{
					if($totalScore >= $this->minimumScore){ $scoreColor = 'green'; }
					$totalScore .= '%';
				}
				else { $totalScore = ''; }

				// Keyword Density
				$kwScoreColor = 'red';
				if(($keywordDensityScore > 0) && ($keywordDensityScore >= $this->options['keyword_density_minimum']) && ($keywordDensityScore <= $this->options['keyword_density_maximum']))
				{
					$kwScoreColor = 'green';
					$keywordDensityScore .= '%';
				}
				elseif(strlen(trim($keywordDensityScore)) > 0)
				{
					$kwScoreColor = 'red';
					$keywordDensityScore .= '%';
				}



				$rows[] = array('<th scope="row" class="check-column"><input type="checkbox" name="bulk[]" value="'.$url->id.'" /></th>',
					'<td>'.$url->id.'</td>',
					'<td><a href="'.$url->url.'"><strong>'.stripslashes($url->name).'</strong></a><br /><div class="row-actions"><span class="edit"><a href="admin.php?page=onpageseo-url-analyzer&nonpost-action=edit&id='.$url->id.'">'.__('Edit', OPSEO_TEXT_DOMAIN).'</a> | </span><span class="trash"><a onclick="return confirm(\''.__('This will permanently delete the URL. Continue?', OPSEO_TEXT_DOMAIN).'\')" class="submitdelete" href="admin.php?page=onpageseo-url-analyzer&nonpost-action=delete&id='.$url->id.'">Delete</a> | </span><span class="view"><a class="submitview" href="'.$url->url.'">'.__('View', OPSEO_TEXT_DOMAIN).'</a></span></div></td>',
					'<td><span style="color:'.$scoreColor.'">'.$totalScore.'</span></td>',
					'<td><span style="color:'.$kwScoreColor.'">'.$keywordDensityScore.'</span></td>',
					'<td><input type="text" value="'.$mainKeyword.'" name="keyword-'.$url->id.'" size="40" style="background:rgb(109,109,109) url('.OPSEO_PLUGIN_URL.'/images/mainkeywordbg.png) repeat-x 0 0;padding:8px 10px;color:rgb(255,255,255);border-top:1px solid rgb(109,109,109);border-left:1px solid rgb(109,109,109);border-right:1px solid rgb(109,109,109);" /><input type="hidden" name="allsecondarykeywords-'.$url->id.'" value="'.$secondaryKeywords.'" /></td>',
					'<td>'.$url->modified.'</td>'
				);



			}
















			$this->adminHeader('onpageseo-manage-keywords', __('Manage Keywords', OPSEO_TEXT_DOMAIN));


			echo '<div class="form-wrap">

					<form name="manageurls" id="manageurls" method="post" action="admin.php?page=onpageseo-url-analyzer">
					<input type="hidden" name="updated" value="true" />
					<input type="hidden" name="paged" value="'.$_REQUEST['paged'].'" />';

					echo '<div class="tablenav">
						<div class="alignleft actions">
							<select name="action" class="postform">
								<option value="edit" selected="selected">'.__('Bulk Actions', OPSEO_TEXT_DOMAIN).'</option>
								<option value="edit">'.__('Update', OPSEO_TEXT_DOMAIN).'</option>
								<option value="clear">'.__('Clear Keywords', OPSEO_TEXT_DOMAIN).'</option>
								<option value="delete">'.__('Delete', OPSEO_TEXT_DOMAIN).'</option>
							</select>
							<input type="submit" value="'.__('Apply', OPSEO_TEXT_DOMAIN).'" name="doaction" id="doaction" class="button-primary action" /> <a href="admin.php?page=onpageseo-url-analyzer&nonpost-action=add" class="button">'.__('Add New', OPSEO_TEXT_DOMAIN).'</a>



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
									<option value="clear">'.__('Clear Keywords', OPSEO_TEXT_DOMAIN).'</option>
									<option value="delete">'.__('Delete', OPSEO_TEXT_DOMAIN).'</option>
								</select>
								<input type="submit" value="'.__('Apply', OPSEO_TEXT_DOMAIN).'" name="doaction2" id="doaction2" class="button-primary action" /> <a href="admin.php?page=onpageseo-url-analyzer&nonpost-action=add" class="button">'.__('Add New', OPSEO_TEXT_DOMAIN).'</a>
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


			echo '</div>';
?>