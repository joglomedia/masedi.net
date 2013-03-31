<?php if ( !defined('ABSPATH') ) die('No direct access');

add_action('admin_footer', 'opl_media_graphics');
function opl_media_graphics() {
	echo '<div id="opl-media" style="display:none">';
	?>
	<ul id="opl-meta" style="margin-top:20px;">
	<li class="opl-property">
		<label for="opl_insert_graphic"><?php _e('Select a Graphic', 'opl'); ?></label>
		<select name="opl_insert_graphic" id="opl_insert_graphic" class="widefat">
			<optgroup label="Yellow Order Buttons">
				<option value="<?php echo OPL_URL; ?>images/buttons/big-yellow-addtocart.png">Add To Cart (yellow)</option>
				<option value="<?php echo OPL_URL; ?>images/buttons/big-yellow-addtocart-circle.png">Add To Cart /w Circle (yellow)</option>
				<option value="<?php echo OPL_URL; ?>images/buttons/big-yellow-checkout.png">Checkout! (yellow)</option>
				<option value="<?php echo OPL_URL; ?>images/buttons/big-yellow-checkout-circle.png">Checkout! /w Circle (yellow)</option>
				<option value="<?php echo OPL_URL; ?>images/buttons/big-yellow-download.png">Download Now (yellow)</option>
				<option value="<?php echo OPL_URL; ?>images/buttons/big-yellow-download-circle.png">Download Now /w Circle (yellow)</option>
				<option value="<?php echo OPL_URL; ?>images/buttons/big-yellow-order.png">Order Now (yellow)</option>
				<option value="<?php echo OPL_URL; ?>images/buttons/big-yellow-order-circle.png">Order Now /w Circle (yellow)</option>
				<option value="<?php echo OPL_URL; ?>images/buttons/big-yellow-register.png">Register Now! (yellow)</option>
				<option value="<?php echo OPL_URL; ?>images/buttons/big-yellow-register-circle.png">Register Now! /w Circle (yellow)</option>
				<option value="<?php echo OPL_URL; ?>images/buttons/big-yellow-signup.png">Sign Up Now (yellow)</option>
				<option value="<?php echo OPL_URL; ?>images/buttons/big-yellow-signup-circle.png">Sign Up Now /w Circle (yellow)</option>
			</optgroup>
			<optgroup label="Orange Order Buttons">
				<option value="<?php echo OPL_URL; ?>images/buttons/big-orange-addtocart.png">Add To Cart (orange)</option>
				<option value="<?php echo OPL_URL; ?>images/buttons/big-orange-addtocart-circle.png">Add To Cart /w Circle (orange)</option>
				<option value="<?php echo OPL_URL; ?>images/buttons/big-orange-checkout.png">Checkout! (orange)</option>
				<option value="<?php echo OPL_URL; ?>images/buttons/big-orange-checkout-circle.png">Checkout! /w Circle (orange)</option>
				<option value="<?php echo OPL_URL; ?>images/buttons/big-orange-download.png">Download Now (orange)</option>
				<option value="<?php echo OPL_URL; ?>images/buttons/big-orange-download-circle.png">Download Now /w Circle (orange)</option>
				<option value="<?php echo OPL_URL; ?>images/buttons/big-orange-order.png">Order Now (orange)</option>
				<option value="<?php echo OPL_URL; ?>images/buttons/big-orange-order-circle.png">Order Now /w Circle (orange)</option>
				<option value="<?php echo OPL_URL; ?>images/buttons/big-orange-register.png">Register Now! (orange)</option>
				<option value="<?php echo OPL_URL; ?>images/buttons/big-orange-register-circle.png">Register Now! /w Circle (orange)</option>
				<option value="<?php echo OPL_URL; ?>images/buttons/big-orange-signup.png">Sign Up Now (orange)</option>
				<option value="<?php echo OPL_URL; ?>images/buttons/big-orange-signup-circle.png">Sign Up Now /w Circle (orange)</option>
			</optgroup>
			<optgroup label="Payment Logos">
				<option value="<?php echo OPL_URL; ?>images/buttons/cc-paypal.png">Credit Card + Paypal Logos</option>
				<option value="<?php echo OPL_URL; ?>images/buttons/cc.png">Credit Card Logos (no Paypal)</option>
			</optgroup>
			<optgroup label="Add To Cart Boxes">
				<option value="<?php echo OPL_URL; ?>images/buttons/order-box1.png">Add To Cart Box #1</option>
				<option value="<?php echo OPL_URL; ?>images/buttons/order-box2.png">Add To Cart Box #2</option>
				<option value="<?php echo OPL_URL; ?>images/buttons/order-box3.png">Add To Cart Box #3</option>
			</optgroup>
			<optgroup label="Guarantee Seals">
				<option value="<?php echo OPL_URL; ?>images/badges/badges1-gold.png">100% Guarantee (gold)</option>
				<option value="<?php echo OPL_URL; ?>images/badges/badges1-red.png">100% Guarantee (red)</option>
				<option value="<?php echo OPL_URL; ?>images/badges/badges1-green.png">100% Guarantee (green)</option>
				<option value="<?php echo OPL_URL; ?>images/badges/badges1-blue.png">100% Guarantee (blue)</option>
				<option value="<?php echo OPL_URL; ?>images/badges/badges2-gold.png">30 Day Guarantee (gold)</option>
				<option value="<?php echo OPL_URL; ?>images/badges/badges2-red.png">30 Day Guarantee (red)</option>
				<option value="<?php echo OPL_URL; ?>images/badges/badges2-green.png">30 Day Guarantee (green)</option>
				<option value="<?php echo OPL_URL; ?>images/badges/badges2-blue.png">30 Day Guarantee (blue)</option>
				<option value="<?php echo OPL_URL; ?>images/badges/badges3-gold.png">60 Day Guarantee (gold)</option>
				<option value="<?php echo OPL_URL; ?>images/badges/badges3-red.png">60 Day Guarantee (red)</option>
				<option value="<?php echo OPL_URL; ?>images/badges/badges3-green.png">60 Day Guarantee (green)</option>
				<option value="<?php echo OPL_URL; ?>images/badges/badges3-blue.png">60 Day Guarantee (blue)</option>
			</optgroup>
			<optgroup label="Guarantee Boxes">
				<option value="<?php echo OPL_URL; ?>images/graphics/guarantee-30-blue.png">30 Day Guarantee (blue)</option>
				<option value="<?php echo OPL_URL; ?>images/graphics/guarantee-60-blue.png">60 Day Guarantee (blue)</option>
				<option value="<?php echo OPL_URL; ?>images/graphics/guarantee-30-green.png">30 Day Guarantee (green)</option>
				<option value="<?php echo OPL_URL; ?>images/graphics/guarantee-60-green.png">60 Day Guarantee (green)</option>
				<option value="<?php echo OPL_URL; ?>images/graphics/guarantee-30-yellow.png">30 Day Guarantee (yellow)</option>
				<option value="<?php echo OPL_URL; ?>images/graphics/guarantee-60-yellow.png">60 Day Guarantee (yellow)</option>
			</optgroup>
			<optgroup label="One Time Offer Graphics">
				<option value="<?php echo OPL_URL; ?>images/graphics/oto-1.png">OTO Graphic #1</option>
				<option value="<?php echo OPL_URL; ?>images/graphics/oto-2.png">OTO Graphic #2</option>
				<option value="<?php echo OPL_URL; ?>images/graphics/oto-3.png">OTO Graphic #3</option>
				<option value="<?php echo OPL_URL; ?>images/graphics/oto-4.png">OTO Graphic #4</option>
				<option value="<?php echo OPL_URL; ?>images/graphics/oto-5.png">OTO Graphic #5</option>
				<option value="<?php echo OPL_URL; ?>images/graphics/oto-6.png">OTO Graphic #6</option>
			</optgroup>
			<optgroup label="Lines/Divider">
				<option value="<?php echo OPL_URL; ?>images/line-320.png">320px Divider</option>
				<option value="<?php echo OPL_URL; ?>images/line-480.png">480px Divider</option>
				<option value="<?php echo OPL_URL; ?>images/line-720.png">720px Divider</option>
			</optgroup>
			<optgroup label="Arrows">
				<option value="<?php echo OPL_URL; ?>images/graphics/arrow-1.png">Arrow #1</option>
				<option value="<?php echo OPL_URL; ?>images/graphics/arrow-2.png">Arrow #2</option>
				<option value="<?php echo OPL_URL; ?>images/graphics/arrow-3.png">Arrow #3</option>
				<option value="<?php echo OPL_URL; ?>images/graphics/arrow-4.png">Arrow #4</option>
				<option value="<?php echo OPL_URL; ?>images/graphics/arrow-5.png">Arrow #5</option>
				<option value="<?php echo OPL_URL; ?>images/graphics/arrow-6.png">Arrow #6</option>
				<option value="<?php echo OPL_URL; ?>images/graphics/arrow-7.png">Facebook Reveal Arrow #1</option>
				<option value="<?php echo OPL_URL; ?>images/graphics/arrow-8.png">Facebook Reveal Arrow #2</option>
			</optgroup>
			<optgroup label="Graphical Texts">
				<option value="<?php echo OPL_URL; ?>images/graphics/time-sensitive.png">Attention! This Offer Is Extremely Time Sensitive #1</option>
				<option value="<?php echo OPL_URL; ?>images/graphics/time-sensitive-2.png">Attention! This Offer Is Extremely Time Sensitive #2</option>
				<option value="<?php echo OPL_URL; ?>images/graphics/new-software.png">Brand New Software</option>
				<option value="<?php echo OPL_URL; ?>images/graphics/fast-bonus-1.png">Fast Action Bonus #1</option>
				<option value="<?php echo OPL_URL; ?>images/graphics/fast-bonus-2.png">Fast Action Bonus #2</option>
				<option value="<?php echo OPL_URL; ?>images/graphics/fast-bonus-3.png">Fast Action Bonus #3</option>
				<option value="<?php echo OPL_URL; ?>images/graphics/fast-bonus-4.png">Fast Action Bonus #4</option>
				<option value="<?php echo OPL_URL; ?>images/graphics/fast-bonus-5.png">Fast Action Bonus #5</option>
				<option value="<?php echo OPL_URL; ?>images/graphics/fast-bonus-6.png">Fast Action Bonus #6</option>
				<option value="<?php echo OPL_URL; ?>images/graphics/fast-bonus-7.png">Fast Action Bonus #7</option>
				<option value="<?php echo OPL_URL; ?>images/graphics/fast-bonus-8.png">Fast Action Bonus #8</option>
				<option value="<?php echo OPL_URL; ?>images/graphics/fast-bonus-9.png">Fast Action Bonus #9</option>
				<option value="<?php echo OPL_URL; ?>images/graphics/fast-bonus-10.png">Fast Action Bonus #10</option>
				<option value="<?php echo OPL_URL; ?>images/graphics/first-time.png">For The First Time Ever...</option>
				<option value="<?php echo OPL_URL; ?>images/graphics/here-proof.png">Here Is The Proof</option>
				<option value="<?php echo OPL_URL; ?>images/graphics/powerful.png">It's Powerful And Effective</option>
				<option value="<?php echo OPL_URL; ?>images/graphics/limited.png">Limited Time Offer #1</option>
				<option value="<?php echo OPL_URL; ?>images/graphics/limited-2.png">Limited Time Offer #2</option>
				<option value="<?php echo OPL_URL; ?>images/graphics/save-time-effort.png">Save Time And Effort</option>
				<option value="<?php echo OPL_URL; ?>images/graphics/save-time.png">Save Time, Save Effort, Save Money</option>
				<option value="<?php echo OPL_URL; ?>images/graphics/secret-exposed.png">Secret Exposed!</option>
				<option value="<?php echo OPL_URL; ?>images/graphics/special-report.png">Special Report</option>
				<option value="<?php echo OPL_URL; ?>images/graphics/the-truth.png">The Truth Is...</option>
				<option value="<?php echo OPL_URL; ?>images/graphics/tested-and-proven.png">This Is Time Tested And Proven #1</option>
				<option value="<?php echo OPL_URL; ?>images/graphics/tested-and-proven-2.png">This Is Time Tested And Proven #2</option>
				<option value="<?php echo OPL_URL; ?>images/graphics/not-alone.png">You're Not Alone</option>
				<option value="<?php echo OPL_URL; ?>images/graphics/been-lied.png">You've Been Lied To...</option>
			</optgroup>
		</select>
		<div class="opl-desc"><?php _e('Select a graphic you want to insert, then click the "Insert Graphic" button.', 'opl'); ?></div>
		<div class="opl-hr"></div>
	</li>
	</ul>
	<p style="text-align:right; margin:10px;"><button class="button" id="opl-add-graphic">Insert Graphic</button></p>
	<div style="margin:20px 10px">
		<fieldset style="border:3px dashed #E5E5E5;padding:15px 10px;">
			<legend>Graphic Preview</legend>
			<div id="opl-graphic-preview" style="text-align:center;color:#808080"><img src="<?php echo OPL_URL; ?>images/buttons/big-yellow-addtocart.png" border="0" /></div>
		</fieldset>
	</div>
	<?php
	echo '</div>';
}

add_action( 'media_buttons', 'opl_add_media_graphics', 100 );
function opl_add_media_graphics() {
	echo '<a href="#TB_inline?width=640&height=480&inlineId=opl-media" class="thickbox" title="' . __( 'Insert InstaBuilder Graphics', 'opl' ) . '"><img src="' . OPL_URL . '/images/media-icon.png" border="0" alt="Insert InstaBuilder Graphics" title="Insert InstaBuilder Graphics" /></a>';
}

	
