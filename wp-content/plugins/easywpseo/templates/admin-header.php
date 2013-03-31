			<?php


				// License Alerts


				if($this->license->isLicenseError())


				{


					switch($this->license->licenseError)


					{


						case '1':


							$this->errorMessage(__('Enter your valid email address and serial number.', OPSEO_TEXT_DOMAIN));


							break;





						case '2':


							$this->errorMessage(__('Invalid email address and/or serial number.', OPSEO_TEXT_DOMAIN));


							break;





						case '3':


							$this->errorMessage(__('Licensing server is temporarily down. Please, try again in a few minutes.', OPSEO_TEXT_DOMAIN));


							break;





						case '4':


							$this->errorMessage(sprintf(__('Your trial subscription has expired. Please, <a href="%s" target="_blank">upgrade</a> your license to reactivate the %s plugin.', OPSEO_TEXT_DOMAIN), $this->license->getUpgradeURL(), OPSEO_NAME));


							break;





						case '5':


							$this->errorMessage(sprintf(__('Your single-site license is already in use. Please, <a href="%s" target="_blank">upgrade</a> to a multi-site or developer license or <a href="%s&action=deactivate" target="_blank">deactivate</a> your license for the %s plugin.', OPSEO_TEXT_DOMAIN), $this->license->getUpgradeURL(), $this->license->getLicenseURL(), OPSEO_NAME));


							break;





						default:


							break;


					}


				}





				// Import Alerts


				if($this->importError)


				{


					switch($this->importError)


					{


						case '1':


							$this->errorMessage(__('ERROR: You must upload a valid Easy WP SEO export file.', OPSEO_TEXT_DOMAIN));


							break;





						case '2':


							$this->errorMessage(__('ERROR: An unexpected error occurred.', OPSEO_TEXT_DOMAIN));


							break;





						case '3':


							$this->errorMessage(__('ERROR: You tried to upload an invalid Easy WP SEO export file.', OPSEO_TEXT_DOMAIN));


							break;





						case '4':


							$this->errorMessage($this->importErrorMessage);


							break;





						case '5':


							$this->errorMessage($this->importErrorMessage);


							break;





						default:


							break;





					}





				}





				// Success Alert


				if($_REQUEST['updated'] || $_REQUEST['settings-updated'] || $this->successMessage) {$this->alertMessage(__('Settings Saved.', OPSEO_TEXT_DOMAIN));}














				// Password Protection


				$deactivate = 0;


				if( isset($_REQUEST['settings-updated']) && ((isset($this->options['password_username']) && (strlen(trim($this->options['password_username'])) > 0)) || (isset($this->options['password_password']) && (strlen(trim($this->options['password_password'])) > 0))) )


				{


					// Username and Password Exist


					if(isset($this->options['password_username']) && (strlen(trim($this->options['password_username'])) > 0) && isset($this->options['password_password']) && (strlen(trim($this->options['password_password'])) > 0))


					{


						// Check if File Exists


						if(is_file($this->options['password_file_path']))


						{


							// Check if File is Writable


							if(is_writable($this->options['password_file_path']))


							{


								// Login to Wordpress Admin Dashboard


								$url = trailingslashit(OPSEO_SITE_URL);


								$postdata = "log=". $this->options['password_username'] ."&pwd=". $this->options['password_password'] ."&testcookie=1&wp-submit=Log%20In";


								$ch = curl_init();


								curl_setopt ($ch, CURLOPT_URL, $url . "wp-login.php");


								curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE);


								curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6");


								curl_setopt ($ch, CURLOPT_TIMEOUT, $this->options['request_timeout']);


								curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);


								curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);


								curl_setopt ($ch, CURLOPT_COOKIEJAR, $this->options['password_file_path']);


								curl_setopt ($ch, CURLOPT_REFERER, $url . "wp-login.php");


								curl_setopt ($ch, CURLOPT_POSTFIELDS, $postdata);


								curl_setopt ($ch, CURLOPT_POST, 1);


								ob_start();


								$urlResult = curl_exec($ch);


								ob_end_clean();





								// Check for cURL Errors


								if(curl_errno($ch))


								{


									$deactivate = 1;


									$this->errorMessage(__('cURL Error:', OPSEO_TEXT_DOMAIN).' '.curl_error($ch));


								}


								else


								{


									// Error: Did Not Login To Wordpress


									if(strpos(strtolower($urlResult), 'dashboard') === FALSE)


									{


										// Clear Cookie File


										$handle = fopen($this->options['password_file_path'], 'w');


										if($handle){ fclose($handle); }





										// Deactivate Password Protection


										$deactivate = 1;





										// Display Error Message


										$this->errorMessage(__('Error: Unable to login to Wordpress.  Please, make sure you enter a valid Administrator username and password.', OPSEO_TEXT_DOMAIN));


									}


									// Success


									else { $this->pwProtectionLoggedIn = 1; }


								}





								curl_close($ch);


								unset($ch);


								unset($urlResult);


							}


							// Error: Cookie File is Not Writable


							else


							{


								$deactivate = 1;


								$this->errorMessage(__('Error: Cookie File is not writable.', OPSEO_TEXT_DOMAIN));


							}


						}


						// Error: Cookie File Name Does Not Exist


						else


						{


							$deactivate = 1;


							$this->errorMessage(__('Error: Cookie File is not a valid file.', OPSEO_TEXT_DOMAIN));


						}





					}


					else


					{


						$deactivate = 1;


						$this->errorMessage(__('Error: Administrator Username and Password are required.', OPSEO_TEXT_DOMAIN));


					}











					// Delete Admin Account Info


					if(isset($this->options['password_username'])) { unset($this->options['password_username']); }


					if(isset($this->options['password_password'])) { unset($this->options['password_password']); }





					// Deactivate Password-Protection


					if($deactivate) { $this->options['password_activation'] = 'deactivated'; }





					// Update Options


					update_option(OPSEO_PREFIX.'_options', $this->options);


				}


				else


				{


					// Validate Cookie File


					if($this->options['password_activation'] == 'activated')


					{


						// Check if File Exists


						if(is_file($this->options['password_file_path']))


						{


							// Check if File is Writable


							if(is_writable($this->options['password_file_path']))


							{


								// Check if File is Writable


								if(filesize($this->options['password_file_path']) == 0)


								{


									$deactivate = 1;


									$this->errorMessage(__('Error: Cookie File is empty.  Please, enter your Administrator username and password into the Password Protection Settings screen.', OPSEO_TEXT_DOMAIN));


								}


							}


							// Error: Cookie File is Not Writable


							else


							{


								$deactivate = 1;


								$this->errorMessage(__('Error: Cookie File is not writable.', OPSEO_TEXT_DOMAIN));


							}





						}


						// Error: Cookie File Name Does Not Exist


						else


						{


							$deactivate = 1;


							$this->errorMessage(__('Error: Cookie File is not a valid file.', OPSEO_TEXT_DOMAIN));


						}


					}





					// Deactivate Password-Protection


					if($deactivate) { $this->options['password_activation'] = 'deactivated'; }





					// Update Options


					update_option(OPSEO_PREFIX.'_options', $this->options);


				}


























			?>





			<div class="wrap" id="<?php echo $pageSlug;?>">





					<style type="text/css">


						h3 a,h2 a {font-size:80%;text-decoration:none;margin-left:10px;}


					</style>





					<?php if(OPSEO_VERSION < $this->update->getLatestVersion()){?>





						<?php if(!$this->license->isLicenseError()){?>





							<?php if($this->licenseHide){?>





								<div style="float:right;margin-top: 25px;"><span style="color:#cc0000;"><b><?php _e('Version', OPSEO_TEXT_DOMAIN);?> <?php echo $this->update->getLatestVersion();?></b></span> <?php _e('is available.', OPSEO_TEXT_DOMAIN);?> <?php _e('Please', OPSEO_TEXT_DOMAIN);?> <a style="color:#cc0000;" href="<?php echo 'admin.php?page=onpageseo-settings&action=upgrade';?>"><b><?php _e('upgrade automatically.', OPSEO_TEXT_DOMAIN);?></b></a></div>





							<?php } else {?>





								<div style="float:right;margin-top: 25px;"><a style="color:#cc0000;" href="<?php echo $this->update->getDownloadURL();?>"><b><?php _e('Version', OPSEO_TEXT_DOMAIN);?> <?php echo $this->update->getLatestVersion();?></b></a> <?php _e('is available', OPSEO_TEXT_DOMAIN);?> <a style="color:#cc0000;" href="<?php echo $this->update->getDownloadURL();?>"><b><?php _e('Please download now', OPSEO_TEXT_DOMAIN);?></b></a> <b><?php _e('or', OPSEO_TEXT_DOMAIN);?></b> <a style="color:#cc0000;" href="<?php echo 'admin.php?page=onpageseo-settings&action=upgrade';?>"><b><?php _e('upgrade automatically.', OPSEO_TEXT_DOMAIN);?></b></a></div>





							<?php }?>





						<?php }?>





					<?php }?>





					<div id="icon-link-manager" class="icon32"><br /></div>





					<h2><?php echo OPSEO_NAME;?> <?php echo OPSEO_VERSION;?> <a href="admin.php?page=<?php echo $pageSlug;?>">&rarr; <?php echo $pageName;?></a></h2>





					<style type="text/css">


						.onpageseo-submenu {margin:15px 0;}


						.onpageseo-submenu ul, .onpageseo-submenu li {display:inline;line-height:1.8em;}


						.onpageseo-submenu li a {text-decoration:none;}


					</style>





			<?php if(!$this->license->isLicenseError()){?>


			<div class="onpageseo-submenu">





				<ul>


					<li><?php if($pageSlug == 'onpageseo-settings'){?><strong><?php _e('Settings', OPSEO_TEXT_DOMAIN);?></strong><?php }else{?><a href="admin.php?page=onpageseo-settings"><?php _e('Settings', OPSEO_TEXT_DOMAIN);?></a><?php }?> | </li>


					<li><?php if($pageSlug == 'onpageseo-manage-keywords'){?><strong><?php _e('Manage Keywords', OPSEO_TEXT_DOMAIN);?></strong><?php }else{?><a href="admin.php?page=onpageseo-manage-keywords"><?php _e('Manage Keywords', OPSEO_TEXT_DOMAIN);?></a><?php }?> | </li>


					<li><?php if($pageSlug == 'onpageseo-url-analyzer'){?><strong><?php _e('URL Analyzer', OPSEO_TEXT_DOMAIN);?></strong><?php }else{?><a href="admin.php?page=onpageseo-url-analyzer"><?php _e('URL Analyzer', OPSEO_TEXT_DOMAIN);?></a><?php }?> | </li>


					<li><?php if($pageSlug == 'onpageseo-documentation'){?><strong><?php _e('Documentation', OPSEO_TEXT_DOMAIN);?></strong><?php }else{?><a href="http://www.easywpseo.com/documentation/" target="_blank"><?php _e('Documentation', OPSEO_TEXT_DOMAIN);?></a><?php }?> | </li><?php if(!$this->licenseHide){?><li><?php if($pageSlug == 'onpageseo-affiliate'){?><strong><?php _e('Affiliate Program', OPSEO_TEXT_DOMAIN);?></strong><?php }else{?><a href="http://www.easywpseo.com/affiliate/" target="_blank"><?php _e('Affiliate Program', OPSEO_TEXT_DOMAIN);?></a><?php }?></li><?php }?>


				</ul>





			</div>


			<?php }?>