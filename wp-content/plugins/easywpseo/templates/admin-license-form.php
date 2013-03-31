				<p><?php printf(__('Enter your %s License information:', OPSEO_TEXT_DOMAIN), OPSEO_NAME);?></p>

				<table class="form-table">

				<tr valign="top">
				<th scope="row"><label for="onpageseo_options[license_email]"><?php _e('Email Address', OPSEO_TEXT_DOMAIN);?></label></th>
				<td><input type="text" name="onpageseo_options[license_email]" value="<?php echo $this->options['license_email'];?>" class="large-text" /><br /><em><?php _e('Enter the email address you used to purchase the software.', OPSEO_TEXT_DOMAIN);?></em></td>
				</tr>

				<tr valign="top" style="background-color:rgb(238,238,238);">
				<th scope="row"><label for="onpageseo_options[license_serial]"><?php _e('Serial Number', OPSEO_TEXT_DOMAIN);?></label></th>
				<td><input type="text" name="onpageseo_options[license_serial]" value="<?php echo $this->options['license_serial'];?>" class="large-text" /><br /><a href="http://www.easywpseo.com/forgot-serial-number/" target="_blank"><?php _e('Forgot your serial number?', OPSEO_TEXT_DOMAIN);?></a></td>
				</tr>

				</table>