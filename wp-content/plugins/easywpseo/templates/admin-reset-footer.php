			<div class="updated" style="margin-top: 20px;">
				<form name="clearkeywords" id="clearkeywords" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>?page=onpageseo-manage-keywords">

					<table border="0" cellspacing="0" cellpadding="0" width="100%">
					<tr>
					<td valign="top" width="50%">

						<table border="0" cellspacing="0" cellpadding="0">
						<tr><td><h3 style="padding:0 !important;margin:10px 0 !important;"><?php _e('Import Keywords', OPSEO_TEXT_DOMAIN);?><a href="<?php echo OPSEO_PLUGIN_URL;?>/templates/admin-video.php?vidid=RVyeuHIowXM&#038;TB_iframe=1&width=640&height=925" class="thickbox" title="<?php _e('Import Keywords', OPSEO_TEXT_DOMAIN);?>"><img src="<?php echo OPSEO_PLUGIN_URL;?>/images/help.png" alt="<?php _e('Help', OPSEO_TEXT_DOMAIN);?>" title="<?php _e('Help', OPSEO_TEXT_DOMAIN);?>" /></a></h3><p><?php _e('Import keywords from other plugins (skips Easy WP SEO keywords that already exist).', OPSEO_TEXT_DOMAIN);?></p></td></tr>
						<tr>

						<td valign="top">

						<p><input type="hidden" name="updated" value="true" />
						<input onclick="return confirm('<?php _e('This will import all post/page keywords from SEOPressor. Continue?', OPSEO_TEXT_DOMAIN);?>')" class="button" type="submit" name="<?php echo OPSEO_PREFIX;?>_import_seopressor" value="<?php _e('Import SEOPressor Keywords', OPSEO_TEXT_DOMAIN);?>" style="margin-top: 5px !important;" />

						<input onclick="return confirm('<?php _e('This will import all post/page keywords from ClickBump SEO!. Continue?', OPSEO_TEXT_DOMAIN);?>')" class="button" type="submit" name="<?php echo OPSEO_PREFIX;?>_import_clickbump" value="<?php _e('Import ClickBump SEO! Keywords', OPSEO_TEXT_DOMAIN);?>" style="margin-top: 5px !important;" />

						<input onclick="return confirm('<?php _e('This will import all post/page keywords from WP SEO Beast. Continue?', OPSEO_TEXT_DOMAIN);?>')" class="button" type="submit" name="<?php echo OPSEO_PREFIX;?>_import_seobeast" value="<?php _e('Import SEO Beast Keywords', OPSEO_TEXT_DOMAIN);?>" style="margin-top: 5px !important;" />

						<input onclick="return confirm('<?php _e('This will import all post/page keywords from BloggerHigh SEO. Continue?', OPSEO_TEXT_DOMAIN);?>')" class="button" type="submit" name="<?php echo OPSEO_PREFIX;?>_import_bloggerhigh" value="<?php _e('Import BloggerHigh SEO Keywords', OPSEO_TEXT_DOMAIN);?>" style="margin-top: 5px !important;" /></p></td>

						</tr>
						</table>

					</td>

					<td valign="top" width="50%">

						<table border="0" cellspacing="0" cellpadding="0">
						<tr><td><h3 style="padding:0 !important;margin:10px 0 !important;"><?php _e('System Reset/Uninstall', OPSEO_TEXT_DOMAIN);?></h3><p><?php _e('Warning: There is no way to recover this data later.', OPSEO_TEXT_DOMAIN);?></p></td></tr>
						<tr>

						<td valign="top">

						<p><input onclick="return confirm('<?php _e('This will clear all keywords and scores from all posts/pages. Continue?', OPSEO_TEXT_DOMAIN);?>')" class="button" type="submit" name="<?php echo OPSEO_PREFIX;?>_clear_all_keywords" value="<?php _e('Clear All Keywords', OPSEO_TEXT_DOMAIN);?>" style="margin-top: 5px !important;" />

						<input type="hidden" name="updated" value="true" /><input onclick="return confirm('<?php _e('This will reset all options to the default settings. Continue?', OPSEO_TEXT_DOMAIN);?>')" class="button" type="submit" name="<?php echo OPSEO_PREFIX;?>_reset_options" value="<?php _e('Reset Options To Defaults', OPSEO_TEXT_DOMAIN);?>" style="margin-top: 5px !important;" />

						<input onclick="return confirm('<?php printf(__('This will clear all keywords and scores from all posts/pages and uninstall the %s plugin. Continue?', OPSEO_TEXT_DOMAIN), OPSEO_NAME);?>')" class="button" type="submit" name="<?php echo OPSEO_PREFIX;?>_uninstall_plugin" value="<?php echo __('Uninstall', OPSEO_TEXT_DOMAIN).' '.OPSEO_NAME;?>" style="margin-top: 5px !important;" /></p></td>

						</tr>
						</table>

					</td>
					</tr>
					</table>


				</form>
			</div>