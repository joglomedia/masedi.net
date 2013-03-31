			<?php
				// Error Alerts

				if($this->strExists($this->networkAdminError))
				{
					switch($this->networkAdminError)
					{
						case '1':
							$this->errorMessage(__('ERROR: Select a site to use for the default settings (Step #1).', OPSEO_TEXT_DOMAIN));
							break;

						case '2':
							$this->errorMessage(__('ERROR: Select the sites you want to update (Step #2).', OPSEO_TEXT_DOMAIN));
							break;
					}
				}
				// Success Alert
				elseif($this->strExists($_REQUEST['action']) && !$this->strExists($this->networkAdminError))
				{
					$this->alertMessage(__('Settings Updated.', OPSEO_TEXT_DOMAIN));
				}
			?>


			<div class="wrap" id="<?php echo $pageSlug;?>">



					<style type="text/css">

						h3 a,h2 a {font-size:80%;text-decoration:none;margin-left:10px;}

					</style>



					<div id="icon-link-manager" class="icon32"><br /></div>



					<h2><?php echo OPSEO_NAME;?> <?php echo OPSEO_VERSION;?> <a href="admin.php?page=<?php echo $pageSlug;?>">&rarr; <?php echo $pageName;?></a></h2>



					<style type="text/css">

						.onpageseo-submenu {margin:15px 0;}

						.onpageseo-submenu ul, .onpageseo-submenu li {display:inline;line-height:1.8em;}

						.onpageseo-submenu li a {text-decoration:none;}

					</style>

				<div class="onpageseo-submenu">


				<ul>

					<li><?php if($pageSlug == 'onpageseo-documentation'){?><strong><?php _e('Documentation', OPSEO_TEXT_DOMAIN);?></strong><?php }else{?><a href="http://www.easywpseo.com/documentation/" target="_blank"><?php _e('Documentation', OPSEO_TEXT_DOMAIN);?></a><?php }?> | </li><li><?php if($pageSlug == 'onpageseo-affiliate'){?><strong><?php _e('Affiliate Program', OPSEO_TEXT_DOMAIN);?></strong><?php }else{?><a href="http://www.easywpseo.com/affiliate/" target="_blank"><?php _e('Affiliate Program', OPSEO_TEXT_DOMAIN);?></a><?php }?></li>

				</ul>


				</div>