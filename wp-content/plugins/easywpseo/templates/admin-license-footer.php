			<?php if(!$this->licenseHide){?>

			<?php include_once('admin-importexport-settings.php');?>

			<div class="updated" style="margin-top: 20px;clear:both;">
				<h3 style="margin: 10px 0 0 0;"><?php echo $this->license->getLicenseName();?> <?php _e('License', OPSEO_TEXT_DOMAIN);?></h3>
				<p><?php echo $this->license->getLicenseUsage();?></p>
				<?php if($this->license->getLicenseType() != 'developer'){?>
					<p><input onclick="location.href='<?php echo $this->license->getUpgradeURL();?>';" class="button" type="button" name="upgrade_plugin" value="<?php _e('Upgrade Plugin', OPSEO_TEXT_DOMAIN);?>" /></p>
					<?php echo $this->license->getUpgradeMessage();?>
				<?php } else {?>

						<div style="padding-bottom:15px !important;"><form method="post" action="<?php echo $_SERVER['PHP_SELF'].'?page='.OPSEO_PREFIX.'-settings';?>"><input type="hidden" name="updated" value="true" /><input onclick="return confirm('<?php _e('This will hide the license settings from your client. Continue?', OPSEO_TEXT_DOMAIN);?>')" class="button" type="submit" name="<?php echo OPSEO_PREFIX;?>_hide_license" value="<?php _e('Hide License Information', OPSEO_TEXT_DOMAIN);?>" /></form></div>

					</form>

				<?php }?>
			</div>
			<?php }?>