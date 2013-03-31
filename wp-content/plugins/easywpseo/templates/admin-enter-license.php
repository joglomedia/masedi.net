		<?php $this->adminHeader('onpageseo-settings', __('Settings', OPSEO_TEXT_DOMAIN)); ?>

		<?php if($this->license->isLicenseError() != 4) {?>

		<form action="options.php" method="post">
		<?php settings_fields('onpageseo_settings');?>

		<div id="opseo-tabs" class="inside">
			<ul>
				<li class="opseotabs"><a href="#opseo-license"><?php _e('License Settings', OPSEO_TEXT_DOMAIN);?></a></li>
			</ul>

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

		<?php if(!$this->licenseHide){include_once('admin-importexport-settings.php');}?>

		<?php if(!$this->license->isLicenseError()){$this->licenseFooter();}?>


	</div>



		<?php }?>

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