<div class="wrap">
	
<form name="smiliesthemer" method="post">
<h2><?php _e('Smilies Themer Options: ', 'smilies-themer'); ?></h2>

<p class="submit">
	<input type="hidden" name="action" value="update_smilies_themer" />
	<?php wp_nonce_field('update_smilies_themer') ?>
	<input type="submit" name="submit" value="<?php _e('Update Options', 'smilies-themer'); ?> &raquo;" />
</p>

<fieldset class="options">
<legend><?php _e('Formating: ', 'smilies-themer'); ?></legend>

		<label for="use_smilies">
			<input name="use_smilies" type="checkbox" id="use_smilies" value="1" <?php checked('1', get_settings('use_smilies')); ?> />
			<?php _e('Convert emoticons like <code>:-)</code> and <code>:-P</code> to graphics on display', 'smilies-themer'); ?>
		</label>

</fieldset>


		
		
<h3 style="padding-top: 1.5em;"><?php _e('Choose the default smilies theme', 'smilies-themer'); ?></h3>

<table cellspacing="2" cellpadding="5" width="100%">
	<tr class="alternate">
	<th><?php _e('Enable', 'smilies-themer'); ?></th>
	<th><?php _e('Theme', 'smilies-themer'); ?></th>
	<th><?php _e('Author', 'smilies-themer'); ?></th>
	<th><?php _e('Description', 'smilies-themer'); ?></th>
	<th><?php _e('Preview', 'smilies-themer'); ?></th>
	</tr>

<?php
$packages = $this->get_package_list($this->path);
$style = 'alternate';
foreach($packages as $package) {
	$smilies = new smilies_package($package);

	$style = ('alternate' == $style || 'alternate active' == $style) ? '' : 'alternate';
	$checked = '';
	if ($package == $this->current_smilies) {
		$style .= ' active';
		$checked = 'checked="true"';
	}
	
	$author = ($smilies->author_url) ? '<a href="'. $smilies->author_url .'">'. $smilies->author .'</a>' : $smilies->author;
	$name = ($smilies->url) ? '<a href="'. $smilies->url .'">'. $smilies->name .'</a>' : $smilies->name;
	
	echo "<tr class=\"$style\"><td><input type=\"radio\" name=\"smilies_themer\" value=\"$package\" $checked /></td>";
	echo "<td>". $name ."</td>";
	echo "<td>". $author ."</td>";
	echo "<td>". $smilies->description ."</td>";
	
	$url = add_query_arg('smilies_themer_package', $package, $this->url .'preview-popup.php');
	$url = wp_nonce_url($url, 'preview_smilies');
	
	echo "<td><a href=\"$url\" onclick=\"window.open('$url', 'smilies', 'top=200,left=200,scrollbars=yes,dialog=no,minimizable=yes,modal=yes,width=300,height=280,resizable=yes'); return false;\" class=\"edit\">". __('Preview', 'smilies-themer') ."</a></td></tr>";
}
?>

</table>

<p class="submit">
	<input type="hidden" name="action" value="update_smilies_themer" />
	<?php wp_nonce_field('update_smilies_themer') ?>
	<input type="submit" name="submit" value="<?php _e('Update Options', 'smilies-themer'); ?> &raquo;" />
</p>
</form>

<?php $this->footer(); ?>

</div>

