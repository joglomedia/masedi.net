		<?php $this->adminHeader('onpageseo-settings', __('Settings', OPSEO_TEXT_DOMAIN)); ?>

		<form action="options.php" method="post">
		<?php settings_fields('onpageseo_settings');?>

		<div id="opseo-tabs" class="inside">
			<ul>
				<li class="opseotabs"><a href="#opseo-style" style="margin:0 !important;"><?php _e('Automatic Decoration', OPSEO_TEXT_DOMAIN);?></a></li>
				<li class="opseotabs"><a href="#opseo-misc"><?php _e('Miscellaneous Settings', OPSEO_TEXT_DOMAIN);?></a></li>
				<li class="opseotabs"><a href="#opseo-keyword"><?php _e('Keyword Settings', OPSEO_TEXT_DOMAIN);?></a></li>
				<li class="opseotabs"><a href="#opseo-password-protection"><?php _e('Password Protection', OPSEO_TEXT_DOMAIN);?></a></li>
				<li class="opseotabs"><a href="#opseo-copyscape"><?php _e('Copyscape Settings', OPSEO_TEXT_DOMAIN);?></a></li>
				<li class="opseotabs"<?php if($this->licenseHide){ echo ' style="display:none;"';}?>><a href="#opseo-license"><?php _e('License Settings', OPSEO_TEXT_DOMAIN);?></a></li>
			</ul>

			<div id="opseo-style" class="opseo-tabs-panel">

				<p><?php _e('Here are the settings if you want to automatically decorate your primary keywords with bold, italic, or underline styling; insert your primary keywords into the ALT attribute of images; or add rel="nofollow" attributes to links', OPSEO_TEXT_DOMAIN);?>:</p>



				<h4 style="padding:10px 0 5px 0 !important;margin:15px 0 10px 0 !important;border-bottom:1px solid rgb(200,200,200);"><?php _e('Recommended Settings', OPSEO_TEXT_DOMAIN);?></h4>

				<table class="form-table">

				<tr valign="top" style="background-color:rgb(238,238,238);">
				<td><p><?php _e('Click the button to automatically select the recommended settings for your site.');?></p>

				<input type="button" name="opseo-recommended-settings" id="opseo-recommended-settings" value="Recommended Settings" class="button" /></td>

				</tr>

				</table>


				<h4 style="padding:10px 0 5px 0 !important;margin:15px 0 10px 0 !important;border-bottom:1px solid rgb(200,200,200);"><?php _e('Automatic Decorations', OPSEO_TEXT_DOMAIN);?></h4>

				<table class="form-table">

				<tr valign="top">
				<th scope="row"><label for="onpageseo_options[decoration_type]"><?php _e('Decoration Type', OPSEO_TEXT_DOMAIN);?></label><br /><span style="font-size:12px;"><em><?php _e('Method To Decorate Content', OPSEO_TEXT_DOMAIN);?></em></span></th>
				<td><select name="onpageseo_options[decoration_type]" id="onpageseo_options_decoration_type">

					<option value="" label="<?php _e('Turned Off', OPSEO_TEXT_DOMAIN);?>"<?php selected($this->options['decoration_type'], "");?>><?php _e('Turned Off', OPSEO_TEXT_DOMAIN);?></option>
					<option value="client" label="<?php _e('Client-Side', OPSEO_TEXT_DOMAIN);?>"<?php selected($this->options['decoration_type'], "client");?>><?php _e('Client-Side', OPSEO_TEXT_DOMAIN);?></option>
					<option value="admin" label="<?php _e('Admin-Side', OPSEO_TEXT_DOMAIN);?>"<?php selected($this->options['decoration_type'], "admin");?>><?php _e('Admin-Side', OPSEO_TEXT_DOMAIN);?></option>

					</select></td>

				</tr>

				</table>


				<h4 style="padding:10px 0 5px 0 !important;margin:15px 0 10px 0 !important;border-bottom:1px solid rgb(200,200,200);"><?php _e('Keyword Decorations', OPSEO_TEXT_DOMAIN);?></h4>

				<table class="form-table">

				<tr valign="top" style="background-color:rgb(238,238,238);">
				<th scope="row"><label for="onpageseo_options[bold_keyword]"><?php _e('Bold Keyword', OPSEO_TEXT_DOMAIN);?> </label></th>
				<td><input type="checkbox" name="onpageseo_options[bold_keyword]" value="1"<?php checked($this->options['bold_keyword'], 1);?> /> <label for="onpageseo_options[bold_keyword]"><?php _e('Automatically <strong>bold</strong> the keyword.', OPSEO_TEXT_DOMAIN);?></label></td>
				</tr>

				<tr valign="top" style="background-color:rgb(238,238,238);">

				<th scope="row"><label for="b"><?php _e('Bold Style', OPSEO_TEXT_DOMAIN);?></label></th>
				<td>

					<input type="radio" name="onpageseo_options[bold_style]" value="b"<?php checked($this->options['bold_style'], 'b');?> /> <label title="b">&lt;b&gt;...&lt;/b&gt;</label><br />
					<input type="radio" name="onpageseo_options[bold_style]" value="strong"<?php checked($this->options['bold_style'], 'strong');?> /> <label title="strong">&lt;strong&gt;...&lt;/strong&gt;</label><br />
					<input type="radio" name="onpageseo_options[bold_style]" value="fontweightbold"<?php checked($this->options['bold_style'], 'fontweightbold');?> /> <label title="fontweightbold">&lt;span style="font-weight:bold;"&gt;...&lt;/span&gt;</label>
				</td>
				</tr>

				<tr valign="top">
				<th scope="row"><label for="onpageseo_options[italic_keyword]"><?php _e('Italicize Keyword', OPSEO_TEXT_DOMAIN);?> </label></th>
				<td><input type="checkbox" name="onpageseo_options[italic_keyword]" value="1"<?php checked($this->options['italic_keyword'], 1);?> /> <label for="onpageseo_options[italic_keyword]"><?php _e('Automatically <em>italicize</em> the keyword', OPSEO_TEXT_DOMAIN);?></label></td>

				</tr>

				<tr valign="top">
				<th scope="row"><label for="onpageseo_options[italic_style]"><?php _e('Italic Style', OPSEO_TEXT_DOMAIN);?></label></th>
				<td>
					<input type="radio" name="onpageseo_options[italic_style]" value="i"<?php checked($this->options['italic_style'], 'i');?> /> <label title="i">&lt;i&gt;...&lt;/i&gt;</label><br />
					<input type="radio" name="onpageseo_options[italic_style]" value="em"<?php checked($this->options['italic_style'], 'em');?> /> <label title="em">&lt;em&gt;...&lt;/em&gt;</label><br />
					<input type="radio" name="onpageseo_options[italic_style]" value="fontstyleitalic"<?php checked($this->options['italic_style'], 'fontstyleitalic');?> /> <label title="fontstyleitalic">&lt;span style="font-style:italic;"&gt;...&lt;/span&gt;</label>
				</td>
				</tr>


				<tr valign="top" style="background-color:rgb(238,238,238);">
				<th scope="row"><label for="onpageseo_options[underline_keyword]"><?php _e('Underline Keyword', OPSEO_TEXT_DOMAIN);?> </label></th>
				<td><input type="checkbox" name="onpageseo_options[underline_keyword]" value="1"<?php checked($this->options['underline_keyword'], 1);?> /> <label for="onpageseo_options[underline_keyword]"><?php _e('Automatically <u>underline</u> the keyword', OPSEO_TEXT_DOMAIN);?></label></td>

				</tr>

				<tr valign="top" style="background-color:rgb(238,238,238);">
				<th scope="row"><label for="onpageseo_options[underline_style]"><?php _e('Underline Style', OPSEO_TEXT_DOMAIN);?></label></th>
				<td>
					<input type="radio" name="onpageseo_options[underline_style]" value="u"<?php checked($this->options['underline_style'], 'u');?> /> <label title="u">&lt;u&gt;...&lt;/u&gt;</label><br />
					<input type="radio" name="onpageseo_options[underline_style]" value="fontdecorationunderline"<?php checked($this->options['underline_style'], 'fontdecorationunderline');?> /> <label title="fontdecorationunderline">&lt;span style="text-decoration:underline;"&gt;...&lt;/span&gt;</label>
				</td>
				</tr>

				</table>


				<h4 style="padding:10px 0 5px 0 !important;margin:15px 0 10px 0 !important;border-bottom:1px solid rgb(200,200,200);"><?php _e('Images', OPSEO_TEXT_DOMAIN);?></h4>

				<table class="form-table">

				<tr valign="top">
				<th scope="row"><label for="onpageseo_options[image_alt]"><?php _e('Image ALT Attribute', OPSEO_TEXT_DOMAIN);?></label></th>
				<td><input type="checkbox" name="onpageseo_options[image_alt]" value="1"<?php checked($this->options['image_alt'], 1);?> /> <label for="onpageseo_options[image_alt]"><?php _e('Automatically add keyword to image ALT attribute', OPSEO_TEXT_DOMAIN);?></label></td>
				</tr>

				</table>

				<h4 style="padding:10px 0 5px 0 !important;margin:15px 0 10px 0 !important;border-bottom:1px solid rgb(200,200,200);"><?php _e('Links', OPSEO_TEXT_DOMAIN);?></h4>

				<table class="form-table">

				<tr valign="top" style="background-color:rgb(238,238,238);">
				<th scope="row"><label for="onpageseo_options[no_follow]"><?php _e('No Follow', OPSEO_TEXT_DOMAIN);?></label></th>
				<td><input type="checkbox" name="onpageseo_options[no_follow]" value="1"<?php checked($this->options['no_follow'], 1);?> /> <label for="onpageseo_options[no_follow]"><?php _e('Automatically add <code>rel="nofollow"</code> to external links', OPSEO_TEXT_DOMAIN);?></label></td>
				</tr>


				<tr valign="top">
				<th scope="row"><label for="onpageseo_options[no_follow]"><?php _e('No Follow (White List URLs)', OPSEO_TEXT_DOMAIN);?></label><br /><span style="font-size:12px;"><em><?php _e('These Links Will Not Receive No Follow', OPSEO_TEXT_DOMAIN);?></em></span></th>
				<td><textarea name="onpageseo_options[no_follow_white_list]" id="onpageseo_options[no_follow_white_list]" rows="8" cols="70"><?php echo $this->options['no_follow_white_list'];?></textarea></td>
				</tr>


				<tr valign="top" style="background-color:rgb(238,238,238);">
				<th scope="row"><label for="onpageseo_options[link_target]"><?php _e('Open External Links In New Browser Window', OPSEO_TEXT_DOMAIN);?></label></th>
				<td><input type="checkbox" name="onpageseo_options[link_target]" value="1"<?php checked($this->options['link_target'], 1);?> /> <label for="onpageseo_options[link_target]"><?php _e('Automatically add <code>target="_blank"</code> to external links', OPSEO_TEXT_DOMAIN);?> <i>(<?php _e('so URL opens in new browser window', OPSEO_TEXT_DOMAIN);?>)</i></label></td>
				</tr>

				</table>

			</div>

			<div id="opseo-misc" class="opseo-tabs-panel">
			
				<p><?php _e('Here is how to change some of the default values that affect the calculation of the on-page SEO score for posts and pages; and determine how many posts appear on the "Manage Keywords" screen, how many posts or pages appear on the "Internal Links" section and images appear on the "Images" section under the Misc tab on the Post/Page Editor screen metabox', OPSEO_TEXT_DOMAIN);?>:</p>

				<h4 style="padding:10px 0 5px 0 !important;margin:15px 0 10px 0 !important;border-bottom:1px solid rgb(200,200,200);"><?php _e('On-Page SEO Factors', OPSEO_TEXT_DOMAIN);?></h4>

				<table class="form-table">

				<tr valign="top" style="background-color:rgb(238,238,238);">
				<th scope="row"><label for="onpageseo_options[title_factor]"><?php _e('Title Tag', OPSEO_TEXT_DOMAIN);?></label></th>
				<td><input type="checkbox" name="onpageseo_options[title_factor]" value="1"<?php checked($this->options['title_factor'], 1);?> /> <label for="onpageseo_options[title_factor]"><?php _e('Title contains keyword.', OPSEO_TEXT_DOMAIN);?></label><br />
				<input type="checkbox" name="onpageseo_options[title_beginning_factor]" value="1"<?php checked($this->options['title_beginning_factor'], 1);?> /> <label for="onpageseo_options[title_beginning_factor]"><?php _e('Title begins with keyword.', OPSEO_TEXT_DOMAIN);?></label><br />
				<input type="checkbox" name="onpageseo_options[title_words_factor]" value="1"<?php checked($this->options['title_words_factor'], 1);?> /> <label for="onpageseo_options[title_words_factor]"><?php printf(__('Title contains at least %s words.', OPSEO_TEXT_DOMAIN), $this->options['title_length_minimum']);?></label><br />
				<input type="checkbox" name="onpageseo_options[title_characters_factor]" value="1"<?php checked($this->options['title_characters_factor'], 1);?> /> <label for="onpageseo_options[title_characters_factor]"><?php printf(__('Title contains up to %d characters.', OPSEO_TEXT_DOMAIN), $this->options['title_length_maximum']);?></label></td>
				</tr>

				<tr valign="top">
				<th scope="row"><label for="onpageseo_options[url_factor]"><?php _e('URL', OPSEO_TEXT_DOMAIN);?></label></th>
				<td><input type="checkbox" name="onpageseo_options[url_factor]" value="1"<?php checked($this->options['url_factor'], 1);?> /> <label for="onpageseo_options[url_factor]"><?php _e('Permalink contains your keyword.', OPSEO_TEXT_DOMAIN);?></label></td>
				</tr>

				<tr valign="top" style="background-color:rgb(238,238,238);">
				<th scope="row"><label for="onpageseo_options[description_meta_factor]"><?php _e('Meta Tags', OPSEO_TEXT_DOMAIN);?></label></th>
				<td><input type="checkbox" name="onpageseo_options[description_meta_factor]" value="1"<?php checked($this->options['description_meta_factor'], 1);?> /> <label for="onpageseo_options[description_meta_factor]"><?php _e('Description meta tag contains keyword.', OPSEO_TEXT_DOMAIN);?></label><br />
				<input type="checkbox" name="onpageseo_options[description_chars_meta_factor]" value="1"<?php checked($this->options['description_chars_meta_factor'], 1);?> /> <label for="onpageseo_options[description_chars_meta_factor]"><?php printf(__('Description meta tag contains up to %d characters.', OPSEO_TEXT_DOMAIN), $this->options['description_meta_tag_maximum']);?></label><br />
				<input type="checkbox" name="onpageseo_options[description_beginning_meta_factor]" value="1"<?php checked($this->options['description_beginning_meta_factor'], 1);?> /> <label for="onpageseo_options[description_beginning_meta_factor]"><?php _e('Description meta tag begins with keyword.', OPSEO_TEXT_DOMAIN);?></label><br />
				<input type="checkbox" name="onpageseo_options[keywords_meta_factor]" value="1"<?php checked($this->options['keywords_meta_factor'], 1);?> /> <label for="onpageseo_options[keywords_meta_factor]"><?php _e('Keywords meta tag contains keyword.', OPSEO_TEXT_DOMAIN);?></label></td>
				</tr>

				<tr valign="top">
				<th scope="row"><label for="onpageseo_options[h1_factor]"><?php _e('Heading Tags', OPSEO_TEXT_DOMAIN);?></label></th>
				<td><input type="checkbox" name="onpageseo_options[h1_factor]" value="1"<?php checked($this->options['h1_factor'], 1);?> /> <label for="onpageseo_options[h1_factor]"><?php _e('H1 tag contains keyword.', OPSEO_TEXT_DOMAIN);?></label><br />
				<input type="checkbox" name="onpageseo_options[h1_beginning_factor]" value="1"<?php checked($this->options['h1_beginning_factor'], 1);?> /> <label for="onpageseo_options[h1_beginning_factor]"><?php _e('H1 tag begins with keyword.', OPSEO_TEXT_DOMAIN);?></label><br />
				<input type="checkbox" name="onpageseo_options[h2_factor]" value="1"<?php checked($this->options['h2_factor'], 1);?> /> <label for="onpageseo_options[h2_factor]"><?php _e('H2 tag contains keyword.', OPSEO_TEXT_DOMAIN);?></label><br />
				<input type="checkbox" name="onpageseo_options[h3_factor]" value="1"<?php checked($this->options['h3_factor'], 1);?> /> <label for="onpageseo_options[h3_factor]"><?php _e('H3 tag contains keyword.', OPSEO_TEXT_DOMAIN);?></label></td>
				</tr>


				<tr valign="top" style="background-color:rgb(238,238,238);">
				<th scope="row"><label for="onpageseo_options[content_words_factor]"><?php _e('Content', OPSEO_TEXT_DOMAIN);?></label></th>
				<td><input type="checkbox" name="onpageseo_options[content_words_factor]" value="1"<?php checked($this->options['content_words_factor'], 1);?> /> <label for="onpageseo_options[content_words_factor]"><?php printf(__('Content contains at least %d words.', OPSEO_TEXT_DOMAIN), $this->options['post_content_length']);?></label><br />
				<input type="checkbox" name="onpageseo_options[content_kw_density_factor]" value="1"<?php checked($this->options['content_kw_density_factor'], 1);?> /> <label for="onpageseo_options[content_kw_density_factor]"><?php printf(__('Content has %s-%s%% keyword density.', OPSEO_TEXT_DOMAIN), $this->options['keyword_density_minimum'], $this->options['keyword_density_maximum']);?></label><br />
				<input type="checkbox" name="onpageseo_options[content_first_factor]" value="1"<?php checked($this->options['content_first_factor'], 1);?> /> <label for="onpageseo_options[content_first_factor]"><?php _e('Content contains keyword in the first 50-100 words.', OPSEO_TEXT_DOMAIN);?></label><br />
				<input type="checkbox" name="onpageseo_options[content_alt_factor]" value="1"<?php checked($this->options['content_alt_factor'], 1);?> /> <label for="onpageseo_options[content_alt_factor]"><?php _e('Content contains at least one image with keyword in ALT attribute.', OPSEO_TEXT_DOMAIN);?></label><br />
				<input type="checkbox" name="onpageseo_options[content_bold_factor]" value="1"<?php checked($this->options['content_bold_factor'], 1);?> /> <label for="onpageseo_options[content_bold_factor]"><?php _e('Content contains at least one bold keyword.', OPSEO_TEXT_DOMAIN);?></label><br />
				<input type="checkbox" name="onpageseo_options[content_italic_factor]" value="1"<?php checked($this->options['content_italic_factor'], 1);?> /> <label for="onpageseo_options[content_italic_factor]"><?php _e('Content contains at least one italicized keyword.', OPSEO_TEXT_DOMAIN);?></label><br />
				<input type="checkbox" name="onpageseo_options[content_underline_factor]" value="1"<?php checked($this->options['content_underline_factor'], 1);?> /> <label for="onpageseo_options[content_underline_factor]"><?php _e('Content contains at least one underlined keyword.', OPSEO_TEXT_DOMAIN);?></label><br />
				<input type="checkbox" name="onpageseo_options[content_external_link_factor]" value="1"<?php checked($this->options['content_external_link_factor'], 1);?> /> <label for="onpageseo_options[content_external_link_factor]"><?php _e('Content contains keyword in anchor text of at least one external link.', OPSEO_TEXT_DOMAIN);?></label><br />
				<input type="checkbox" name="onpageseo_options[content_internal_link_factor]" value="1"<?php checked($this->options['content_internal_link_factor'], 1);?> /> <label for="onpageseo_options[content_internal_link_factor]"><?php _e('Content contains keyword in anchor text of at least one internal link.', OPSEO_TEXT_DOMAIN);?></label><br />
				<input type="checkbox" name="onpageseo_options[content_last_factor]" value="1"<?php checked($this->options['content_last_factor'], 1);?> /> <label for="onpageseo_options[content_last_factor]"><?php _e('Content contains keyword in the last 50-100 words.', OPSEO_TEXT_DOMAIN);?></label>
				<input type="hidden" name="onpageseo_options[factor_update]" value="1" /></td>
				</tr>

				</table>




				<h4 style="padding:10px 0 5px 0 !important;margin:15px 0 10px 0 !important;border-bottom:1px solid rgb(200,200,200);"><?php _e('Score Settings', OPSEO_TEXT_DOMAIN);?></h4>

				<table class="form-table">


				<tr valign="top">
				<th scope="row"><label for="onpageseo_options[keyword_density_minimum]"><?php _e('Keyword Density', OPSEO_TEXT_DOMAIN);?></label><br /><span style="font-size:12px;"><em><?php _e('Minimum Score', OPSEO_TEXT_DOMAIN);?></em></span></th>
				<td><input name="onpageseo_options[keyword_density_minimum]" type="text" id="onpageseo_options[keyword_density_minimum]" value="<?php echo $this->options['keyword_density_minimum'];?>" class="small-text" />%</td>
				</tr>

				<tr valign="top" style="background-color:rgb(238,238,238);">
				<th scope="row"><label for="onpageseo_options[keyword_density_maximum]"><?php _e('Keyword Density', OPSEO_TEXT_DOMAIN);?></label><br /><span style="font-size:12px;"><em><?php _e('Maximum Score', OPSEO_TEXT_DOMAIN);?></em></span></th>
				<td> <input name="onpageseo_options[keyword_density_maximum]" type="text" id="onpageseo_options[keyword_density_maximum]" value="<?php echo $this->options['keyword_density_maximum'];?>" class="small-text" />%</td>
				</tr>


				<tr valign="top">
				
				<th scope="row"><label for="onpageseo_options[keyword_density_formula]"><?php _e('Keyword Density', OPSEO_TEXT_DOMAIN);?></label><br /><span style="font-size:12px;"><em><?php _e('Formula', OPSEO_TEXT_DOMAIN);?></em></span></th>
				<td><input type="radio" name="onpageseo_options[keyword_density_formula]" value="1"<?php checked($this->options['keyword_density_formula'], '1');?> /> <label title="keyword_density1"><?php _e('(Total Keywords / Total Words) * 100', OPSEO_TEXT_DOMAIN);?></label><br />
					<input type="radio" name="onpageseo_options[keyword_density_formula]" value="2"<?php checked($this->options['keyword_density_formula'], '2');?> /> <label title="keyword_density2"><?php _e('(Total Keywords * Total Words In Keyword Phrase / Total Words) * 100', OPSEO_TEXT_DOMAIN);?></label><br />
					<input type="radio" name="onpageseo_options[keyword_density_formula]" value="3"<?php checked($this->options['keyword_density_formula'], '3');?> /> <label title="keyword_density3"><?php _e('(Total Keywords / (Total Words - (Total Keywords * (Total Words In Keyword Phrase - 1)))) * 100', OPSEO_TEXT_DOMAIN);?></label>
				</td>
				</tr>

				<tr valign="top" style="background-color:rgb(238,238,238);">
				<th scope="row"><label for="onpageseo_options[keyword_density_type]"><?php _e('Keyword Density', OPSEO_TEXT_DOMAIN);?></label><br /><span style="font-size:12px;"><em><?php _e('Content To Analyze For Keyword Density Score', OPSEO_TEXT_DOMAIN);?></em></span></th>
				<td><select name="onpageseo_options[keyword_density_type]" id="onpageseo_options_keyword_density_type">

					<option value="post" label="<?php _e('Post/Page Content', OPSEO_TEXT_DOMAIN);?>"<?php selected($this->options['keyword_density_type'], "post");?>><?php _e('Post/Page Content', OPSEO_TEXT_DOMAIN);?></option>
					<option value="full" label="<?php _e('Entire Document', OPSEO_TEXT_DOMAIN);?>"<?php selected($this->options['keyword_density_type'], "full");?>><?php _e('Entire Document', OPSEO_TEXT_DOMAIN);?></option>

					</select></td>

				</tr>


				<tr valign="top">
				<th scope="row"><label for="onpageseo_options[description_meta_tag_maximum]"><?php _e('Description Meta Tag', OPSEO_TEXT_DOMAIN);?></label><br /><span style="font-size:12px;"><em><?php _e('Maximum Characters', OPSEO_TEXT_DOMAIN);?></em></span></th>
				<td><input name="onpageseo_options[description_meta_tag_maximum]" type="text" id="onpageseo_options[description_meta_tag_maximum]" value="<?php echo $this->options['description_meta_tag_maximum'];?>" class="small-text" /> <?php _e('characters', OPSEO_TEXT_DOMAIN);?></td>
				</tr>

				<tr valign="top" style="background-color:rgb(238,238,238);">
				<th scope="row"><label for="onpageseo_options[post_content_length]"><?php _e('Post Content', OPSEO_TEXT_DOMAIN);?></label><br /><span style="font-size:12px;"><em><?php _e('Minimum Words', OPSEO_TEXT_DOMAIN);?></em></span></th>
				<td><input name="onpageseo_options[post_content_length]" type="text" id="onpageseo_options[post_content_length]" value="<?php echo $this->options['post_content_length'];?>" class="small-text" /> <?php _e('words', OPSEO_TEXT_DOMAIN);?></td>
				</tr>

				<tr valign="top">
				<th scope="row"><label for="onpageseo_options[title_length_minimum]"><?php _e('Title Length', OPSEO_TEXT_DOMAIN);?></label><br /><span style="font-size:12px;"><em><?php _e('Minimum Words', OPSEO_TEXT_DOMAIN);?></em></span></th>
				<td><input name="onpageseo_options[title_length_minimum]" type="text" id="onpageseo_options[title_length_minimum]" value="<?php echo $this->options['title_length_minimum'];?>" class="small-text" /> <?php _e('words', OPSEO_TEXT_DOMAIN);?></td>
				</tr>

				<tr valign="top" style="background-color:rgb(238,238,238);">
				<th scope="row"><label for="onpageseo_options[title_length_maximum]"><?php _e('Title Length', OPSEO_TEXT_DOMAIN);?></label><br /><span style="font-size:12px;"><em><?php _e('Maximum Characters', OPSEO_TEXT_DOMAIN);?></em></span></th>
				<td><input name="onpageseo_options[title_length_maximum]" type="text" id="onpageseo_options[title_length_maximum]" value="<?php echo $this->options['title_length_maximum'];?>" class="small-text" /> <?php _e('characters', OPSEO_TEXT_DOMAIN);?></td>
				</tr>

				</table>


				<h4 style="padding:10px 0 5px 0 !important;margin:15px 0 10px 0 !important;border-bottom:1px solid rgb(200,200,200);"><?php _e('Timeout Settings', OPSEO_TEXT_DOMAIN);?></h4>

				<table class="form-table">

				<tr valign="top">
				<th scope="row"><label for="onpageseo_options[request_timeout]"><?php _e('Request Timeout', OPSEO_TEXT_DOMAIN);?></label><br /><span style="font-size:12px;"><em><?php _e('The Number of Seconds to Wait for a Connection (Set to a Higher Number if You Experience "Timeout" Errors)', OPSEO_TEXT_DOMAIN);?></em></span></th>
				<td><input name="onpageseo_options[request_timeout]" type="text" id="onpageseo_options[request_timeout]" value="<?php echo $this->options['request_timeout'];?>" class="small-text" /> <?php _e('seconds', OPSEO_TEXT_DOMAIN);?></td>
				</tr>

				</table>


				<h4 style="padding:10px 0 5px 0 !important;margin:15px 0 10px 0 !important;border-bottom:1px solid rgb(200,200,200);"><?php _e('Display Settings', OPSEO_TEXT_DOMAIN);?></h4>

				<table class="form-table">
				<tr valign="top" style="background-color:rgb(238,238,238);">
				<th scope="row"><label for="onpageseo_options[posts_per_page]"><?php _e('Posts Per Page', OPSEO_TEXT_DOMAIN);?></label><br /><span style="font-size:12px;"><em><?php _e('Number Of Posts/Pages To Display Per Page', OPSEO_TEXT_DOMAIN);?></em></span></th>
				<td><input name="onpageseo_options[posts_per_page]" type="text" id="onpageseo_options[posts_per_page]" value="<?php echo $this->options['posts_per_page'];?>" class="small-text" /> <?php _e('posts', OPSEO_TEXT_DOMAIN);?></td>
				</tr>
				</table>


				<h4 style="padding:10px 0 5px 0 !important;margin:15px 0 10px 0 !important;border-bottom:1px solid rgb(200,200,200);"><?php _e('Internal Links', OPSEO_TEXT_DOMAIN);?></h4>

				<table class="form-table">
				<tr valign="top">
				<th scope="row"><label for="onpageseo_options[internal_links_posts_per_page]"><?php _e('Maximum Number Of Posts To Display', OPSEO_TEXT_DOMAIN);?></label><br /><span style="font-size:12px;"><em><?php _e('Maximum Number Of Internal Posts/Pages To Display', OPSEO_TEXT_DOMAIN);?></em></span></th>
				<td><input name="onpageseo_options[internal_links_posts_per_page]" type="text" id="onpageseo_options[internal_links_posts_per_page]" value="<?php echo $this->options['internal_links_posts_per_page'];?>" class="small-text" /> <?php _e('posts', OPSEO_TEXT_DOMAIN);?></td>
				</tr>
				</table>

				<h4 style="padding:10px 0 5px 0 !important;margin:15px 0 10px 0 !important;border-bottom:1px solid rgb(200,200,200);"><?php _e('Internal Images', OPSEO_TEXT_DOMAIN);?></h4>

				<table class="form-table">
				<tr valign="top" style="background-color:rgb(238,238,238);">
				<th scope="row"><label for="onpageseo_options[internal_images_per_page]"><?php _e('Maximum Number Of Images To Display', OPSEO_TEXT_DOMAIN);?></label><br /><span style="font-size:12px;"><em><?php _e('Maximum Number Of Internal Images To Display', OPSEO_TEXT_DOMAIN);?></em></span></th>
				<td><input name="onpageseo_options[internal_images_per_page]" type="text" id="onpageseo_options[internal_images_per_page]" value="<?php echo $this->options['internal_images_per_page'];?>" class="small-text" /> <?php _e('images', OPSEO_TEXT_DOMAIN);?></td>
				</tr>
				</table>


				<h4 style="padding:10px 0 5px 0 !important;margin:15px 0 10px 0 !important;border-bottom:1px solid rgb(200,200,200);"><?php _e('Posts/Pages Columns', OPSEO_TEXT_DOMAIN);?></h4>

				<table class="form-table">

				<tr valign="top">
				<th scope="row"><label for="onpageseo_options[posts_columns_score]"><?php _e('Add Columns To Posts/Pages', OPSEO_TEXT_DOMAIN);?></label></th>
				<td><input type="checkbox" name="onpageseo_options[posts_columns_score]" value="1"<?php checked($this->options['posts_columns_score'], 1);?> /> <label for="onpageseo_options[posts_columns_score]"><?php _e('On-Page SEO Score', OPSEO_TEXT_DOMAIN);?></label><br />
				<input type="checkbox" name="onpageseo_options[posts_columns_keyword]" value="1"<?php checked($this->options['posts_columns_keyword'], 1);?> /> <label for="onpageseo_options[posts_columns_keyword]"><?php _e('Primary Keyword', OPSEO_TEXT_DOMAIN);?></label><br />
				<input type="checkbox" name="onpageseo_options[posts_columns_kw_density]" value="1"<?php checked($this->options['posts_columns_kw_density'], 1);?> /> <label for="onpageseo_options[posts_columns_kw_density]"><?php _e('Keyword Density', OPSEO_TEXT_DOMAIN);?></label></td>
				</tr>

				</table>

				<h4 style="padding:10px 0 5px 0 !important;margin:15px 0 10px 0 !important;border-bottom:1px solid rgb(200,200,200);"><?php _e('Proxy Server URL', OPSEO_TEXT_DOMAIN);?></h4>

				<table class="form-table">

				<tr valign="top" style="background-color:rgb(238,238,238);">
				<th scope="row"><label for="onpageseo_options[proxy_server_url]"><?php _e('Proxy Server URL', OPSEO_TEXT_DOMAIN);?> </label></th>
				<td><input type="text" name="onpageseo_options[proxy_server_url]" value="<?php echo $this->options['proxy_server_url'];?>" class="large-text" /><br /><em><?php _e('Enter a proxy server URL if your web host does not allow loopback connections.', OPSEO_TEXT_DOMAIN);?></em></td>
				</tr>

				</table>



				<h4 style="padding:10px 0 5px 0 !important;margin:15px 0 10px 0 !important;border-bottom:1px solid rgb(200,200,200);"><?php _e('Stop Words', OPSEO_TEXT_DOMAIN);?></h4>

				<table class="form-table">

				<tr valign="top" style="background-color:rgb(238,238,238);">
				<th scope="row"><label for="onpageseo_options[stop_words_enabled]"><?php _e('Stop Words', OPSEO_TEXT_DOMAIN);?></label><br /><span style="font-size:12px;"><em><?php _e('Words Ignored By Search Engines', OPSEO_TEXT_DOMAIN);?></em></span></th>
				<td><select name="onpageseo_options[stop_words_enabled]" id="onpageseo_options[stop_words_enabled]">

					<option value="" label="<?php _e('Turned Off', OPSEO_TEXT_DOMAIN);?>"<?php selected($this->options['stop_words_enabled'], "");?>><?php _e('Turned Off', OPSEO_TEXT_DOMAIN);?></option>
					<option value="1" label="<?php _e('Turned On', OPSEO_TEXT_DOMAIN);?>"<?php selected($this->options['stop_words_enabled'], "1");?>><?php _e('Turned On', OPSEO_TEXT_DOMAIN);?></option>

					</select></td>

				</tr>

				<tr valign="top">
				<th scope="row"><label for="onpageseo_options[stop_words]"><?php _e('Stop Words', OPSEO_TEXT_DOMAIN);?></label><br /><span style="font-size:12px;"><em><?php _e('Enter Each Word On A New Line', OPSEO_TEXT_DOMAIN);?></em></span></th>
				<td><textarea name="onpageseo_options[stop_words]" id="onpageseo_options[stop_words]" rows="8" cols="70"><?php echo $this->options['stop_words'];?></textarea></td>
				</tr>

				</table>





				<h4 style="padding:10px 0 5px 0 !important;margin:15px 0 10px 0 !important;border-bottom:1px solid rgb(200,200,200);"><?php _e('Shortcode Support', OPSEO_TEXT_DOMAIN);?></h4>

				<table class="form-table">

				<tr valign="top" style="background-color:rgb(238,238,238);">
				<th scope="row"><label for="onpageseo_options[shortcode_support]"><?php _e('Analyze Shortcodes', OPSEO_TEXT_DOMAIN);?></label><br /><span style="font-size:12px;"><em><?php _e('Perform Shortcodes and Include the Contents in the Analysis.', OPSEO_TEXT_DOMAIN);?></em></span></th>
				<td><select name="onpageseo_options[shortcode_support]" id="onpageseo_options[shortcode_support]">

					<option value="" label="<?php _e('Turned Off', OPSEO_TEXT_DOMAIN);?>"<?php selected($this->options['shortcode_support'], "");?>><?php _e('Turned Off', OPSEO_TEXT_DOMAIN);?></option>
					<option value="1" label="<?php _e('Turned On', OPSEO_TEXT_DOMAIN);?>"<?php selected($this->options['shortcode_support'], "1");?>><?php _e('Turned On', OPSEO_TEXT_DOMAIN);?></option>

					</select></td>

				</tr>

				</table>




				<h4 style="padding:10px 0 5px 0 !important;margin:15px 0 10px 0 !important;border-bottom:1px solid rgb(200,200,200);"><?php _e('Easy WP SEO Metabox', OPSEO_TEXT_DOMAIN);?></h4>

				<table class="form-table">

				<tr valign="top">
				<th scope="row"><label for="onpageseo_options[hide_metabox]"><?php _e('Hide Metabox', OPSEO_TEXT_DOMAIN);?></label><br /><span style="font-size:12px;"><em><?php _e('Hide '.OPSEO_NAME.' Metabox On Specified Post Types.', OPSEO_TEXT_DOMAIN);?></em></span></th>
				<td>

				<?php
					foreach($this->getPostTypes() as $type)
					{
						if($type != 'revision' && $type != 'nav_menu_item' && $type != 'attachment')
						{
				?>
							<input type="checkbox" name="onpageseo_options[hide_<?php echo $type;?>]" value="1"<?php checked($this->options['hide_'.$type], 1);?> /> <label for="onpageseo_options[hide_<?php echo $type;?>]"><?php echo $type;?></label><br />
				<?php
						}
					}
				?>

				</td>

				</tr>

				</table>









			</div>

			<div id="opseo-keyword" class="opseo-tabs-panel">

				<p><?php _e('Here is how to adjust the settings for the Latent Semantic Indexing (LSI) feature', OPSEO_TEXT_DOMAIN);?>:</p>

				<h4 style="padding:10px 0 5px 0 !important;margin:15px 0 10px 0 !important;border-bottom:1px solid rgb(200,200,200);"><?php _e('LSI Keyword Settings', OPSEO_TEXT_DOMAIN);?></h4>

				<table class="form-table">

				<tr valign="top">
				<th scope="row"><label for="onpageseo_options[lsi_keyword_region_bing]">Default Region/Language</label><br /><span style="font-size:12px;"><em>Default Search</em></span></th>
				<td><select name="onpageseo_options[lsi_keyword_region_bing]" id="onpageseo_options[lsi_keyword_region_bing]">

					<option value="ar-XA" label="Arabia (Arabic)"<?php selected($this->options['lsi_keyword_region_bing'], "ar-XA");?>>Arabia (Arabic)</option>
					<option value="bg-BG" label="Bulgaria (Bulgarian)"<?php selected($this->options['lsi_keyword_region_bing'], "bg-BG");?>>Bulgaria (Bulgarian)</option>
					<option value="cs-CZ" label="Czech Republic (Czech)"<?php selected($this->options['lsi_keyword_region_bing'], "cs-CZ");?>>Czech Republic (Czech)</option>
					<option value="da-DK" label="Denmark (Danish)"<?php selected($this->options['lsi_keyword_region_bing'], "da-DK");?>>Denmark (Danish)</option>
					<option value="de-AT" label="Austria (German)"<?php selected($this->options['lsi_keyword_region_bing'], "de-AT");?>>Austria (German)</option>
					<option value="de-CH" label="Switzerland (German)"<?php selected($this->options['lsi_keyword_region_bing'], "de-CH");?>>Switzerland (German)</option>
					<option value="de-DE" label="Germany (German)"<?php selected($this->options['lsi_keyword_region_bing'], "de-DE");?>>Germany (German)</option>
					<option value="el-GR" label="Greece (Greek)"<?php selected($this->options['lsi_keyword_region_bing'], "el-GR");?>>Greece (Greek)</option>
					<option value="en-AU" label="Australia (English)"<?php selected($this->options['lsi_keyword_region_bing'], "en-AU");?>>Australia (English)</option>
					<option value="en-CA" label="Canada (English)"<?php selected($this->options['lsi_keyword_region_bing'], "en-CA");?>>Canada (English)</option>
					<option value="en-AU" label="Australia (English)"<?php selected($this->options['lsi_keyword_region_bing'], "en-AU");?>>Australia (English)</option>					<option value="en-GB" label="United Kingdom (English)"<?php selected($this->options['lsi_keyword_region_bing'], "en-GB");?>>United Kingdom (English)</option>
					<option value="en-ID" label="Indonesia (English)"<?php selected($this->options['lsi_keyword_region_bing'], "en-ID");?>>Indonesia (English)</option>					<option value="en-IE" label="Ireland (English)"<?php selected($this->options['lsi_keyword_region_bing'], "en-IE");?>>Ireland (English)</option>					<option value="en-IN" label="India (English)"<?php selected($this->options['lsi_keyword_region_bing'], "en-IN");?>>India (English)</option>					<option value="en-MY" label="Malaysia (English)"<?php selected($this->options['lsi_keyword_region_bing'], "en-MY");?>>Malaysia (English)</option>					<option value="en-NZ" label="New Zealand (English)"<?php selected($this->options['lsi_keyword_region_bing'], "en-NZ");?>>New Zealand (English)</option>					<option value="en-PH" label="Philippines (English)"<?php selected($this->options['lsi_keyword_region_bing'], "en-PH");?>>Philippines (English)</option>					<option value="en-SG" label="Singapore (English)"<?php selected($this->options['lsi_keyword_region_bing'], "en-SG");?>>Singapore (English)</option>					<option value="en-US" label="United States (English)"<?php selected($this->options['lsi_keyword_region_bing'], "en-US");?>>United States (English)</option>					<option value="en-XA" label="Arabia (English)"<?php selected($this->options['lsi_keyword_region_bing'], "en-XA");?>>Arabia (English)</option>					<option value="en-ZA" label="South Africa (English)"<?php selected($this->options['lsi_keyword_region_bing'], "en-ZA");?>>South Africa (English)</option>
					<option value="es-AR" label="Argentina (Spanish)"<?php selected($this->options['lsi_keyword_region_bing'], "es-AR");?>>Argentina (Spanish)</option>
					<option value="es-CL" label="Chile (Spanish)"<?php selected($this->options['lsi_keyword_region_bing'], "es-CL");?>>Chile (Spanish)</option>
					<option value="es-ES" label="Spain (Spanish)"<?php selected($this->options['lsi_keyword_region_bing'], "es-ES");?>>Spain (Spanish)</option>					<option value="es-MX" label="Mexico (Spanish)"<?php selected($this->options['lsi_keyword_region_bing'], "es-MX");?>>Mexico (Spanish)</option>					<option value="es-US" label="United States (Spanish)"<?php selected($this->options['lsi_keyword_region_bing'], "es-US");?>>United States (Spanish)</option>					<option value="es-XL" label="Latin America (Spanish)"<?php selected($this->options['lsi_keyword_region_bing'], "es-XL");?>>Latin America (Spanish)</option>
					<option value="et-EE" label="Estonia (Estonian)"<?php selected($this->options['lsi_keyword_region_bing'], "et-EE");?>>Estonia (Estonian)</option>
					<option value="fi-FI" label="Finland (Finnish)"<?php selected($this->options['lsi_keyword_region_bing'], "fi-FI");?>>Finland (Finish)</option>
					<option value="fr-BE" label="Belgium (French)"<?php selected($this->options['lsi_keyword_region_bing'], "fr-BE");?>>Belgium (French)</option>
					<option value="fr-CA" label="Canada (French)"<?php selected($this->options['lsi_keyword_region_bing'], "fr-CA");?>>Canada (French)</option>					<option value="fr-CH" label="Switzerland (French)"<?php selected($this->options['lsi_keyword_region_bing'], "fr-CH");?>>Switzerland (French)</option>					<option value="fr-FR" label="France (French)"<?php selected($this->options['lsi_keyword_region_bing'], "fr-FR");?>>France (French)</option>
					<option value="he-IL" label="Israel (Hebrew)"<?php selected($this->options['lsi_keyword_region_bing'], "he-IL");?>>Israel (Hebrew)</option>
					<option value="hr-HR" label="Croatia (Croatian)"<?php selected($this->options['lsi_keyword_region_bing'], "hr-HR");?>>Croatia (Croatian)</option>
					<option value="hu-HU" label="Hungary (Hungarian)"<?php selected($this->options['lsi_keyword_region_bing'], "hu-HU");?>>Hungary (Hungarian)</option>
					<option value="it-IT" label="Italy (Italian)"<?php selected($this->options['lsi_keyword_region_bing'], "it-IT");?>>Italy (Italian)</option>
					<option value="ja-JP" label="Japan (Japanese)"<?php selected($this->options['lsi_keyword_region_bing'], "ja-JP");?>>Japan (Japanese)</option>
					<option value="ko-KR" label="Korea (Korean)"<?php selected($this->options['lsi_keyword_region_bing'], "ko-KR");?>>Korea (Korean)</option>
					<option value="lt-LT" label="Lithuania (Lithuanian)"<?php selected($this->options['lsi_keyword_region_bing'], "lt-LT");?>>Lithuania (Lithuanian)</option>
					<option value="lv-LV" label="Latvia (Latvian)"<?php selected($this->options['lsi_keyword_region_bing'], "lv-LV");?>>Latvia (Latvian)</option>
					<option value="nb-NO" label="Norway (Norwegian)"<?php selected($this->options['lsi_keyword_region_bing'], "nb-NO");?>>Norway (Norwegian)</option>
					<option value="nl-BE" label="Belgium (Dutch)"<?php selected($this->options['lsi_keyword_region_bing'], "nl-BE");?>>Belgium (Dutch)</option>
					<option value="nl-NL" label="Netherlands (Dutch)"<?php selected($this->options['lsi_keyword_region_bing'], "nl-NL");?>>Netherlands (Dutch)</option>
					<option value="pl-PL" label="Poland (Polish)"<?php selected($this->options['lsi_keyword_region_bing'], "pl-PL");?>>Poland (Polish)</option>
					<option value="pt-BR" label="Brazil (Portuguese)"<?php selected($this->options['lsi_keyword_region_bing'], "pt-BR");?>>Brazil (Portuguese)</option>
					<option value="pt-PT" label="Portugal (Portuguese)"<?php selected($this->options['lsi_keyword_region_bing'], "pt-PT");?>>Portugal (Portuguese)</option>
					<option value="ro-RO" label="Romania (Romanian)"<?php selected($this->options['lsi_keyword_region_bing'], "ro-RO");?>>Romania (Romanian)</option>
					<option value="ru-RU" label="Russia (Russian)"<?php selected($this->options['lsi_keyword_region_bing'], "ru-RU");?>>Russia (Russian)</option>
					<option value="sk-SK" label="Slovak Republic (Slovak)"<?php selected($this->options['lsi_keyword_region_bing'], "sk-SK");?>>Slovak Republic (Slovak)</option>
					<option value="sl-SL" label="Slovenia (Slovenian)"<?php selected($this->options['lsi_keyword_region_bing'], "sl-SL");?>>Slovenia (Slovenian)</option>
					<option value="sv-SE" label="Sweden (Swedish)"<?php selected($this->options['lsi_keyword_region_bing'], "sv-SE");?>>Sweden (Swedish)</option>
					<option value="th-TH" label="Thailand (Thai)"<?php selected($this->options['lsi_keyword_region_bing'], "th-TH");?>>Thailand (Thai)</option>
					<option value="tr-TR" label="Turkey (Turkish)"<?php selected($this->options['lsi_keyword_region_bing'], "tr-TR");?>>Turkey (Turkish)</option>
					<option value="uk-UA" label="Ukraine (Ukrainian)"<?php selected($this->options['lsi_keyword_region_bing'], "uk-UA");?>>Ukraine (Ukrainian)</option>
					<option value="zh-CN" label="China (Chinese)"<?php selected($this->options['lsi_keyword_region_bing'], "zh-CN");?>>China (Chinese)</option>
					<option value="zh-HK" label="Hong Kong SAR (Chinese)"<?php selected($this->options['lsi_keyword_region_bing'], "zh-HK");?>>Hong Kong SAR (Chinese)</option>
					<option value="zh-TW" label="Taiwan (Chinese)"<?php selected($this->options['lsi_keyword_region_bing'], "zh-TW");?>>Taiwan (Chinese)</option>

					</select></td>

				</tr>




				</table>


				<h4 style="padding:10px 0 5px 0 !important;margin:15px 0 10px 0 !important;border-bottom:1px solid rgb(200,200,200);"><?php _e('Auto Blog', OPSEO_TEXT_DOMAIN);?></h4>

				<table class="form-table">


				<tr valign="top">
				
				<th scope="row"><label for="onpageseo_options[automatic_keyword]"><?php _e('Automatically Add Keyword', OPSEO_TEXT_DOMAIN);?></span></th>

				<td><select name="onpageseo_options[automatic_keyword]" id="onpageseo_options[automatic_keyword]">

					<option value="" label="<?php _e('Turned Off', OPSEO_TEXT_DOMAIN);?>"<?php selected($this->options['automatic_keyword'], "");?>><?php _e('Turned Off', OPSEO_TEXT_DOMAIN);?></option>
					<option value="title" label="<?php _e('Title', OPSEO_TEXT_DOMAIN);?>"<?php selected($this->options['automatic_keyword'], "title");?>><?php _e('Title', OPSEO_TEXT_DOMAIN);?></option>
					<option value="categories" label="<?php _e('Categories', OPSEO_TEXT_DOMAIN);?>"<?php selected($this->options['automatic_keyword'], "categories");?>><?php _e('Categories', OPSEO_TEXT_DOMAIN);?></option>
					<option value="tags" label="<?php _e('Tags', OPSEO_TEXT_DOMAIN);?>"<?php selected($this->options['automatic_keyword'], "tags");?>><?php _e('Tags', OPSEO_TEXT_DOMAIN);?></option>
					<option value="aioseo_title" label="<?php _e('All-In-One SEO Title (plugin)', OPSEO_TEXT_DOMAIN);?>"<?php selected($this->options['automatic_keyword'], "aioseo_title");?>><?php _e('All-In-One SEO Title (plugin)', OPSEO_TEXT_DOMAIN);?></option>
					<option value="aioseo_keywords" label="<?php _e('All-In-One SEO Keywords (plugin)', OPSEO_TEXT_DOMAIN);?>"<?php selected($this->options['automatic_keyword'], "aioseo_keywords");?>><?php _e('All-In-One SEO Keywords (plugin)', OPSEO_TEXT_DOMAIN);?></option>

					</select></td>
				</tr>


				</table>






































			</div>


			<div id="opseo-password-protection" class="opseo-tabs-panel">

				<p style="background-color:rgb(255,235,232);border:1px solid rgb(204,0,0);padding:10px;"><strong><?php _e('IMPORTANT', OPSEO_TEXT_DOMAIN);?>:</strong> <?php _e('Make sure you change the permissions of the cookie file to make it writable to Wordpress, but unreadable to the public. I recommend you chmod the file to 700.', OPSEO_TEXT_DOMAIN);?></p>

				<p><?php _e('Is this a membership site? Do you want to analyze content that is password-protected? Is your site in "maintenance" mode? If so, enter your Administrator account information to grant Easy WP SEO access to all protected content', OPSEO_TEXT_DOMAIN);?>:</p>

				<h4 style="padding:10px 0 5px 0 !important;margin:15px 0 10px 0 !important;border-bottom:1px solid rgb(200,200,200);"><?php _e('Password Protection', OPSEO_TEXT_DOMAIN);?></h4>

				<table class="form-table">

				<tr valign="top" style="background-color:rgb(238,238,238);">
				<th scope="row"><label for="onpageseo_options[password_activation]"><?php _e('Activate/Deactivate', OPSEO_TEXT_DOMAIN);?></label></th>
				<td>
					<input type="radio" name="onpageseo_options[password_activation]" value="activated"<?php checked($this->options['password_activation'], 'activated');?> /> <label title="activated"><?php _e('Activated', OPSEO_TEXT_DOMAIN);?></label><br />
					<input type="radio" name="onpageseo_options[password_activation]" value="deactivated"<?php checked($this->options['password_activation'], 'deactivated');?> /> <label title="deactivated"><?php _e('Deactivated', OPSEO_TEXT_DOMAIN);?></label>
				</td>
				</tr>

				</table>

				<h4 style="padding:10px 0 5px 0 !important;margin:15px 0 10px 0 !important;border-bottom:1px solid rgb(200,200,200);"><?php _e('Access Information', OPSEO_TEXT_DOMAIN);?></h4>

				<table class="form-table">

				<tr valign="top">
				<th scope="row"><label for="onpageseo_options[password_username]"><?php _e('Administrator Username', OPSEO_TEXT_DOMAIN);?></label></th>
				<td><input type="text" name="onpageseo_options[password_username]" value="<?php echo $this->options['password_username'];?>" class="large-text" /><br /><em><?php _e('Enter your Wordpress Administrator username.', OPSEO_TEXT_DOMAIN);?></em></td>
				</tr>

				<tr valign="top" style="background-color:rgb(238,238,238);">
				<th scope="row"><label for="onpageseo_options[password_password]"><?php _e('Administrator Password', OPSEO_TEXT_DOMAIN);?></label></th>
				<td><input type="text" name="onpageseo_options[password_password]" value="<?php echo $this->options['password_password'];?>" class="large-text" /><br /><em><?php _e('Enter your Wordpress Administrator password.', OPSEO_TEXT_DOMAIN);?></em></td>
				</tr>

				</table>

				<h4 style="padding:10px 0 5px 0 !important;margin:15px 0 10px 0 !important;border-bottom:1px solid rgb(200,200,200);"><?php _e('cURL Cookie Settings', OPSEO_TEXT_DOMAIN);?></h4>

				<table class="form-table">

				<tr valign="top" style="background-color:rgb(238,238,238);">
				<th scope="row"><label for="onpageseo_options[password_file_path]"><?php _e('Cookie File Location');?> </label><?php if(is_file($this->options['password_file_path']) && ($this->pwProtectionLoggedIn || (filesize($this->options['password_file_path']) > 0))) { echo '<br /><em><span style="color:green;font-size:12px;">'.__('The cookie file already contains your access information!', OPSEO_TEXT_DOMAIN).'</span></em>'; }?></em>
				<td><input type="text" name="onpageseo_options[password_file_path]" value="<?php echo $this->options['password_file_path'];?>" class="large-text" /><br /><em><?php _e('cURL will save your cookie information in this file.', OPSEO_TEXT_DOMAIN);?></em></td>
				</tr>

				</table>

			</div>

			<div id="opseo-copyscape" class="opseo-tabs-panel">

				<p><?php _e('Enter your Copyscape Premium account information', OPSEO_TEXT_DOMAIN);?>:</p>

				<h4 style="padding:10px 0 5px 0 !important;margin:15px 0 10px 0 !important;border-bottom:1px solid rgb(200,200,200);"><?php _e('Access Information', OPSEO_TEXT_DOMAIN);?></h4>

				<table class="form-table">

				<tr valign="top">
				<th scope="row"><label for="onpageseo_options[copyscape_username]"><?php _e('Copyscape Username', OPSEO_TEXT_DOMAIN);?></label></th>
				<td><input type="text" name="onpageseo_options[copyscape_username]" value="<?php echo $this->options['copyscape_username'];?>" class="large-text" /><br /><em><?php _e('Enter your Copyscape Premium username.', OPSEO_TEXT_DOMAIN);?></em></td>
				</tr>

				<tr valign="top" style="background-color:rgb(238,238,238);">
				<th scope="row"><label for="onpageseo_options[copyscape_api_key]"><?php _e('Copyscape API Key', OPSEO_TEXT_DOMAIN);?></label></th>
				<td><input type="text" name="onpageseo_options[copyscape_api_key]" value="<?php echo $this->options['copyscape_api_key'];?>" class="large-text" /><br /><a href="http://www.copyscape.com" target="_blank"><?php _e('Create a Copyscape Premium account.', OPSEO_TEXT_DOMAIN);?></a></td>
				</tr>

				</table>

				<h4 style="padding:10px 0 5px 0 !important;margin:15px 0 10px 0 !important;border-bottom:1px solid rgb(200,200,200);"><?php _e('Copyscape Settings', OPSEO_TEXT_DOMAIN);?></h4>

				<table class="form-table">

				<tr valign="top">
				<th scope="row"><label for="onpageseo_options[copyscape_role]"><?php _e('Minimum User Role', OPSEO_TEXT_DOMAIN);?></label><br /><span style="font-size:12px;"><em><?php _e('Required To Access Copyscape', OPSEO_TEXT_DOMAIN);?></em></span></th>
				<td><select name="onpageseo_options[copyscape_role]" id="onpageseo_options[copyscape_role]">

					<option value="administrator" label="<?php _e('Administrator', OPSEO_TEXT_DOMAIN);?>"<?php selected($this->options['copyscape_role'], "administrator");?>><?php _e('Administrator', OPSEO_TEXT_DOMAIN);?></option>
					<option value="editor" label="<?php _e('Editor', OPSEO_TEXT_DOMAIN);?>"<?php selected($this->options['copyscape_role'], "editor");?>><?php _e('Editor', OPSEO_TEXT_DOMAIN);?></option>
					<option value="author" label="<?php _e('Author', OPSEO_TEXT_DOMAIN);?>"<?php selected($this->options['copyscape_role'], "author");?>><?php _e('Author', OPSEO_TEXT_DOMAIN);?></option>
					<option value="contributor" label="<?php _e('Contributor', OPSEO_TEXT_DOMAIN);?>"<?php selected($this->options['copyscape_role'], "contributor");?>><?php _e('Contributor', OPSEO_TEXT_DOMAIN);?></option>
					<option value="subscriber" label="<?php _e('Subscriber', OPSEO_TEXT_DOMAIN);?>"<?php selected($this->options['copyscape_role'], "subscriber");?>><?php _e('Subscriber', OPSEO_TEXT_DOMAIN);?></option>

					</select></td>

				</tr>


				<tr valign="top" style="background-color:rgb(238,238,238);">
				<th scope="row"><label for="onpageseo_options[copyscape_confirm]"><?php _e('Confirm Each Copyscape Search', OPSEO_TEXT_DOMAIN);?> </label></th>
				<td><input type="checkbox" name="onpageseo_options[copyscape_confirm]" value="1"<?php checked($this->options['copyscape_confirm'], 1);?> /> <label for="onpageseo_options[copyscape_confirm]"><?php _e('Must click "OK" button on confirmation box before every Copyscape search.', OPSEO_TEXT_DOMAIN);?></label></td>
				</tr>

				</table>

			</div>

			<div id="opseo-license" class="opseo-tabs-panel"<?php if($this->licenseHide){ echo ' style="display:none;"';}?>>
			
				<?php include_once('admin-license-form.php');?>

			</div>

		</div>

		<div class="opseo-submit">
			<input type="hidden" name="onpageseo_options[old_license_email]" value="<?php echo $this->options['license_email'];?>" />
			<input type="hidden" name="onpageseo_options[old_license_serial]" value="<?php echo $this->options['license_serial'];?>" />
			<input type="submit" name="Submit" class="button-primary" value="<?php _e('Save Changes', OPSEO_TEXT_DOMAIN);?>" />
		</div>

	</form>


		<?php if(!$this->license->isLicenseError()){$this->licenseFooter();}?>


	</div>





<script type="text/javascript">

jQuery(document).ready(function() {

	var opseoTabs = jQuery('#opseo-tabs li.opseotabs');
	var opseoTabsContents = jQuery('.opseo-tabs-panel');

	jQuery(function(){
		opseoTabsContents.hide(); //hide all contents
		opseoTabs.removeClass('opseo-tabs-selected');
		jQuery(opseoTabsContents[0]).show();
		jQuery(opseoTabs[0]).addClass('opseo-tabs-selected');
	});

	opseoTabs.bind('click',function() {
		opseoTabsContents.hide(); //hide all contents
		opseoTabs.removeClass('opseo-tabs-selected');
		jQuery(opseoTabsContents[jQuery('#opseo-tabs li.opseotabs').index(this)]).show();
		jQuery(this).addClass('opseo-tabs-selected');

		return false;
	});

	var opseoImportExportTabs = jQuery('#opseo-import-export-tabs li.importexporttabs');
	var opseoImportExportTabsContents = jQuery('.import-export-tabs-panel');

	jQuery(function(){
		opseoImportExportTabsContents.hide(); //hide all contents
		opseoImportExportTabs.removeClass('opseo-tabs-selected');
		jQuery(opseoImportExportTabsContents[0]).show();
		jQuery(opseoImportExportTabs[0]).addClass('opseo-tabs-selected');
	});

	opseoImportExportTabs.bind('click',function() {
		opseoImportExportTabsContents.hide(); //hide all contents
		opseoImportExportTabs.removeClass('opseo-tabs-selected');
		jQuery(opseoImportExportTabsContents[jQuery('#opseo-import-export-tabs li.importexporttabs').index(this)]).show();
		jQuery(this).addClass('opseo-tabs-selected');

		return false;
	});


	// Recommended Settings Button Clicked
	jQuery('#opseo-recommended-settings').click(function(){

		if(confirm('Are you sure you want to select the recommended settings? If so, you will need to click the \'Save Settings\' button to apply the changes.'))
		{
			// Decoration Type
			jQuery('#onpageseo_options_decoration_type').val('admin');

			// Bold Keyword
			jQuery('input[name="onpageseo_options[bold_keyword]"]').attr('checked', true);
			jQuery('input:radio[name="onpageseo_options[bold_style]"]:nth(1)').attr('checked', true);

			// Italicize Keyword
			jQuery('input[name="onpageseo_options[italic_keyword]"]').attr('checked', false);

			// Underline Keyword
			jQuery('input[name="onpageseo_options[underline_keyword]"]').attr('checked', false);

			// Image ALT
			jQuery('input[name="onpageseo_options[image_alt]"]').attr('checked', true);

			// No Follow
			jQuery('input[name="onpageseo_options[no_follow]"]').attr('checked', false);

			// Link Target
			jQuery('input[name="onpageseo_options[link_target]"]').attr('checked', false);

			// On-Page SEO Factors
			jQuery('input[name="onpageseo_options[title_factor]"]').attr('checked', true);
			jQuery('input[name="onpageseo_options[title_beginning_factor]"]').attr('checked', true);
			jQuery('input[name="onpageseo_options[title_words_factor]"]').attr('checked', true);
			jQuery('input[name="onpageseo_options[title_characters_factor]"]').attr('checked', true);
			jQuery('input[name="onpageseo_options[url_factor]"]').attr('checked', true);
			jQuery('input[name="onpageseo_options[description_meta_factor]"]').attr('checked', true);
			jQuery('input[name="onpageseo_options[description_chars_meta_factor]"]').attr('checked', true);
			jQuery('input[name="onpageseo_options[description_meta_tag_maximum]"]').attr('checked', true);
			jQuery('input[name="onpageseo_options[description_beginning_meta_factor]"]').attr('checked', true);
			jQuery('input[name="onpageseo_options[keywords_meta_factor]"]').attr('checked', true);
			jQuery('input[name="onpageseo_options[h1_factor]"]').attr('checked', true);
			jQuery('input[name="onpageseo_options[h2_factor]"]').attr('checked', false);
			jQuery('input[name="onpageseo_options[h3_factor]"]').attr('checked', false);
			jQuery('input[name="onpageseo_options[content_words_factor]"]').attr('checked', true);
			jQuery('input[name="onpageseo_options[content_kw_density_factor]"]').attr('checked', true);
			jQuery('input[name="onpageseo_options[content_first_factor]"]').attr('checked', true);
			jQuery('input[name="onpageseo_options[content_alt_factor]"]').attr('checked', true);
			jQuery('input[name="onpageseo_options[content_bold_factor]"]').attr('checked', true);
			jQuery('input[name="onpageseo_options[content_italic_factor]"]').attr('checked', false);
			jQuery('input[name="onpageseo_options[content_underline_factor]"]').attr('checked', false);
			jQuery('input[name="onpageseo_options[content_external_link_factor]"]').attr('checked', true);
			jQuery('input[name="onpageseo_options[content_internal_link_factor]"]').attr('checked', true);
			jQuery('input[name="onpageseo_options[content_last_factor]"]').attr('checked', false);

			// Keyword Density
			jQuery('input[name="onpageseo_options[keyword_density_minimum]"]').val('1.0');
			jQuery('input[name="onpageseo_options[keyword_density_maximum]"]').val('2.0');
			jQuery('input:radio[name="onpageseo_options[keyword_density_formula]"]:nth(2)').attr('checked', true);
			jQuery('#onpageseo_options_keyword_density_type').val('full');

			// Content Values
			jQuery('input[name="onpageseo_options[description_meta_tag_maximum]"]').val('160');
			jQuery('input[name="onpageseo_options[post_content_length]"]').val('500');
			jQuery('input[name="onpageseo_options[title_length_minimum]"]').val('3');
			jQuery('input[name="onpageseo_options[title_length_maximum]"]').val('66');

		}

	});
});

</script>