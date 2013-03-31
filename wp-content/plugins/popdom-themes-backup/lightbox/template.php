<div class="popup-dom-lightbox-wrapper" id="<?php echo $lightbox_id?>"<?php echo $delay_hide ?>>
	<div class="lightbox-overlay"></div>
	<div class="lightbox-main lightbox-color-<?php echo $color ?>">
		<a href="#" class="lightbox-close" id="<?php echo $lightbox_close_id?>"><span>Close</span></a>
		<div class="lightbox-top">
			<div class="lightbox-top-content">
				<p class="heading"><?php echo $fields['title'] ?></p>
				<div class="bullet-listx">
                    <ul class="bullet-list"><?php
                        $count = 1;
                        if(isset($list_items) && count($list_items) > 0):
                            foreach($list_items as $l):
                                if($count>4)
                                    break;?>
                        <li><?php echo $l ?></li><?php
                                $count++;
                            endforeach;
                        endif;?>
                    </ul>
					<div class="clear"></div>
				</div>
			</div>
		</div>
		<div class="lightbox-middle-bar">
			<p class="heading2"><?php echo $fields['form_header'] ?></p>
		</div>
		<?php if($provider != 'form' && $provider != 'nm'): ?>
		<div class="lightbox-bottom">
			<div class="lightbox-signup-panel">
				<div class="wait" style="display:none;"><img src="<?php echo $this->plugin_url.'css/images/wait.gif'; ?>" /></div>
	            <div class="form">
	                <div>
	                    <?php echo $inputs['hidden'].$fstr; ?>
	                    <input type="submit" value="<?php echo $fields['submit_button'] ?>" src="<?php echo $theme_url?>/images/trans.png" class="<?php echo $button_color?>-button" />
	                    <p class="secure"><?php echo $fields['footer_note'] ?></p>
	                </div>
	            </div>
			</div>
		</div>
		<?php else: ?>
		<div class="lightbox-bottom">
			<div class="lightbox-signup-panel">
	            <form method="post" action="<?php echo $form_action ?>"<?php echo $target ?>>
	                <div>
	                    <?php echo $inputs['hidden'].$fstr ?>
	                    <input type="submit" value="<?php echo $fields['submit_button'] ?>" src="<?php echo $theme_url?>/images/trans.png" class="<?php echo $button_color?>-button" />
						<p class="secure"><?php echo $fields['footer_note'] ?></p>
	                </div>
	            </form>	
            </div>
		</div>
		<?php endif; ?>
			<?php echo $promote_link ?>
	</div>
</div>