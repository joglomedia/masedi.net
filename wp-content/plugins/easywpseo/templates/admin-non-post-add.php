<?php global $screen_layout_columns;?>

<div class="error" id="opseo-url-error" style="display:none;"></div>

<form name="addurl" id="addurl" method="post" action="admin.php?page=onpageseo-url-analyzer" onsubmit="return jQuery(this).opseoURLValidation();">
<input type="hidden" name="nonpost-action" value="add" />
<input type="hidden" name="updated" value="true" />

			<div id="poststuff" class="metabox-holder<?php echo 2 == $screen_layout_columns ? ' has-right-sidebar' : ''; ?>">
				<div id="side-info-column" class="inner-sidebar">

					<?php do_meta_boxes($this->nonPostHook, 'side', $data); ?>

				</div>
				<div id="post-body" class="has-sidebar">
					<div id="post-body-content" class="has-sidebar-content">
						<?php do_meta_boxes($this->nonPostHook, 'normal', $data); ?>

						<p>
							<input type="submit" value="<?php _e('Analyze', OPSEO_TEXT_DOMAIN);?>" class="button-primary" name="opseo-submit-button" id="opseo-submit-button"/> <a href="admin.php?page=onpageseo-url-analyzer" class="button"><?php _e('Cancel', OPSEO_TEXT_DOMAIN);?></a>
						</p>
					</div>
				</div>
				<br class="clear"/>
								
			</div>	
		</form>