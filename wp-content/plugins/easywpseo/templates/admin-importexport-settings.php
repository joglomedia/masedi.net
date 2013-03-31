		<div id="opseo-import-export-tabs"> 
			<ul> 
				<li class="importexporttabs"><a href="#opseo-import" style="margin:0 !important;"><?php _e('Import Settings', OPSEO_TEXT_DOMAIN);?></a></li> 
				<li class="importexporttabs"<?php if($this->license->isLicenseError()){ echo ' style="display:none;"';}?>><a href="#opseo-export"><?php _e('Export Settings', OPSEO_TEXT_DOMAIN);?></a></li> 
			</ul> 
 
			<div id="opseo-import" class="import-export-tabs-panel">

				<h4 style="padding:0 0 5px 0 !important;margin:0 0 10px 0 !important;border-bottom:1px solid rgb(200,200,200);"><?php _e('Import Settings', OPSEO_TEXT_DOMAIN);?></h4> 

				<p><?php _e('Import settings from an Easy WP SEO export file.', OPSEO_TEXT_DOMAIN);?></p>

				<form method="post" action="admin.php?page=onpageseo-settings" enctype="multipart/form-data">
					<p><input type="file" name="file" id="onpageseo-import-settings-file" /></p>
					<p><input onclick="return confirm('<?php _e('Warning: This will import the settings from an Easy WP SEO export file and overwrite your current settings. Continue?', OPSEO_TEXT_DOMAIN);?>')" class="button-primary" type="submit" name="<?php echo OPSEO_PREFIX;?>_import_settings" value="<?php _e('Import', OPSEO_TEXT_DOMAIN);?>" style="margin-top: 5px !important;" /></p>
				</form>

			</div>

			<div id="opseo-export" class="import-export-tabs-panel"<?php if($this->license->isLicenseError()){ echo ' style="display:none;"';}?>>

				<h4 style="padding:0 0 5px 0 !important;margin:0 0 10px 0 !important;border-bottom:1px solid rgb(200,200,200);"><?php _e('Export Settings', OPSEO_TEXT_DOMAIN);?></h4>

				<p>Export Easy WP SEO settings from your Wordpress site.</p>

				<form method="post" action="admin.php?page=onpageseo-settings">
					<input type="hidden" name="action" value="export-settings" />
					<p><input onclick="return confirm('<?php _e('This will export the Easy WP SEO settings. Continue?', OPSEO_TEXT_DOMAIN);?>')" class="button-primary" type="submit" name="<?php echo OPSEO_PREFIX;?>_export_settings" value="<?php _e('Export', OPSEO_TEXT_DOMAIN);?>" style="margin-top: 5px !important;" /></p>
				</form>

			</div>

		</div>