<?php
/**
 * Add more profile fields to the user
 *
 * Easy to add new fields to the user profile by just
 * creating your new section below and adding a new
 * update_user_meta line
 *
 * @since 1.0
 * @uses show_user_profile & edit_user_profile WordPress functions
 *
 * @param int $user User Object
 * @return bool True on successful update, false on failure.
 *
 */
function wpnuke_profile_fields($user) {
?>
	<!--
	<h3>Social Media Account</h3>
    <table class="form-table">
        <tr>
            <th><label for="facebook"><?php _e('Facebook Account', 'wpnuke')?></label></th>
            <td>
                <input type="text" name="facebook_id" id="facebook_id" value="<?php echo esc_attr(get_the_author_meta(WPNUKE_PREFIX . 'facebook_id', $user->ID)); ?>" class="text regular-text" /><br />
                <span class="description"><?php printf(__("Enter your Facebook username/id without the URL. <br />Don't have one yet? <a target='_blank' href='%s'>Get a custom URL.</a>", 'wpnuke'), 'http://www.facebook.com/username/')?></span>
            </td>
        </tr>
		<tr>
            <th><label for="facebook"><?php _e('Google+ Account', 'wpnuke')?></label></th>
            <td>
                <input type="text" name="facebook_id" id="facebook_id" value="<?php echo esc_attr(get_the_author_meta(WPNUKE_PREFIX . 'gplus_id', $user->ID)); ?>" class="text regular-text" /><br />
                <span class="description"><?php _e('Enter your Google+ username/id without the URL.', 'wpnuke')?></span>
            </td>
        </tr>
        <tr>
            <th><label for="twitter"><?php _e('Twitter Account', 'wpnuke')?></label></th>
            <td>
                <input type="text" name="twitter_id" id="twitter_id" value="<?php echo esc_attr(get_the_author_meta(WPNUKE_PREFIX . 'twitter_id', $user->ID)); ?>" class="text regular-text" size="35" /><br />
                <span class="description"><?php _e('Enter your Twitter username without the URL.', 'wpnuke')?></span>
            </td>
        </tr>
    </table>
	-->
	
	<h3>Custom Profile Avatar</h3>
	
	<?php

	$avatar_id = absint(get_the_author_meta(WPNUKE_PREFIX . 'avatar_id', $user->ID));
	
	if ($avatar_id) :
		//$image = wp_get_attachment_url($thumbnail_id);
		$src  = wp_get_attachment_image_src($avatar_id, 'user-avatar-small');
		$image  = $src[0];
	else :
		$avatar_id = '';
		$image = get_bloginfo('template_directory') . '/images/no-image.png';
	endif;
	
	?>
    <table class="form-table">
		<tr class="form-field">
		<th scope="row" valign="top"><label><?php _e('Custom Profile Avatar', 'wpnuke'); ?></label></th>
		<td>
			<div id="wpnuke_user_avatar" style="float:left;margin-right:10px;"><img src="<?php echo $image; ?>" width="60px" height="60px" /></div>
			<div style="line-height:60px;">
				<input type="hidden" id="wpnuke_user_avatar_id" name="wpnuke_user_avatar_id" value="<?php echo $avatar_id; ?>" />
				<button type="submit" class="upload_image_button button"><?php _e('Upload/Add image', 'wpnuke'); ?></button>
				<button type="submit" class="remove_image_button button"><?php _e('Remove image', 'wpnuke'); ?></button>
			</div>
			<script type="text/javascript">
				// Uploading files
				var file_frame;

				jQuery(document).on('click', '.upload_image_button', function(event){

					event.preventDefault();

					// If the media frame already exists, reopen it.
					if (file_frame) {
						file_frame.open();
						return;
					}

					// Create the media frame.
					file_frame = wp.media.frames.downloadable_file = wp.media({
						title: '<?php _e('Choose an image', 'wpnuke'); ?>',
						button: {
							text: '<?php _e('Use image', 'wpnuke'); ?>',
						},
						multiple: false
					});

					// When an image is selected, run a callback.
					file_frame.on('select', function() {
						attachment = file_frame.state().get('selection').first().toJSON();

						jQuery('#wpnuke_user_avatar_id').val(attachment.id);
						jQuery('#wpnuke_user_avatar img').attr('src', attachment.url);
						jQuery('.remove_image_button').show();
					});

					// Finally, open the modal.
					file_frame.open();
				});

				jQuery(document).on('click', '.remove_image_button', function(event){
					jQuery('#wpnuke_user_avatar img').attr('src', '<?php echo get_bloginfo('template_directory') . '/images/no-image.png'; ?>');
					jQuery('#wpnuke_user_avatar_id').val('');
					jQuery('.remove_image_button').hide();
					return false;
				});
			</script>
			<div class="clear"></div>
		</td>
		</tr>
    </table>
<?php
}
// hook these new fields into the profile page with high priority
add_action('show_user_profile', 'wpnuke_profile_fields', 10, 3);
add_action('edit_user_profile', 'wpnuke_profile_fields', 10, 3);

function wpnuke_profile_fields_save($user_id) {
    if (!current_user_can('edit_user', $user_id))
        return false;

    /* Copy and paste this line for additional fields. Make sure to change 'twitter' to the field ID. */
    //update_user_meta($user_id, WPNUKE_PREFIX . 'facebook_id', $_POST['facebook_id']);
	//update_user_meta($user_id, WPNUKE_PREFIX . 'gplus_id', $_POST['gplus_id']);
    //update_user_meta($user_id, WPNUKE_PREFIX . 'twitter_id', $_POST['twitter_id']);
	update_user_meta($user_id, WPNUKE_PREFIX . 'avatar_id', $_POST['wpnuke_user_avatar_id']);
}
// save the updated profile field information
add_action('personal_options_update', 'wpnuke_profile_fields_save');
add_action('edit_user_profile_update', 'wpnuke_profile_fields_save');

/**
 * Add user fields
 */
function add_to_author_profile( $contactmethods ) {
	$contactmethods['google_profile'] = 'Google Profile URL';
	$contactmethods['twitter_profile'] = 'Twitter Profile URL';
	$contactmethods['facebook_profile'] = 'Facebook Profile URL';
	$contactmethods['linkedin_profile'] = 'Linkedin Profile URL';
	return $contactmethods;
}
add_filter( 'user_contactmethods', 'add_to_author_profile', 10, 1);

?>
