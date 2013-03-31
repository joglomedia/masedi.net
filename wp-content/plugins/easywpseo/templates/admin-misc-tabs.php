<?php
		global $wpdb;
		global $post;
		global $pagenow;

		echo '<div id="misc-tabs">';

			echo '<ul>
					<li class="misctabs" style="margin-bottom:0 !important;padding-bottom:0 !important;"><a href="#misc-1" style="font-weight:normal !important;">'.__('Links', OPSEO_TEXT_DOMAIN).'</a></li><li class="misctabs" style="margin-bottom:0 !important;padding-bottom:0 !important;margin-left:2px !important;"><a href="#misc-2" style="font-weight:normal !important;">'.__('Images', OPSEO_TEXT_DOMAIN).'</a></li><li class="misctabs" style="margin-bottom:0 !important;padding-bottom:0 !important;margin-left:2px !important;"><a href="#misc-3" style="font-weight:normal !important;">'.__('Copyscape', OPSEO_TEXT_DOMAIN).'</a></li><li class="misctabs" style="margin-bottom:0 !important;padding-bottom:0 !important;margin-left:2px !important;"><a href="#misc-4" style="font-weight:normal !important;">Help</a></li>
				</ul>';


			echo '<div id="misc-1" class="misc-tabs-panel">';

			// Hide if URL Analyzer
			if (false === strpos($pagenow, 'admin'))
			{

				if(is_array($this->postMeta['onpageseo_global_settings']) && isset($this->postMeta['onpageseo_global_settings']['MainKeyword']) && (strlen(trim($this->postMeta['onpageseo_global_settings']['MainKeyword'])) > 0))
				{
					$main_keyword = '%'.$this->postMeta['onpageseo_global_settings']['MainKeyword'].'%';

					$internalLinks = array();

					//$wpdb->query("SET NAMES 'utf8'");
					//$wpdb->query("SET CHARACTER_SET_CLIENT='utf8'");
					//$wpdb->query("SET CHARACTER_SET_CONNECTION='utf8'");
					//$wpdb->query("SET CHARACTER_SET_RESULTS='utf8'");
					//$wpdb->query("SET CHARACTER_SET_SERVER='utf8'");
					//$wpdb->query("SET COLLATION_CONNECTION='utf8_general_ci'");
					//$wpdb->query("SET COLLATION_SERVER='utf8_general_ci'"); 
					$internalLinks = $wpdb->get_results($wpdb->prepare("SELECT ID,post_title,post_date FROM $wpdb->posts WHERE post_status='publish' AND (post_title LIKE '%s' OR post_content LIKE '%s') AND ID != '%d' ORDER BY post_title LIMIT 0,5", $main_keyword, $main_keyword, $post->ID), OBJECT);

					if(sizeof($internalLinks) > 0)
					{
						echo '<ol class="misctabsol">';
						foreach($internalLinks as $internalLink)
						{
							if(strlen(trim($internalLink->post_title)) == 0)
							{
								$internalLink->post_title = 'No Title';
							}

							echo '<li class="draggableslinks"><a href="'.urldecode(get_permalink($internalLink->ID)).'">'.$internalLink->post_title.'</a></li>';
						}
						echo '</ol>';
					}
					else
					{
					echo '<p style="font-weight:normal !important;margin:0 !important;padding:0 !important;">'.__('Sorry, but there are no related internal posts or pages.', OPSEO_TEXT_DOMAIN).'</p>';
					}

				}
				else
				{
					echo '<p style="font-weight:normal !important;margin:0 !important;padding:0 !important;">'.__('Sorry, but there are no related internal posts or pages.', OPSEO_TEXT_DOMAIN).'</p>';
				}
			}
			else
			{
				echo '<p style="font-weight:normal !important;margin:0 !important;padding:0 !important;">'.__('Sorry, but this feature is not supported in the URL Analyzer.', OPSEO_TEXT_DOMAIN).'</p>';
			}

			echo '</div>';

			echo '<div id="misc-2" class="misc-tabs-panel">';

			// Hide if URL Analyzer
			if (false === strpos($pagenow, 'admin'))
			{

				if(class_exists('RecursiveIteratorIterator') && class_exists('RecursiveDirectoryIterator'))
				{
					$dir = wp_upload_dir();

					if(isset($dir['basedir']) && (strlen(trim($dir['basedir'])) > 0))
					{
						$directory = $dir['basedir'];

						$count = 0;
						$maxNumber = 0;
						$mainKeyword = '';
						if(is_array($this->postMeta['onpageseo_global_settings']) && isset($this->postMeta['onpageseo_global_settings']['MainKeyword']) && (strlen(trim($this->postMeta['onpageseo_global_settings']['MainKeyword'])) > 0))
						{
							$mainKeyword = $this->postMeta['onpageseo_global_settings']['MainKeyword'];
						}

						$objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory), RecursiveIteratorIterator::SELF_FIRST);
						foreach ($objects as $fileinfo)
						{
							if($maxNumber >= $this->options['internal_images_per_page'])
							{
								break;
							}

							if ($fileinfo->isFile())
							{
								$path = str_replace(trailingslashit(WP_CONTENT_DIR),'', $fileinfo->getRealPath());
								$path = trailingslashit(WP_CONTENT_URL).$path;
								$extension = pathinfo($fileinfo->getRealPath());
								$extension = strtolower($extension['extension']);

								if(($extension == 'png') || ($extension == 'gif') || ($extension == 'jpg') || ($extension == 'jpe') || ($extension == 'jpeg'))
								{
									if(!$count){echo '<ol class="imagestabsol">';}
									echo '<li class="draggablesimages"><img src="'.$path.'" alt="XqXsXvX" title="XqXsXvX" /></li>';
									if(!$count){$count = 1;}
									$maxNumber += 1;
								}
							}
						}

						if($count){echo '</ol>';}
						else
						{
							echo '<p style="font-weight:normal !important;margin:0 !important;padding:0 !important;">'.__('Sorry, but there are no images in the media library.', OPSEO_TEXT_DOMAIN).'</p>';
						}
					}
					else
					{
						echo '<p style="font-weight:normal !important;margin:0 !important;padding:0 !important;">'.__('ERROR:', OPSEO_TEXT_DOMAIN).' '.$dir['error'].'</p>';
					}
				}
				else
				{
						echo '<p style="font-weight:normal !important;margin:0 !important;padding:0 !important;">'.__('Sorry, but your web server does not support this feature.', OPSEO_TEXT_DOMAIN).'</p>';
				}

			}
			else
			{
				echo '<p style="font-weight:normal !important;margin:0 !important;padding:0 !important;">'.__('Sorry, but this feature is not supported in the URL Analyzer.', OPSEO_TEXT_DOMAIN).'</p>';
			}

			echo '</div>';


			echo '<div id="misc-3" class="misc-tabs-panel">';

			// Hide if URL Analyzer
			if (false === strpos($pagenow, 'admin'))
			{
				// Check User Permissions
				if($this->copyscapeRolePermissions($this->options['copyscape_role']))
				{
					// Copyscape
					include(trailingslashit(OPSEO_PLUGIN_FULL_PATH).'onpageseo-admin-copyscape.php');
					$copyScape = new OnPageSEOCopyscape($this->options);

					if(isset($this->options['copyscape_username']) && (strlen(trim($this->options['copyscape_username'])) > 0) && isset($this->options['copyscape_api_key']) && (strlen(trim($this->options['copyscape_api_key'])) > 0))
					{
						// Check Balance
						$balance = $copyScape->copyscape_api_check_balance();

						// Error
						if(isset($balance['error']))
						{
							echo '<p style="font-weight:normal !important;margin:0 !important;padding:0 !important;">'.__('ERROR:', OPSEO_TEXT_DOMAIN).' '.$balance['error'].'</p>';
						}
						// No Credits
						elseif(!$balance['total'])
						{
							echo '<p style="font-weight:normal !important;margin:0 !important;padding:0 !important;">'.__('ERROR: You need to buy more Copyscape Premium credits.', OPSEO_TEXT_DOMAIN).'</p>';
						}
						// Available Credits
						else
						{
							echo '<div id="onpageseo-copyscape-balance" style="border: 0 !important;width:243px !important;margin:0 !important;padding:0 !important;"><p style="font-weight:normal !important;margin:0 !important;padding:0 !important;text-align:center !important;"><strong>'.__('Balance:', OPSEO_TEXT_DOMAIN).'</strong> $'.$balance['value'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>'.__('Credits:', OPSEO_TEXT_DOMAIN).'</strong> '.$balance['total'].'</p></div>';

							echo '<p style="width:100% !important;text-align:center !important;margin:10px 0 10px 0 !important;padding:0 !important;border:0 !important;"><input type="button" class="button" value="'.__('Check Copyscape', OPSEO_TEXT_DOMAIN).'" title="'.__('Check Copyscape', OPSEO_TEXT_DOMAIN).'" id="check-copyscape-scores" /></p>';


							echo '<div id="onpageseo-copyscape-loader" style="position:relative !important;width:243px !important;text-align:center !important;padding:5px 0 10px 0 !important;font-size:10px !important;font-weight:normal !important;border:0 !important;">'.__('Loading', OPSEO_TEXT_DOMAIN).'<br /><img src="'.OPSEO_PLUGIN_URL.'/images/ajax_spin.gif" alt="'.__('Loading', OPSEO_TEXT_DOMAIN).'" title="'.__('Loading', OPSEO_TEXT_DOMAIN).'" style="height:16px !important;width:16px !important;border:0 !important;padding-top:3px !important;" /></div>';

							// Saved Copyscape Results
							if(isset($_REQUEST['allcopyscaperesultstemp']) && (strlen(trim($_REQUEST['allcopyscaperesultstemp'])) > 0))
							{
								echo '<div id="onpageseo-copyscape-results" style="border: 0 !important;width:243px !important;margin:0 !important;padding:0 !important;">'.$_REQUEST['allcopyscaperesultstemp'].'</div>';
							}
							// No Saved Copyscape Results
							else
							{
								echo '<div id="onpageseo-copyscape-results" style="border: 0 !important;width:243px !important;margin:0 !important;padding:0 !important;display:none !important;"></div>';
							}

							echo '<textarea id="allcopyscaperesults" name="allcopyscaperesults" style="display:none !important;">'.$_REQUEST['allcopyscaperesultstemp'].'</textarea>';
							echo '<input type="hidden" id="updatedcopyscaperesults" name="updatedcopyscaperesults" value="0" />';
						}
					}
					else
					{
						echo '<p style="font-weight:normal !important;margin:0 !important;padding:0 !important;">'.__('Sorry, but you need to enter your Copyscape username and API key.', OPSEO_TEXT_DOMAIN).'</p>';
					}

					// Confirmation
					$opseoCopyscapeConfirm = (isset($this->options['copyscape_confirm'])) ? '1' : '0';
					echo '<input type="hidden" name="opseo-copyscape-confirm" id="opseo-copyscape-confirm" value="'.$opseoCopyscapeConfirm.'" />';


				}
				// Display Permissions Error
				else
				{
					echo '<p style="font-weight:normal !important;margin:0 !important;padding:0 !important;">'.__('Sorry, but your account does not have permission to access this feature.', OPSEO_TEXT_DOMAIN).'</p>';
				}

			}
			else
			{
				echo '<p style="font-weight:normal !important;margin:0 !important;padding:0 !important;">'.__('Sorry, but this feature is not supported in the URL Analyzer.', OPSEO_TEXT_DOMAIN).'</p>';
			}

			echo '</div>';


			echo '<div id="misc-4" class="misc-tabs-panel">';

				echo '<ol class="overflowol">';

				echo '<li><p>'.__('Multiple Keywords', OPSEO_TEXT_DOMAIN).' <a href="'.OPSEO_PLUGIN_URL.'/templates/admin-video.php?vidid=LvOyhNw6_rE&#038;TB_iframe=1" class="thickbox" title="'.__('Multiple Keywords', OPSEO_TEXT_DOMAIN).'"><img src="'.OPSEO_PLUGIN_URL.'/images/help.png" alt="'.__('Help', OPSEO_TEXT_DOMAIN).'" title="'.__('Help', OPSEO_TEXT_DOMAIN).'" /></a></p></li>';

				echo '<li><p>'.__('LSI Keywords', OPSEO_TEXT_DOMAIN).' <a href="'.OPSEO_PLUGIN_URL.'/templates/admin-video.php?vidid=mASB-CKF6Hw&#038;TB_iframe=1" class="thickbox" title="'.__('LSI Keywords', OPSEO_TEXT_DOMAIN).'"><img src="'.OPSEO_PLUGIN_URL.'/images/help.png" alt="'.__('Help', OPSEO_TEXT_DOMAIN).'" title="'.__('Help', OPSEO_TEXT_DOMAIN).'" /></a></p></li>';

				echo '<li><p>'.__('Readability', OPSEO_TEXT_DOMAIN).' <a href="'.OPSEO_PLUGIN_URL.'/templates/admin-video.php?vidid=eFVOLPOgPjI&#038;TB_iframe=1" class="thickbox" title="'.__('Readability', OPSEO_TEXT_DOMAIN).'"><img src="'.OPSEO_PLUGIN_URL.'/images/help.png" alt="'.__('Help', OPSEO_TEXT_DOMAIN).'" title="'.__('Help', OPSEO_TEXT_DOMAIN).'" /></a></p></li>';

				echo '<li><p>'.__('Title Tag', OPSEO_TEXT_DOMAIN).' <a href="'.OPSEO_PLUGIN_URL.'/templates/admin-video.php?vidid=Vi8NBTwu1b8&#038;TB_iframe=1" class="thickbox" title="'.__('Title Tag', OPSEO_TEXT_DOMAIN).'"><img src="'.OPSEO_PLUGIN_URL.'/images/help.png" alt="'.__('Help', OPSEO_TEXT_DOMAIN).'" title="'.__('Help', OPSEO_TEXT_DOMAIN).'" /></a></p></li>';

				echo '<li><p>'.__('Permalink', OPSEO_TEXT_DOMAIN).' <a href="'.OPSEO_PLUGIN_URL.'/templates/admin-video.php?vidid=QpONHRDwboA&#038;TB_iframe=1" class="thickbox" title="'.__('Permalink', OPSEO_TEXT_DOMAIN).'"><img src="'.OPSEO_PLUGIN_URL.'/images/help.png" alt="'.__('Help', OPSEO_TEXT_DOMAIN).'" title="'.__('Help', OPSEO_TEXT_DOMAIN).'" /></a></p></li>';

				echo '<li><p>'.__('Meta Tags', OPSEO_TEXT_DOMAIN).' <a href="'.OPSEO_PLUGIN_URL.'/templates/admin-video.php?vidid=MEdkvOrYzuM&#038;TB_iframe=1" class="thickbox" title="'.__('Meta Tags', OPSEO_TEXT_DOMAIN).'"><img src="'.OPSEO_PLUGIN_URL.'/images/help.png" alt="'.__('Help', OPSEO_TEXT_DOMAIN).'" title="'.__('Help', OPSEO_TEXT_DOMAIN).'" /></a></p></li>';

				echo '<li><p>'.__('H1 Tag', OPSEO_TEXT_DOMAIN).' <a href="'.OPSEO_PLUGIN_URL.'/templates/admin-video.php?vidid=2q3yHa64c3Y&#038;TB_iframe=1" class="thickbox" title="'.__('H1 Tag', OPSEO_TEXT_DOMAIN).'"><img src="'.OPSEO_PLUGIN_URL.'/images/help.png" alt="'.__('Help', OPSEO_TEXT_DOMAIN).'" title="'.__('Help', OPSEO_TEXT_DOMAIN).'" /></a></p></li>';

				echo '<li><p>'.__('H2 Tag', OPSEO_TEXT_DOMAIN).' <a href="'.OPSEO_PLUGIN_URL.'/templates/admin-video.php?vidid=zUMjLTFwqYo&#038;TB_iframe=1" class="thickbox" title="'.__('H2 Tag', OPSEO_TEXT_DOMAIN).'"><img src="'.OPSEO_PLUGIN_URL.'/images/help.png" alt="'.__('Help', OPSEO_TEXT_DOMAIN).'" title="'.__('Help', OPSEO_TEXT_DOMAIN).'" /></a></p></li>';

				echo '<li><p>'.__('H3 Tag', OPSEO_TEXT_DOMAIN).' <a href="'.OPSEO_PLUGIN_URL.'/templates/admin-video.php?vidid=9xXLw704Of4&#038;TB_iframe=1" class="thickbox" title="'.__('H3 Tag', OPSEO_TEXT_DOMAIN).'"><img src="'.OPSEO_PLUGIN_URL.'/images/help.png" alt="'.__('Help', OPSEO_TEXT_DOMAIN).'" title="'.__('Help', OPSEO_TEXT_DOMAIN).'" /></a></p></li>';

				echo '<li><p>'.__('Minimum Word Count', OPSEO_TEXT_DOMAIN).' <a href="'.OPSEO_PLUGIN_URL.'/templates/admin-video.php?vidid=O4l1HU7JMuE&#038;TB_iframe=1" class="thickbox" title="'.__('Minimum Word Count', OPSEO_TEXT_DOMAIN).'"><img src="'.OPSEO_PLUGIN_URL.'/images/help.png" alt="'.__('Help', OPSEO_TEXT_DOMAIN).'" title="'.__('Help', OPSEO_TEXT_DOMAIN).'" /></a></p></li>';

				echo '<li><p>'.__('Keyword Density', OPSEO_TEXT_DOMAIN).' <a href="'.OPSEO_PLUGIN_URL.'/templates/admin-video.php?vidid=uPGt8XIxDGc&#038;TB_iframe=1" class="thickbox" title="'.__('Keyword Density', OPSEO_TEXT_DOMAIN).'"><img src="'.OPSEO_PLUGIN_URL.'/images/help.png" alt="'.__('Help', OPSEO_TEXT_DOMAIN).'" title="'.__('Help', OPSEO_TEXT_DOMAIN).'" /></a></p></li>';

				echo '<li><p>'.__('Image ALT Attribute', OPSEO_TEXT_DOMAIN).' <a href="'.OPSEO_PLUGIN_URL.'/templates/admin-video.php?vidid=fOaqqomIOT4&#038;TB_iframe=1" class="thickbox" title="'.__('Image ALT Attribute', OPSEO_TEXT_DOMAIN).'"><img src="'.OPSEO_PLUGIN_URL.'/images/help.png" alt="'.__('Help', OPSEO_TEXT_DOMAIN).'" title="'.__('Help', OPSEO_TEXT_DOMAIN).'" /></a></p></li>';

				echo '<li><p>'.__('Automatic Decoration', OPSEO_TEXT_DOMAIN).' <a href="'.OPSEO_PLUGIN_URL.'/templates/admin-video.php?vidid=iSYxJeyyyIU&#038;TB_iframe=1" class="thickbox" title="'.__('Automatic Keyword Decoration', OPSEO_TEXT_DOMAIN).'"><img src="'.OPSEO_PLUGIN_URL.'/images/help.png" alt="'.__('Help', OPSEO_TEXT_DOMAIN).'" title="'.__('Help', OPSEO_TEXT_DOMAIN).'" /></a></p></li>';

				echo '<li><p>'.__('Internal Links', OPSEO_TEXT_DOMAIN).' <a href="'.OPSEO_PLUGIN_URL.'/templates/admin-video.php?vidid=GieCCQg7LJY&#038;TB_iframe=1" class="thickbox" title="'.__('Internal Links', OPSEO_TEXT_DOMAIN).'"><img src="'.OPSEO_PLUGIN_URL.'/images/help.png" alt="'.__('Help', OPSEO_TEXT_DOMAIN).'" title="'.__('Help', OPSEO_TEXT_DOMAIN).'" /></a></p></li>';

				echo '<li><p>'.__('External Links', OPSEO_TEXT_DOMAIN).' <a href="'.OPSEO_PLUGIN_URL.'/templates/admin-video.php?vidid=GieCCQg7LJY&#038;TB_iframe=1" class="thickbox" title="'.__('External Links', OPSEO_TEXT_DOMAIN).'"><img src="'.OPSEO_PLUGIN_URL.'/images/help.png" alt="'.__('Help', OPSEO_TEXT_DOMAIN).'" title="'.__('Help', OPSEO_TEXT_DOMAIN).'" /></a></p></li>';

				echo '<li><p>'.__('Keyword in First 50-100 Words', OPSEO_TEXT_DOMAIN).' <a href="'.OPSEO_PLUGIN_URL.'/templates/admin-video.php?vidid=QoHrf-fIue4&#038;TB_iframe=1" class="thickbox" title="'.__('Keyword in First 50-100 Words', OPSEO_TEXT_DOMAIN).'"><img src="'.OPSEO_PLUGIN_URL.'/images/help.png" alt="'.__('Help', OPSEO_TEXT_DOMAIN).'" title="'.__('Help', OPSEO_TEXT_DOMAIN).'" /></a></p></li>';

				echo '<li><p>'.__('Keyword in Last 50-100 Words', OPSEO_TEXT_DOMAIN).' <a href="'.OPSEO_PLUGIN_URL.'/templates/admin-video.php?vidid=QoHrf-fIue4&#038;TB_iframe=1" class="thickbox" title="'.__('Keyword in Last 50-100 Words', OPSEO_TEXT_DOMAIN).'"><img src="'.OPSEO_PLUGIN_URL.'/images/help.png" alt="'.__('Help', OPSEO_TEXT_DOMAIN).'" title="'.__('Help', OPSEO_TEXT_DOMAIN).'" /></a></p></li>';

				echo '</ol>';




			echo '</div>';





		echo '</div>';


?>