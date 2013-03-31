		<?php $this->adminHeader('onpageseo-network-settings', __('Network Settings', OPSEO_TEXT_DOMAIN), 2); ?>
		<form action="admin.php?page=onpageseo-network-settings&action=network-settings" method="post">

		<div id="opseo-tabs" class="inside">
			<ul>
				<li class="opseotabs"><a href="#opseo-network" style="margin-left:0 !important;"><?php _e('Network Transfer Settings', OPSEO_TEXT_DOMAIN);?></a></li>
			</ul>

			<div id="opseo-network" class="opseo-tabs-panel">

				<p><?php _e('Here is how to transfer the Easy WP SEO settings from a default site to multiple sites on your network:', OPSEO_TEXT_DOMAIN);?></p>

				<h4 style="padding:10px 0 5px 0 !important;margin:15px 0 10px 0 !important;border-bottom:1px solid rgb(200,200,200);"><?php _e('STEP #1: Select The Default Site', OPSEO_TEXT_DOMAIN);?></h4>

				<table class="form-table">

				<tr valign="top">
				<th scope="row"><span style="font-size:12px;"><em><?php _e('Select The Default Site With Settings You Want To Transfer To Other Sites On The Network', OPSEO_TEXT_DOMAIN);?></em></span></th>
				<td><select name="onpageseoBlogID" id="onpageseoBlogID">


					<?php
						global $wpdb;

						$netBlogs = $wpdb->get_results($wpdb->prepare("SELECT blog_id,path,domain FROM $wpdb->blogs"));

						foreach ($netBlogs as $netBlog)
						{
							$blogLabel = (function_exists('is_subdomain_install') && is_subdomain_install()) ? $netBlog->domain : $netBlog->path;
							echo '<option value="'.$netBlog->blog_id.'" label="'.$blogLabel.'"'.selected($_REQUEST['onpageseoBlogID'], $netBlog->blog_id).'>'.$blogLabel.'</option>';
						}
					?>

					</select></td>

				</tr>

				</table>

				<h4 style="padding:10px 0 5px 0 !important;margin:15px 0 10px 0 !important;border-bottom:1px solid rgb(200,200,200);"><?php _e('STEP #2: Select The Sites To Update', OPSEO_TEXT_DOMAIN);?></h4>


				<table class="form-table">

				<tr valign="top">
				<th scope="row"><span style="font-size:12px;"><em><?php _e('Select The Sites That Will Receive Settings From The Default Site', OPSEO_TEXT_DOMAIN);?></em></span></th>
				<td><select name="onpageseoSecondaryIDs[]" id="onpageseoSecondaryIDs" multiple="multiple" size="10">


					<?php
						global $wpdb;

						$netBlogs = $wpdb->get_results($wpdb->prepare("SELECT blog_id,path,domain FROM $wpdb->blogs"));

						foreach ($netBlogs as $netBlog)
						{
							$blogLabel = (function_exists('is_subdomain_install') && is_subdomain_install()) ? $netBlog->domain : $netBlog->path;
							echo '<option value="'.$netBlog->blog_id.'" label="'.$blogLabel.'">'.$blogLabel.'</option>';
						}
					?>

					</select></td>

				</tr>

				</table>

			</div>

		</div>

		<div class="opseo-submit">
			<input type="submit" name="Submit" class="button-primary" value="<?php _e('Save Changes', OPSEO_TEXT_DOMAIN);?>" />
		</div>

		</form>




		<form action="admin.php?page=onpageseo-network-settings&action=network-new-sites" method="post">

		<div id="opseo-import-export-tabs">

			<ul>

				<li class="importexporttabs"><a href="#opseo-network-new-sites" style="margin-left:0 !important;"><?php _e('Network New Site Settings', OPSEO_TEXT_DOMAIN);?></a></li>

			</ul>



			<div id="opseo-network-new-sites" class="import-export-tabs-panel">

				<p><?php _e('Here is how to transfer the settings from a default site to all new sites on the network:', OPSEO_TEXT_DOMAIN);?></p>

				<h4 style="padding:10px 0 5px 0 !important;margin:15px 0 10px 0 !important;border-bottom:1px solid rgb(200,200,200);"><?php _e('Select The Default Site', OPSEO_TEXT_DOMAIN);?></h4>

				<table class="form-table">

				<tr valign="top">
				<th scope="row"><span style="font-size:12px;"><em><?php _e('Select The Default Site With Settings You Want To Transfer To All New Sites On The Network', OPSEO_TEXT_DOMAIN);?></em></span></th>
				<td><select name="onpageseoNewBlogID" id="onpageseoNewBlogID">
					<option value="" label="Turned Off"<?php selected($this->networkAdminNewSites, '');?>>Turned Off</option>


					<?php
						global $wpdb;

						$netBlogs = $wpdb->get_results($wpdb->prepare("SELECT blog_id,path,domain FROM $wpdb->blogs"));

						foreach ($netBlogs as $netBlog)
						{
							$blogLabel = (function_exists('is_subdomain_install') && is_subdomain_install()) ? $netBlog->domain : $netBlog->path;
							echo '<option value="'.$netBlog->blog_id.'" label="'.$blogLabel.'"'.selected($this->networkAdminNewSites, $netBlog->blog_id).'>'.$blogLabel.'</option>';
						}
					?>

					</select></td>

				</tr>

				</table>

			</div>



		</div>



		<div class="opseo-submit">

			<input type="submit" name="Submit" class="button-primary" value="<?php _e('Save Changes', OPSEO_TEXT_DOMAIN);?>" />

		</div>



		</form>















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
});

</script>