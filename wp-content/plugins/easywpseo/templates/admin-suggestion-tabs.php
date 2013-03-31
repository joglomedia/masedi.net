<?php
			global $pagenow;

			echo '<div id="suggestion-tabs">';

			echo '<ul>
					<li class="suggestiontabs" style="margin-bottom:0 !important;padding-bottom:0 !important;"><a href="#suggestion-1" style="font-weight:normal !important;">'.__('Title', OPSEO_TEXT_DOMAIN).'</a></li><li class="suggestiontabs" style="margin-bottom:0 !important;padding-bottom:0 !important;margin-left:2px !important;"><a href="#suggestion-2" style="font-weight:normal !important;">'.__('URL', OPSEO_TEXT_DOMAIN).'</a></li><li class="suggestiontabs" style="margin-bottom:0 !important;padding-bottom:0 !important;margin-left:2px !important;"><a href="#suggestion-3" style="font-weight:normal !important;">'.__('Meta', OPSEO_TEXT_DOMAIN).'</a></li><li class="suggestiontabs" style="margin-bottom:0 !important;padding-bottom:0 !important;margin-left:2px !important;"><a href="#suggestion-4" style="font-weight:normal !important;">'.__('Heading', OPSEO_TEXT_DOMAIN).'</a></li><li class="suggestiontabs" style="margin-bottom:0 !important;padding-bottom:0 !important;margin-left:2px !important;"><a href="#suggestion-5" style="font-weight:normal !important;">'.__('Content', OPSEO_TEXT_DOMAIN).'</a></li>
				</ul>';


			echo '<div id="suggestion-1" class="suggestion-tabs-panel">';
				$factorExists = 1;
				echo '<ol>';

				// Title contains keyword.
				if(isset($this->options['title_factor']))
				{
					echo '<li id="opseokeywordtitle" class="onpageseoscorelifalse"><p>'.__('Title contains keyword.', OPSEO_TEXT_DOMAIN).' <a href="'.OPSEO_PLUGIN_URL.'/templates/admin-video.php?vidid=Vi8NBTwu1b8&#038;TB_iframe=1" class="thickbox" title="'.__('Add Your Keyword to the Title', OPSEO_TEXT_DOMAIN).'"><img src="'.OPSEO_PLUGIN_URL.'/images/help.png" alt="'.__('Help', OPSEO_TEXT_DOMAIN).'" title="'.__('Help', OPSEO_TEXT_DOMAIN).'" /></a></p></li>';
					$factorExists = 0;
				}

				// Title begins with keyword.
				if(isset($this->options['title_beginning_factor']))
				{
					echo '<li id="opseokeywordtitlebeginning" class="onpageseoscorelifalse"><p>'.__('Title begins with keyword.', OPSEO_TEXT_DOMAIN).' <a href="'.OPSEO_PLUGIN_URL.'/templates/admin-video.php?vidid=Vi8NBTwu1b8&#038;TB_iframe=1" class="thickbox" title="'.__('Add Your Keyword to the Title', OPSEO_TEXT_DOMAIN).'"><img src="'.OPSEO_PLUGIN_URL.'/images/help.png" alt="'.__('Help', OPSEO_TEXT_DOMAIN).'" title="'.__('Help', OPSEO_TEXT_DOMAIN).'" /></a></p></li>';
					$factorExists = 0;
				}

				// Title contains at least # words.
				if(isset($this->options['title_words_factor']))
				{
					echo '<li id="opseotitlewords" class="onpageseoscorelifalse"><p>'.sprintf(__('Title contains at least %s words.', OPSEO_TEXT_DOMAIN), $this->options['title_length_minimum']).' <a href="'.OPSEO_PLUGIN_URL.'/templates/admin-video.php?vidid=Vi8NBTwu1b8&#038;TB_iframe=1" class="thickbox" title="'.__('Add Your Keyword to the Title', OPSEO_TEXT_DOMAIN).'"><img src="'.OPSEO_PLUGIN_URL.'/images/help.png" alt="'.__('Help', OPSEO_TEXT_DOMAIN).'" title="'.__('Help', OPSEO_TEXT_DOMAIN).'" /></a></p></li>';
					$factorExists = 0;
				}

				// Title contains at least # characters.
				if(isset($this->options['title_characters_factor']))
				{
					echo '<li id="opseotitlechars" class="onpageseoscorelifalse" style="margin-bottom:0 !important;padding-bottom:0 !important;"><p>'.sprintf(__('Title contains up to %s characters.', OPSEO_TEXT_DOMAIN), $this->options['title_length_maximum']).' <a href="'.OPSEO_PLUGIN_URL.'/templates/admin-video.php?vidid=Vi8NBTwu1b8&#038;TB_iframe=1" class="thickbox" title="'.__('Add Your Keyword to the Title', OPSEO_TEXT_DOMAIN).'"><img src="'.OPSEO_PLUGIN_URL.'/images/help.png" alt="'.__('Help', OPSEO_TEXT_DOMAIN).'" title="'.__('Help', OPSEO_TEXT_DOMAIN).'" /></a></p></li>';
					$factorExists = 0;
				}

				echo '</ol>';

				if($factorExists)
				{
					echo '<p style="font-weight:normal !important;margin:0 !important;padding:0 !important;">'.__('Sorry, but all of the "Title" factors are deactivated.', OPSEO_TEXT_DOMAIN).'</p>';
				}

			echo '</div>';

			echo '<div id="suggestion-2" class="suggestion-tabs-panel">';
				$factorExists = 1;
				echo '<ol>';

				// Permalink contains keyword.
				if(isset($this->options['url_factor']))
				{
					echo '<li id="opseopermalink" class="onpageseoscorelifalse" style="margin-bottom:0 !important;padding-bottom:0 !important;"><p>'.__('Permalink contains your keyword.', OPSEO_TEXT_DOMAIN).' <a href="'.OPSEO_PLUGIN_URL.'/templates/admin-video.php?vidid=QpONHRDwboA&#038;TB_iframe=1" class="thickbox" title="'.__('Add Your Keyword to the Permalink', OPSEO_TEXT_DOMAIN).'"><img src="'.OPSEO_PLUGIN_URL.'/images/help.png" alt="'.__('Help', OPSEO_TEXT_DOMAIN).'" title="'.__('Help', OPSEO_TEXT_DOMAIN).'" /></a></p></li>';
					$factorExists = 0;
				}

				echo '</ol>';

				if($factorExists)
				{
					echo '<p style="font-weight:normal !important;margin:0 !important;padding:0 !important;">'.__('Sorry, but all of the "URL" factors are deactivated.', OPSEO_TEXT_DOMAIN).'</p>';
				}

			echo '</div>';

			echo '<div id="suggestion-3" class="suggestion-tabs-panel">';
				$factorExists = 1;
				echo '<ol>';

				// Description meta tag contains keyword.
				if(isset($this->options['description_meta_factor']))
				{
					echo '<li id="opseodescriptionmetatag" class="onpageseoscorelifalse"><p>'.__('Description meta tag contains keyword.', OPSEO_TEXT_DOMAIN).' <a href="'.OPSEO_PLUGIN_URL.'/templates/admin-video.php?vidid=MEdkvOrYzuM&#038;TB_iframe=1" class="thickbox" title="'.__('Add Your Keyword to the Description Meta Tag', OPSEO_TEXT_DOMAIN).'"><img src="'.OPSEO_PLUGIN_URL.'/images/help.png" alt="'.__('Help', OPSEO_TEXT_DOMAIN).'" title="'.__('Help', OPSEO_TEXT_DOMAIN).'" /></a></p></li>';
					$factorExists = 0;
				}

				// Description meta tag contains up to # characters.
				if(isset($this->options['description_chars_meta_factor']))
				{
					echo '<li id="opseometataglength" class="onpageseoscorelifalse"><p>'.sprintf(__('Description meta tag contains up to %s characters.', OPSEO_TEXT_DOMAIN), $this->options['description_meta_tag_maximum']).' <a href="'.OPSEO_PLUGIN_URL.'/templates/admin-video.php?vidid=MEdkvOrYzuM&#038;TB_iframe=1" class="thickbox" title="'.__('Add Your Keyword to the Description Meta Tag', OPSEO_TEXT_DOMAIN).'"><img src="'.OPSEO_PLUGIN_URL.'/images/help.png" alt="'.__('Help', OPSEO_TEXT_DOMAIN).'" title="'.__('Help', OPSEO_TEXT_DOMAIN).'" /></a></p></li>';
					$factorExists = 0;
				}

				// Description meta tag begins with keyword.
				if(isset($this->options['description_beginning_meta_factor']))
				{
					echo '<li id="opseometatagbeginning" class="onpageseoscorelifalse"><p>'.__('Description meta tag begins with keyword.', OPSEO_TEXT_DOMAIN).' <a href="'.OPSEO_PLUGIN_URL.'/templates/admin-video.php?vidid=MEdkvOrYzuM&#038;TB_iframe=1" class="thickbox" title="'.__('Add Your Keyword to the Description Meta Tag', OPSEO_TEXT_DOMAIN).'"><img src="'.OPSEO_PLUGIN_URL.'/images/help.png" alt="'.__('Help', OPSEO_TEXT_DOMAIN).'" title="'.__('Help', OPSEO_TEXT_DOMAIN).'" /></a></p></li>';
					$factorExists = 0;
				}

				// Keywords meta tag contains keyword.
				if(isset($this->options['keywords_meta_factor']))
				{
					echo '<li id="opseokeywordsmetatag" class="onpageseoscorelifalse" style="margin-bottom:0 !important;padding-bottom:0 !important;"><p>'.__('Keywords meta tag contains keyword.', OPSEO_TEXT_DOMAIN).' <a href="'.OPSEO_PLUGIN_URL.'/templates/admin-video.php?vidid=MEdkvOrYzuM&#038;TB_iframe=1" class="thickbox" title="'.__('Add Your Keyword to the Keywords Meta Tag', OPSEO_TEXT_DOMAIN).'"><img src="'.OPSEO_PLUGIN_URL.'/images/help.png" alt="'.__('Help', OPSEO_TEXT_DOMAIN).'" title="'.__('Help', OPSEO_TEXT_DOMAIN).'" /></a></p></li>';
					$factorExists = 0;
				}

				echo '</ol>';

				if($factorExists)
				{
					echo '<p style="font-weight:normal !important;margin:0 !important;padding:0 !important;">'.__('Sorry, but all of the "Meta" factors are deactivated.', OPSEO_TEXT_DOMAIN).'</p>';
				}

			echo '</div>';

			echo '<div id="suggestion-4" class="suggestion-tabs-panel">';
				$factorExists = 1;
				echo '<ol>';

				// H1 tag contains keyword.
				if(isset($this->options['h1_factor']))
				{
					echo '<li id="opseoh1" class="onpageseoscorelifalse"><p>'.__('H1 tag contains your keyword.', OPSEO_TEXT_DOMAIN).' <a href="'.OPSEO_PLUGIN_URL.'/templates/admin-video.php?vidid=2q3yHa64c3Y&#038;TB_iframe=1" class="thickbox" title="'.__('Add Your Keyword to an H1 Tag', OPSEO_TEXT_DOMAIN).'"><img src="'.OPSEO_PLUGIN_URL.'/images/help.png" alt="'.__('Help', OPSEO_TEXT_DOMAIN).'" title="'.__('Help', OPSEO_TEXT_DOMAIN).'" /></a></p></li>';
					$factorExists = 0;
				}

				// H1 tag begins with keyword.
				if(isset($this->options['h1_beginning_factor']))
				{
					echo '<li id="opseoh1beginning" class="onpageseoscorelifalse"><p>'.__('H1 tag begins with keyword.', OPSEO_TEXT_DOMAIN).' <a href="'.OPSEO_PLUGIN_URL.'/templates/admin-video.php?vidid=2q3yHa64c3Y&#038;TB_iframe=1" class="thickbox" title="'.__('Add Your Keyword to an H1 Tag', OPSEO_TEXT_DOMAIN).'"><img src="'.OPSEO_PLUGIN_URL.'/images/help.png" alt="'.__('Help', OPSEO_TEXT_DOMAIN).'" title="'.__('Help', OPSEO_TEXT_DOMAIN).'" /></a></p></li>';
					$factorExists = 0;
				}

				// H2 tag contains keyword.
				if(isset($this->options['h2_factor']))
				{
					echo '<li id="opseoh2" class="onpageseoscorelifalse"><p>'.__('H2 tag contains your keyword.', OPSEO_TEXT_DOMAIN).' <a href="'.OPSEO_PLUGIN_URL.'/templates/admin-video.php?vidid=zUMjLTFwqYo&#038;TB_iframe=1" class="thickbox" title="'.__('Add Your Keyword to an H2 Tag', OPSEO_TEXT_DOMAIN).'"><img src="'.OPSEO_PLUGIN_URL.'/images/help.png" alt="'.__('Help', OPSEO_TEXT_DOMAIN).'" title="'.__('Help', OPSEO_TEXT_DOMAIN).'" /></a></p></li>';
					$factorExists = 0;
				}

				// H3 tag contains keyword.
				if(isset($this->options['h3_factor']))
				{
					echo '<li id="opseoh3" class="onpageseoscorelifalse"><p>'.__('H3 tag contains your keyword.', OPSEO_TEXT_DOMAIN).' <a href="'.OPSEO_PLUGIN_URL.'/templates/admin-video.php?vidid=9xXLw704Of4&#038;TB_iframe=1" class="thickbox" title="'.__('Add Your Keyword to an H3 Tag', OPSEO_TEXT_DOMAIN).'"><img src="'.OPSEO_PLUGIN_URL.'/images/help.png" alt="'.__('Help', OPSEO_TEXT_DOMAIN).'" title="'.__('Help', OPSEO_TEXT_DOMAIN).'" /></a></p></li>';
					$factorExists = 0;
				}

				echo '</ol>';

				if($factorExists)
				{
					echo '<p style="font-weight:normal !important;margin:0 !important;padding:0 !important;">'.__('Sorry, but all of the "Heading" factors are deactivated.', OPSEO_TEXT_DOMAIN).'</p>';
				}

			echo '</div>';


			echo '<div id="suggestion-5" class="suggestion-tabs-panel">';
				$factorExists = 1;
				echo '<ol>';

				// Content contains at least # words.
				if(isset($this->options['content_words_factor']))
				{
					echo '<li id="opseopostwords" class="onpageseoscorelifalse"><p>'.sprintf(__('Content contains at least %s words.', OPSEO_TEXT_DOMAIN), $this->options['post_content_length']).' <a href="'.OPSEO_PLUGIN_URL.'/templates/admin-video.php?vidid=O4l1HU7JMuE&#038;TB_iframe=1" class="thickbox" title="'.__('Add the Minimum Words to Your Content', OPSEO_TEXT_DOMAIN).'"><img src="'.OPSEO_PLUGIN_URL.'/images/help.png" alt="'.__('Help', OPSEO_TEXT_DOMAIN).'" title="'.__('Help', OPSEO_TEXT_DOMAIN).'" /></a></p></li>';
					$factorExists = 0;
				}

				// Content has #-#% keyword density.
				if(isset($this->options['content_kw_density_factor']))
				{
					echo '<li id="opseokeyworddensity" class="onpageseoscorelifalse"><p>'.sprintf(__('Content has %s-%s%% keyword density.', OPSEO_TEXT_DOMAIN), $this->options['keyword_density_minimum'], $this->options['keyword_density_maximum']).' <a href="'.OPSEO_PLUGIN_URL.'/templates/admin-video.php?vidid=uPGt8XIxDGc&#038;TB_iframe=1" class="thickbox" title="'.__('Manage Your Keyword Densities', OPSEO_TEXT_DOMAIN).'"><img src="'.OPSEO_PLUGIN_URL.'/images/help.png" alt="'.__('Help', OPSEO_TEXT_DOMAIN).'" title="'.__('Help', OPSEO_TEXT_DOMAIN).'" /></a></p></li>';
					$factorExists = 0;
				}

				// Content contains keyword in first 50-100 words.
				if(isset($this->options['content_first_factor']))
				{
					echo '<li id="opseofirst100words" class="onpageseoscorelifalse"><p>'.__('Content contains keyword in the first 50-100 words.', OPSEO_TEXT_DOMAIN).' <a href="'.OPSEO_PLUGIN_URL.'/templates/admin-video.php?vidid=QoHrf-fIue4&#038;TB_iframe=1" class="thickbox" title="'.__('Add Your Keyword to the First 50-100 Words', OPSEO_TEXT_DOMAIN).'"><img src="'.OPSEO_PLUGIN_URL.'/images/help.png" alt="'.__('Help', OPSEO_TEXT_DOMAIN).'" title="'.__('Help', OPSEO_TEXT_DOMAIN).'" /></a></p></li>';
					$factorExists = 0;
				}

				// Content contains contains at least one image with keyword in ALT attribute.
				if(isset($this->options['content_alt_factor']))
				{
					echo '<li id="opseoimagealt" class="onpageseoscorelifalse"><p>'.__('Content contains at least one image with keyword in ALT attribute.', OPSEO_TEXT_DOMAIN).' <a href="'.OPSEO_PLUGIN_URL.'/templates/admin-video.php?vidid=fOaqqomIOT4&#038;TB_iframe=1" class="thickbox" title="'.__('Insert Your Keyword Into an Image ALT Attribute', OPSEO_TEXT_DOMAIN).'"><img src="'.OPSEO_PLUGIN_URL.'/images/help.png" alt="'.__('Help', OPSEO_TEXT_DOMAIN).'" title="'.__('Help', OPSEO_TEXT_DOMAIN).'" /></a></p></li>';
					$factorExists = 0;
				}

				// Content contains at least one bold keyword.
				if(isset($this->options['content_bold_factor']))
				{
					echo '<li id="opseobold" class="onpageseoscorelifalse"><p>'.__('Content contains at least one bold keyword.', OPSEO_TEXT_DOMAIN).' <a href="'.OPSEO_PLUGIN_URL.'/templates/admin-video.php?vidid=iSYxJeyyyIU&#038;TB_iframe=1" class="thickbox" title="'.__('Bold at Least One Keyword', OPSEO_TEXT_DOMAIN).'"><img src="'.OPSEO_PLUGIN_URL.'/images/help.png" alt="'.__('Help', OPSEO_TEXT_DOMAIN).'" title="'.__('Help', OPSEO_TEXT_DOMAIN).'" /></a></p></li>';
					$factorExists = 0;
				}

				// Content contains at least one italicized keyword.
				if(isset($this->options['content_italic_factor']))
				{
					echo '<li id="opseoitalic" class="onpageseoscorelifalse"><p>'.__('Content contains at least one italicized keyword.', OPSEO_TEXT_DOMAIN).' <a href="'.OPSEO_PLUGIN_URL.'/templates/admin-video.php?vidid=iSYxJeyyyIU&#038;TB_iframe=1" class="thickbox" title="'.__('Italicize at Least One Keyword', OPSEO_TEXT_DOMAIN).'"><img src="'.OPSEO_PLUGIN_URL.'/images/help.png" alt="'.__('Help', OPSEO_TEXT_DOMAIN).'" title="'.__('Help', OPSEO_TEXT_DOMAIN).'" /></a></p></li>';
					$factorExists = 0;
				}

				// Content contains at least one underlined keyword.
				if(isset($this->options['content_underline_factor']))
				{
					echo '<li id="opseounderline" class="onpageseoscorelifalse"><p>'.__('Content contains at least one underlined keyword.', OPSEO_TEXT_DOMAIN).' <a href="'.OPSEO_PLUGIN_URL.'/templates/admin-video.php?vidid=iSYxJeyyyIU&#038;TB_iframe=1" class="thickbox" title="'.__('Underline at Least One Keyword', OPSEO_TEXT_DOMAIN).'"><img src="'.OPSEO_PLUGIN_URL.'/images/help.png" alt="'.__('Help', OPSEO_TEXT_DOMAIN).'" title="'.__('Help', OPSEO_TEXT_DOMAIN).'" /></a></p></li>';
					$factorExists = 0;
				}

				// Content contains keyword in anchor text of at least one external link.
				if(isset($this->options['content_external_link_factor']))
				{
					echo '<li id="opseoexternalanchortext" class="onpageseoscorelifalse"><p>'.__('Content contains keyword in anchor text of at least one external link.', OPSEO_TEXT_DOMAIN).' <a href="'.OPSEO_PLUGIN_URL.'/templates/admin-video.php?vidid=GieCCQg7LJY&#038;TB_iframe=1" class="thickbox" title="'.__('Add Your Keyword as External Link Anchor Text', OPSEO_TEXT_DOMAIN).'"><img src="'.OPSEO_PLUGIN_URL.'/images/help.png" alt="'.__('Help', OPSEO_TEXT_DOMAIN).'" title="'.__('Help', OPSEO_TEXT_DOMAIN).'" /></a></p></li>';
					$factorExists = 0;
				}

				// Content contains keyword in anchor text of at least one internal link.
				if(isset($this->options['content_internal_link_factor']))
				{
					echo '<li id="opseointernalanchortext" class="onpageseoscorelifalse"><p>'.__('Content contains keyword in anchor text of at least one internal link.', OPSEO_TEXT_DOMAIN).' <a href="'.OPSEO_PLUGIN_URL.'/templates/admin-video.php?vidid=GieCCQg7LJY&#038;TB_iframe=1" class="thickbox" title="'.__('Add Your Keyword as Internal Link Anchor Text', OPSEO_TEXT_DOMAIN).'"><img src="'.OPSEO_PLUGIN_URL.'/images/help.png" alt="'.__('Help', OPSEO_TEXT_DOMAIN).'" title="'.__('Help', OPSEO_TEXT_DOMAIN).'" /></a></p></li>';
					$factorExists = 0;
				}

				// Content contains keyword in last 50-100 words.
				if(isset($this->options['content_last_factor']))
				{
					echo '<li id="opseolast100words" class="onpageseoscorelifalse"><p>'.__('Content contains keyword in the last 50-100 words.', OPSEO_TEXT_DOMAIN).' <a href="'.OPSEO_PLUGIN_URL.'/templates/admin-video.php?vidid=QoHrf-fIue4&#038;TB_iframe=1" class="thickbox" title="'.__('Add Your Keyword to the Last 50-100 Words', OPSEO_TEXT_DOMAIN).'"><img src="'.OPSEO_PLUGIN_URL.'/images/help.png" alt="'.__('Help', OPSEO_TEXT_DOMAIN).'" title="'.__('Help', OPSEO_TEXT_DOMAIN).'" /></a></p></li>';
					$factorExists = 0;
				}

				echo '</ol>';

				if($factorExists)
				{
					echo '<p style="font-weight:normal !important;margin:0 !important;padding:0 !important;">'.__('Sorry, but all of the "Content" factors are deactivated.', OPSEO_TEXT_DOMAIN).'</p>';
				}

			echo '</div>';

			echo '</div>';

			if(!empty($this->postMeta) && is_array($this->postMeta) && isset($this->postMeta['onpageseo_global_settings']))
			{
				echo '<div style="width:100% !important;text-align:center !important;margin:10px 0 0 0 !important;padding:0 !important;"><input type="button" class="button" value="'.__('Display SEO Report', OPSEO_TEXT_DOMAIN).'" title="'.__('Display SEO Report', OPSEO_TEXT_DOMAIN).'" id="display-seo-report-button" /></div>';

				echo '<div style="width:100% !important;text-align:center !important;margin:10px 0 0 0 !important;padding:0 !important;display:none !important;"><a class="button thickbox" title="'.__('Display SEO Report', OPSEO_TEXT_DOMAIN).'" id="display-seo-report" href="#?TB_inline=1&#038;inlineId=myOnPageContent&width=640&height=1024" onclick="return false;" style="font-weight:normal !important;"><strong>'.__('Display SEO Report', OPSEO_TEXT_DOMAIN).'</strong></a></div>';

				echo '<div id="onpageseoreportloader" style="position:relative !important;width:243px !important;text-align:center !important;padding:5px 0 10px 0 !important;font-size:10px !important;">'.__('Generating', OPSEO_TEXT_DOMAIN).'<br /><img src="'.OPSEO_PLUGIN_URL.'/images/ajax_spin.gif" alt="'.__('Loading', OPSEO_TEXT_DOMAIN).'" title="'.__('Loading', OPSEO_TEXT_DOMAIN).'" style="height:16px !important;width:16px !important;border:0 !important;padding-top:3px !important;" /></div>';

				echo '<input type="hidden" id="onpageseo-analyze-url" name="onpageseo-analyze-url" value="" />';

				// URL Analyzer
				if(false !== strpos($pagenow, 'admin'))
				{ 
					echo '<input type="hidden" id="onpageseo-post-id" name="onpageseo-post-id" value="'.$_REQUEST['id'].'" />';
					echo '<input type="hidden" id="onpageseo-analyze-type" name="onpageseo-analyze-type" value="2" />';
				}
				// Post or Page
				else
				{
					echo '<input type="hidden" id="onpageseo-post-id" name="onpageseo-post-id" value="'.$this->postID.'" />';
					echo '<input type="hidden" id="onpageseo-analyze-type" name="onpageseo-analyze-type" value="1" />';
				}


				echo '<div id="myOnPageContent" style="display:none;"></div>';
			}
?>
