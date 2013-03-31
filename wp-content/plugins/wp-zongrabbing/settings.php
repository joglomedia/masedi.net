<?php
/*
 * Encoded script is not really secure, Just give us your code and we'll appreciate your great job! :D
 */
?>
<?php
$authors = unserialize(get_option('cmt_authors'));
$categories = cmt_remove_duplicate(get_option('cmt_categories'));
update_option('cmt_categories', $categories);

$tags = cmt_remove_duplicate(get_option('cmt_tags'));
update_option('cmt_tags', $tags);

$titleTemplate = get_option('cmt_title_template');
$contentTemplate = get_option('cmt_content_template');
$imagesTitleTemplate = get_option('cmt_images_title_template');
$imagesDescriptionTemplate = get_option('cmt_images_description_template');
$metaTitle = get_option('cmt_meta_title');
$metaDescription = get_option('cmt_meta_description');
$metaKeywords = get_option('cmt_meta_keywords');
if (get_option('cmt_custom_fields')) {
	$customFields = unserialize(get_option('cmt_custom_fields'));
}
?>
<div class="wrap">
<div id="icon-options-general" class="icon32"><br /></div>
<h2>WP ZonGrabbing Settings</h2>
<div class="updated">
<p><strong>WARNING! You're using NULLED version of WP ZonGrabbing v1.1. Use this work at your own risk!!!</strong><br />
<strong>DISCLAIMER:</strong> I Cracked this plugin just for fun - Not for commercial use :D. I'd highly recommend you to BUY the FULL Version to support the plugin development!</p>
<p>WP ZonGrabbing v1.1 NULL3D by Street.Walker<br /><strong>Need help to decode your encoded PHP script/plugin/theme file? Just drop me a message at escendolijo (at) yahoo (dot) com</strong></p>
</div>
<?php settings_errors(); ?>
<form method="post" action="options.php">
	<?php settings_fields( 'cmt-settings-group' ); ?>
	<table class="form-table">
		<tr valign="top">
			<th scope="row"><label for="cmt_amazon_access_key">Amazon Acces Key</label></th>
			<td>
				<input type="text" class="regular-text code" id="cmt_amazon_access_key" name="cmt_amazon_access_key" value="<?php echo get_option('cmt_amazon_access_key'); ?>" />
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="cmt_amazon_secret_key">Amazon Secret Key</label></th>
			<td>
				<input type="text" class="regular-text code" id="cmt_amazon_secret_key" name="cmt_amazon_secret_key" value="<?php echo get_option('cmt_amazon_secret_key'); ?>" />
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="cmt_amazon_associate_tag">Amazon Associate Tag</label></th>
			<td>
				<input type="text" class="code" id="cmt_amazon_associate_tag" name="cmt_amazon_associate_tag" value="<?php echo get_option('cmt_amazon_associate_tag'); ?>" />
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="cmt_amazon_website">Amazon Website</label></th>
			<td>
				<select id="cmt_amazon_website" name="cmt_amazon_website">
					<option value="com"<?php if (get_option('cmt_amazon_website') == 'com') echo ' selected'; ?>>amazon.com</option>
					<option value="ca"<?php if (get_option('cmt_amazon_website') == 'ca') echo ' selected'; ?>>amazon.ca</option>
					<option value="co.uk"<?php if (get_option('cmt_amazon_website') == 'co.uk') echo ' selected'; ?>>amazon.co.uk</option>
					<option value="de"<?php if (get_option('cmt_amazon_website') == 'de') echo ' selected'; ?>>amazon.de</option>
					<option value="fr"<?php if (get_option('cmt_amazon_website') == 'fr') echo ' selected'; ?>>amazon.fr</option>
					<option value="it"<?php if (get_option('cmt_amazon_website') == 'it') echo ' selected'; ?>>amazon.it</option>
					<option value="es"<?php if (get_option('cmt_amazon_website') == 'es') echo ' selected'; ?>>amazon.es</option>
				</select>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="cmt_amazon_desc_length">Amazon Description Length</label></th>
			<td>
				<select id="cmt_amazon_desc_length" name="cmt_amazon_desc_length">
					<option value="250"<?php if (get_option('cmt_amazon_desc_length') == '250') echo ' selected'; ?>>250 Characters</option>
					<option value="500"<?php if (get_option('cmt_amazon_desc_length') == '500') echo ' selected'; ?>>500 Characters</option>
					<option value="750"<?php if (get_option('cmt_amazon_desc_length') == '750') echo ' selected'; ?>>750 Characters</option>
					<option value="1000"<?php if (get_option('cmt_amazon_desc_length') == '1000') echo ' selected'; ?>>1000 Characters</option>
					<option value="full"<?php if (get_option('cmt_amazon_desc_length') == 'full') echo ' selected'; ?>>Full Description</option>
				</select>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="authors">Authors</label></th>
			<td>
				<select id="authors" name="authors[]" size="10" style="overflow:scroll; min-width:150px !important;" multiple="multiple">
<?php
	$blogusers = get_users();
	foreach ($blogusers as $user) {
		echo '<option value="' . $user->ID. '"';
		if (isset($authors[0])) {
			if (in_array($user->ID, $authors)) echo ' selected';
		}
		echo '>' . $user->user_login . '</option>';
	}
?>
				</select>
				<p class="description">The author will be chosen randomly from the selected above. Press &amp; hold <b>Ctrl</b> key to select multiple authors. You can also use the <b>Shift</b> key to batch select.</p>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="cmt_categories">Categories</label></th>
			<td>
				<label for="cmt_parent_category">Parent Category :</label> <?php wp_dropdown_categories('name=cmt_parent_category&hide_empty=0&hierarchical=1&show_option_none=[ root ]&selected='.get_option('cmt_parent_category')); ?>
				<textarea class="large-text code" id="cmt_categories" name="cmt_categories" rows="1" style="margin-top:10px;"><?php echo $categories; ?></textarea>
				<p class="description">One category per line. You can also use <b>{category}</b> and <b>{brand}</b>.</p>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="cmt_tags">Tags</label></th>
			<td>
				<textarea class="large-text code" id="cmt_tags" name="cmt_tags" rows="2"><?php echo $tags; ?></textarea>
				<p class="description">One tag per line. You can also use <b>{autotags}</b>, <b>{category}</b> and <b>{brand}</b>.</p>
			</td>
		</tr>
	</table>
	<h2>Post Templates</h2>
	<p class="description">You can insert spintax format for unique and random. Example: <strong>{car|vehicle|auto}</strong>.</p>
	<table class="form-table">
		<tr valign="top">
			<th scope="row"><label for="cmt_title_template">Title template</label></th>
			<td>
				<textarea class="large-text code" id="cmt_title_template" name="cmt_title_template" rows="1"><?php echo $titleTemplate; ?></textarea>
				<p class="description">You can also use <b>{title}</b>, <b>{asin}</b>, <b>{category}</b> and <b>{brand}</b>.</p>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="cmt_content_template">Content template<br /><p class="description">in HTML</p></label></th>
			<td>
				<textarea class="large-text code" id="cmt_content_template" name="cmt_content_template" rows="5"><?php echo $contentTemplate; ?></textarea>
				<p class="description">You can also use the following snippets</p>
					<table style="border:1px solid; float:left; margin-right:10px;">
						<tr style="background-color:lightgray;"><td><b>Snippet</b></td><td><b>Will replace with</b></td></tr>
						<tr><td>{title}</td><td>Product title</td></tr>
						<tr><td>{asin}</td><td>Product ASIN</td></tr>
						<tr><td>{url}</td><td>Product URL</td></tr>
						<tr><td>{encryptedurl}</td><td>Encrypted Product URL</td></tr>
						<tr><td>{addtocarturl}</td><td>Add to Cart URL</td></tr>
						<tr><td>{encryptedaddtocarturl}</td><td>Encrypted Add to Cart URL</td></tr>
						<tr><td>{description}</td><td>Product description</td></tr>
						<tr><td>{features}</td><td>Product features</td></tr>
						<tr><td>{listprice}</td><td>Product list price</td></tr>
						<tr><td>{price}</td><td>Product price</td></tr>
						<tr><td>{savedprice}</td><td>Product saved price</td></tr>
						<tr><td>{rating}</td><td>Product rating (example: 4.7)</td></tr>
					</table>
					<table style="border:1px solid;">
						<tr style="background-color:lightgray;"><td><b>Snippet</b></td><td><b>Will replace with</b></td></tr>
						<tr><td>{category}</td><td>Product category</td></tr>
						<tr><td>{brand}</td><td>Product brand</td></tr>
						<tr><td>{firstimageurl}</td><td>First image URL</td></tr>
						<tr><td>{randomimageurl}</td><td>Random image URL</td></tr>
						<tr><td>{images}</td><td>All Images</td></tr>
						<tr><td>{images:<i>n</i>}</td><td>First <i>n</i> images</td></tr>
						<tr><td>{reviewsiframeurl}</td><td>Customer reviews iframe URL</td></tr>
						<tr><td>{review1}</td><td>Customer review 1</td></tr>
						<tr><td>{review2}</td><td>Customer review 2</td></tr>
						<tr><td>{review3}</td><td>Customer review 3</td></tr>
						<tr><td>{randomreview}</td><td>Random customer review</td></tr>
						<!--<tr><td>{<i>m</i>..<i>n</i>}</td><td>Random number between <i>m</i> to <i>n</i></td></tr>-->
					</table>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="cmt_images_title_template">Images title template</label></th>
			<td>
				<textarea class="large-text code" id="cmt_images_title_template" name="cmt_images_title_template" rows="1"><?php echo $imagesTitleTemplate; ?></textarea>
				<p class="description">You can also use <b>{n}</b>, <b>{title}</b>, <b>{asin}</b>, <b>{category}</b> and <b>{brand}</b>. Must contain <b>{n}</b> for images numbering.</p>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="cmt_images_description_template">Images description template<br /><p class="description">in HTML</p></label></th>
			<td>
				<textarea class="large-text code" id="cmt_images_description_template" name="cmt_images_description_template" rows="3"><?php echo $imagesDescriptionTemplate; ?></textarea>
				<p class="description">You can also use <b>{imagetitle}</b>, <b>{title}</b>, <b>{asin}</b>, <b>{url}</b>, <b>{encryptedurl}</b>, <b>{addtocarturl}</b>, <b>{encryptedaddtocarturl}</b>, <b>{description}</b>, <b>{features}</b>, <b>{category}</b> and <b>{brand}</b>. <b>{imagetitle}</b> is title on the attachment page.</p>
			</td>
		</tr>
	</table>
	<h2>Meta Settings</h2>
	<p class="description">This feature requires <b>AIO SEO Pack</b> or <b>Platinum SEO Pack</b> plugin to work. You can insert spintax format for unique and random. Example: <strong>{car|vehicle|auto}</strong>.</p>
	<table class="form-table">
		<tr valign="top">
			<th scope="row"><label for="cmt_meta_title">Meta title</label></th>
			<td>
				<textarea class="large-text code" id="cmt_meta_title" name="cmt_meta_title" rows="1"><?php echo $metaTitle; ?></textarea>
				<p class="description">You can also use <b>{title}</b>, <b>{asin}</b>, <b>{category}</b> and <b>{brand}</b>.</p>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="cmt_meta_description">Meta description</label></th>
			<td>
				<textarea class="large-text code" id="cmt_meta_description" name="cmt_meta_description" rows="3"><?php echo $metaDescription; ?></textarea>
				<p class="description">You can also use <b>{title}</b>, <b>{asin}</b>, <b>{description}</b>, <b>{features}</b>, <b>{category}</b> and <b>{brand}</b>.</p>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="cmt_meta_keywords">Meta keywords</label></th>
			<td>
				<textarea class="large-text code" id="cmt_meta_keywords" name="cmt_meta_keywords" rows="1"><?php echo $metaKeywords; ?></textarea>
				<p class="description">You can also use <b>{title}</b>, <b>{asin}</b>, <b>{description}</b>, <b>{features}</b>, <b>{category}</b> and <b>{brand}</b>.</p>
			</td>
		</tr>
	</table>
	<h2>Custom Fields</h2>
	<p class="description">You can use <b>{title}</b>, <b>{asin}</b>, <b>{rating}</b>, <b>{listprice}</b>, <b>{price}</b>, <b>{savedprice}</b>, <b>{url}</b>, <b>{encryptedurl}</b>, <b>{addtocarturl}</b>, <b>{encryptedaddtocarturl}</b>, <b>{firstimageurl}</b>, <b>{randomimageurl}</b>, <b>{description}</b>, <b>{features}</b>, <b>{category}</b> and <b>{brand}</b>.<br />If your theme does not support the custom fields, please leave it blank.</p>
<?php
	if (count($customFields['name']) > 1) $i = count($customFields['name']);
	else $i = 1;
?>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js" type="text/javascript"></script>
	<script type="text/javascript">
	$(function() {
			var scntDiv = $('#p_scents');
			var i = $('#p_scents p').size() + <?php echo $i ?>;

			$('#addScnt').live('click', function() {
					$('<p> &nbsp;&nbsp; <label for="customFieldName' + i +'">Custom Field</label> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <input type="text" class="code" id="customFieldName' + i +'" name="customFieldName[]" value="" placeholder="Input Name" /> &nbsp; <input type="text" class="code" id="customFieldValue' + i +'" name="customFieldValue[]" value="" placeholder="Input Value" /> &nbsp; <a href="#" id="remScnt">Remove</a></p>').appendTo(scntDiv);
					i++;
					return false;
			});

			$('#remScnt').live('click', function() {
					if( i > 2 ) {
							$(this).parents('p').remove();
							i--;
					}
					return false;
			});
	});
	</script>
	<style type="text/css">
	input::-webkit-input-placeholder { color: #999; }
	input:-moz-placeholder { color: #999; }
	input:-ms-input-placeholder { color: #999; }
	</style>

	<div id="p_scents">
<?php
	for ($j = 0; $j < $i; $j++) {
?>
		<p> &nbsp;&nbsp;
			<label for="customFieldName<?php echo $j + 1; ?>">Custom Field</label> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
			<input type="text" class="code" id="customFieldName<?php echo $j + 1; ?>" name="customFieldName[]" value="<?php if (isset($customFields['name'][$j])) echo $customFields['name'][$j]; ?>" placeholder="Input Name" /> &nbsp;
			<input type="text" class="code" id="customFieldValue<?php echo $j + 1; ?>" name="customFieldValue[]" value="<?php if (isset($customFields['value'][$j])) echo $customFields['value'][$j]; ?>" placeholder="Input Value" /> &nbsp;
<?php
			if ($j == 0) echo '<a href="#" id="addScnt">Add</a>';
			else echo '<a href="#" id="remScnt">Remove</a>';
?>
		</p>
<?php
	}
?>
	</div>
	<input type="hidden" name="settingsUpdated" value="1" />
	<?php submit_button(); ?>
</form>
<div class="updated">
<p>
	<b>Cron Url for this Weblog:</b><br />
	<i><?php echo plugin_dir_url($cmt__FILE__).'cron.php?code=<b>'.get_option('cmt_ucode').'</b>'; ?>&draft=<b>false</b>&upload=<b>true</b>&num=<b>1</b></i>
</p>
<p>
	<b>Sample Cron Command:</b><br />
	<i>wget -O /dev/null "<?php echo plugin_dir_url($cmt__FILE__).'cron.php?code=<b>'.get_option('cmt_ucode').'</b>'; ?>&draft=<b>false</b>&upload=<b>true</b>&num=<b>1</b>"</i>
</p>
</div>
</div>
<?php
	$i = 0;
?>