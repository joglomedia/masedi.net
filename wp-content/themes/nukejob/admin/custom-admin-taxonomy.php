<?php
/**
 * Custom admin taxonomy functions
 *
 * These functions control admin interface for taxonomy bits like adding a category logo to job company custom tax, etc.
 *
 * @author 		WPNuke
 * @category 	Admin
 * @package 	WPNuke/Admin/
 * @version     1.0
 */

if (! defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * Add a thumbnail form field for Job Company Taxonomy
 */
function wpnuke_add_job_company_fields() {
	global $post;
	
	// Add form field to taxonomy editor
	?>
	<h3>Company Details (*Required)</h3>
	<div class="form-field form-required">
		<label for="job_company_slogan"><?php _e('Company Slogan', 'wpnuke'); ?></label>
		<input type="text" id="job_company_slogan" name="job_company_slogan" value="" aria-required="true" />
		<p class="description">Enter company slogan, max 160 chars (Ex. Best web developer).</p>
	</div>
	<div class="form-field form-required">
		<label for="job_company_phone"><?php _e('Company Phone Number', 'wpnuke'); ?></label>
		<input type="text" id="job_company_phone" name="job_company_phone" value="" />
		<p class="description">Enter job provider phone number (Ex. 622740000).</p>
	</div>
	<div class="form-field form-required">
		<label for="job_company_email"><?php _e('Company Email Address', 'wpnuke'); ?></label>
		<input type="text" id="job_company_email" name="job_company_email" value="" />
		<p class="description">Enter job provider email address (Ex. contact@company.com).</p>
	</div>
	<div class="form-field form-required">
		<label for="job_company_url"><?php _e('Company Site URL', 'wpnuke'); ?></label>
		<input type="text" id="job_company_url" name="job_company_url" value="" />
		<p class="description">Enter job provider site url (Ex. http://company.com).</p>
	</div>
	<div class="form-field form-required">
		<label><?php _e('Company Logo Thumbnail', 'wpnuke'); ?></label>
		<div id="job_company_thumbnail" style="float:left;margin-right:10px;"><img src="<?php echo get_bloginfo('template_directory') . '/images/no-image.png'; ?>" width="60px" height="60px" /></div>
		<div style="line-height:60px;">
			<input type="hidden" id="job_company_thumbnail_id" name="job_company_thumbnail_id" />
			<button type="submit" class="upload_image_button button"><?php _e('Upload/Add image', 'wpnuke'); ?></button>
			<button type="submit" class="remove_image_button button"><?php _e('Remove image', 'wpnuke'); ?></button>
		</div>
		<script type="text/javascript">

			 // Only show the "remove image" button when needed
			 if (! jQuery('#job_company_thumbnail_id').val())
				 jQuery('.remove_image_button').hide();

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

					jQuery('#job_company_thumbnail_id').val(attachment.id);
					jQuery('#job_company_thumbnail img').attr('src', attachment.url);
					jQuery('.remove_image_button').show();
				});

				// Finally, open the modal.
				file_frame.open();
			});

			jQuery(document).on('click', '.remove_image_button', function(event){
				jQuery('#job_company_thumbnail img').attr('src', '<?php echo get_bloginfo('template_directory') . '/images/default-logo.png'; ?>');
				jQuery('#job_company_thumbnail_id').val('');
				jQuery('.remove_image_button').hide();
				return false;
			});

		</script>
		<div class="clear"></div>
	</div>
	<div class="form-field form-required">
		<label for="job_company_url"><?php _e('Active Company?', 'wpnuke'); ?></label>
			<select class="postform" id="job_company_active" name="job_company_active" style="min-width:125px;">
				<option value="yes">Yes</option>
				<option value="no">No</option>
			</select>
			<p class="description">Is it an active company?.</p>
	</div>
	<?php
}
add_action('job_company_add_form_fields', 'wpnuke_add_job_company_fields');

/**
 * Edit Thumbnail Field for Job Company Taxonomy
 */
function wpnuke_edit_job_company_fields($term, $taxonomy) {
	global $post;
	
	// Get saved taxonomy metadata
	$company_slogan	= get_metadata('post', $term->term_id, WPNUKE_PREFIX . 'job_company_slogan', true);
	$company_phone	= get_metadata('post', $term->term_id, WPNUKE_PREFIX . 'job_company_phone', true);
	$company_email	= get_metadata('post', $term->term_id, WPNUKE_PREFIX . 'job_company_email', true);
	$company_url	= get_metadata('post', $term->term_id, WPNUKE_PREFIX . 'job_company_url', true);
	$company_active = get_metadata('post', $term->term_id, WPNUKE_PREFIX . 'job_company_active', true);
	
	$image 			= '';
	$thumbnail_id 	= absint(get_metadata('post', $term->term_id, WPNUKE_PREFIX . 'job_company_thumbid', true));
	if ($thumbnail_id) :
		//$image = wp_get_attachment_url($thumbnail_id);
		$src  = wp_get_attachment_image_src($thumbnail_id, 'company-logo-medium');
		$company_logo  = $src[0];
	else :
		$company_logo = get_bloginfo('template_directory') . '/images/default-logo.png';
	endif;
	
	// Add form field to taxonomy editor
	?>
	<tr class="form-field">
		<th scope="row" valign="top"><label><?php _e('Company Slogan', 'wpnuke'); ?></label></th>
		<td>
			<input type="text" id="job_company_slogan" name="job_company_slogan" class="postform" value="<?php echo $company_slogan; ?>" />
			<p class="description">Enter company slogan, max 160 chars (Ex. Best web developer).</p>
		</td>
	</tr>
	<tr class="form-field">
		<th scope="row" valign="top"><label><?php _e('Company Phone Number', 'wpnuke'); ?></label></th>
		<td>
			<input type="text" id="job_company_phone" name="job_company_phone" class="postform" value="<?php echo $company_phone; ?>" />
			<p class="description">Enter company phone number, exclude the "+" sign (Ex. 622740000).</p>
		</td>
	</tr>
	<tr class="form-field">
		<th scope="row" valign="top"><label><?php _e('Company Email Address', 'wpnuke'); ?></label></th>
		<td>
			<input type="text" id="job_company_email" name="job_company_email" class="postform" value="<?php echo $company_email; ?>" />
			<p class="description">Enter company email address (Ex. contact@company.com).</p>
		</td>
	</tr>
	<tr class="form-field">
		<th scope="row" valign="top"><label><?php _e('Company Site URL', 'wpnuke'); ?></label></th>
		<td>
			<input type="text" id="job_company_url" name="job_company_url" class="postform" value="<?php echo $company_url; ?>" />
			<p class="description">Enter company site url (Ex. http://company.com).</p>
		</td>
	</tr>
	<tr class="form-field">
		<th scope="row" valign="top"><label><?php _e('Company Logo Thumbnail', 'wpnuke'); ?></label></th>
		<td>
			<div id="job_company_thumbnail" style="float:left;margin-right:10px;"><img src="<?php echo $company_logo; ?>" width="60px" height="60px" /></div>
			<div style="line-height:60px;">
				<input type="hidden" id="job_company_thumbnail_id" name="job_company_thumbnail_id" value="<?php echo $thumbnail_id; ?>" />
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

						jQuery('#job_company_thumbnail_id').val(attachment.id);
						jQuery('#job_company_thumbnail img').attr('src', attachment.url);
						jQuery('.remove_image_button').show();
					});

					// Finally, open the modal.
					file_frame.open();
				});

				jQuery(document).on('click', '.remove_image_button', function(event){
					jQuery('#job_company_thumbnail img').attr('src', '<?php echo get_bloginfo('template_directory') . '/images/default-logo.png'; ?>');
					jQuery('#job_company_thumbnail_id').val('');
					jQuery('.remove_image_button').hide();
					return false;
				});

			</script>
			<div class="clear"></div>
		</td>
	</tr>
	<tr class="form-field">
		<th scope="row" valign="top"><label><?php _e('Active Company?', 'wpnuke'); ?></label></th>
		<td>
			<select class="postform" id="job_company_active" name="job_company_active" style="min-width:125px;">
			<?php
				$options = '';
				$values = array('yes','no');
				foreach ($values as $value) {
					if ($value == $company_active) {
						$selected = 'selected="selected"';
					} else {
						$selected = '';
					}
					$options .= '<option ' . $selected . ' value="' . $value. '">' . ucfirst($value) . '</option>' . "\n\r";
				}
				echo $options;
			?>
			</select>
			<p class="description">Is it an active company?.</p>
		</td>
	</tr>
	<?php
}
add_action('job_company_edit_form_fields', 'wpnuke_edit_job_company_fields', 10,2);

/**
 * Add Edit Screen Columns to Job Company Taxonomy
 */
function wpnuke_job_company_columns($columns) {
	$columns = array(
        'cb' => '<input type="checkbox" />',
		//'job_company_thumb' => __('Logo', 'wpnuke'),
		'name' => __('Company Name', 'wpnuke'),
		'job_company_slogan' => __('Slogan', 'wpnuke'),
		'job_company_phone' => __('Phone', 'wpnuke'),
		'job_company_email' => __('Email', 'wpnuke'),
		'job_company_url' => __('Website', 'wpnuke'),
		'job_company_active' => __('Active', 'wpnuke'),
		'posts' => __('Jobs', 'wpnuke'),
   );
	
	// remove slug & desc from columns display
	unset($columns['slug']);
	unset($columns['description']);

	return $columns;
}
add_filter('manage_edit-job_company_columns', 'wpnuke_job_company_columns');

/**
 * Modify Edit Screen Columns of Job Company Taxonomy
 */
function wpnuke_job_company_custom_column($empty, $column, $term_id){
	global $wpdb;

	switch ($column) {
		/*
		case 'job_company_thumb':
			$image 			= '';
			$thumbnail_id 	= absint(get_metadata('post', $term_id, WPNUKE_PREFIX . 'job_company_thumbid', true));
			
			if ($thumbnail_id) {
				//$image = wp_get_attachment_url($thumbnail_id);
				$src  = wp_get_attachment_image_src($thumbnail_id, 'company-logo-small');
				$image  = $src[0];
			} else {
				$image = get_bloginfo('template_directory') . '/images/default-logo.png';
			}
			
			echo '<img src="' . $image . '" alt="Logo Thumbnail" class="wp-post-image" style="height:32px;width:32px;" />';
		break;
		*/
		case 'job_company_slogan':
			$slogan = get_metadata('post', $term_id, WPNUKE_PREFIX . 'job_company_slogan', true);
			echo $slogan;
		break;
		
		case 'job_company_phone':
			$phone = get_metadata('post', $term_id, WPNUKE_PREFIX . 'job_company_phone', true);
			echo $phone;
		break;
		
		case 'job_company_email':
			$email = get_metadata('post', $term_id, WPNUKE_PREFIX . 'job_company_email', true);
			echo $email;
		break;
		
		case 'job_company_url':
			$url = get_metadata('post', $term_id, WPNUKE_PREFIX . 'job_company_url', true);
			echo $url;
		break;
		
		case 'job_company_active':
			$active = get_metadata('post', $term_id, WPNUKE_PREFIX . 'job_company_active', true);
			switch($active) {
				case 'yes':
					echo '<span class="active-yes">Yes</span>';
				break;
				case 'no':
					echo '<span class="active-no">No</span>';
				break;
				default:
					echo '<span class="active-yes">Yes</span>';
				break;
			}
		break;
		
		default :
		break;
	}
}
add_action('manage_job_company_custom_column', 'wpnuke_job_company_custom_column', 10, 3);

/**
 * Add action for Job Company Field Save function.
 */
function wpnuke_job_company_fields_save($term_id, $tt_id, $taxonomy) {
	// Save new field to database
	if (isset($_POST['job_company_slogan']))
		update_metadata('post', $term_id, WPNUKE_PREFIX . 'job_company_slogan', $_POST['job_company_slogan']);

	if (isset($_POST['job_company_phone']) and is_numeric($_POST['job_company_phone']))
		update_metadata('post', $term_id, WPNUKE_PREFIX . 'job_company_phone', $_POST['job_company_phone']);

	if (isset($_POST['job_company_email']) and is_valid_email($_POST['job_company_email']))
		update_metadata('post', $term_id, WPNUKE_PREFIX . 'job_company_email', $_POST['job_company_email']);

	if (isset($_POST['job_company_url']) and is_valid_url($_POST['job_company_url']))
		update_metadata('post', $term_id, WPNUKE_PREFIX . 'job_company_url', esc_attr($_POST['job_company_url']));

	if (isset($_POST['job_company_thumbnail_id']))
		update_metadata('post', $term_id, WPNUKE_PREFIX . 'job_company_thumbid', absint($_POST['job_company_thumbnail_id']));
		
	if (isset($_POST['job_company_active']))
		update_metadata('post', $term_id, WPNUKE_PREFIX . 'job_company_active', $_POST['job_company_active']);
}
add_action('created_term', 'wpnuke_job_company_fields_save', 10,3);
add_action('edit_term', 'wpnuke_job_company_fields_save', 10,3);

/**
 * show custom job company fields in quick edit mode.
 */
function wpnuke_job_company_quick_edit_values($column_name, $screen, $name = null) {

	if($name != 'job_company' && ($column_name != 'description' || $column_name != 'job_company_url')) return false;

	switch($column_name) {
		case 'job_company_slogan':
		?>
		<fieldset>
			<div class="inline-edit-col">
				<label>
					<span class="title"><?php _e('Company Slogan'); ?></span>
					<span class="input-text-wrap"><input type="text" name="job_company_slogan" class="ptitle" value="" /></span>
				</label>
			</div>
		</fieldset>
		<?php
		break;
		
		case 'job_company_phone':
		?>
		<fieldset>
			<div class="inline-edit-col">
				<label>
					<span class="title"><?php _e('Company Phone'); ?></span>
					<span class="input-text-wrap"><input type="text" name="job_company_phone" class="ptitle" value="" /></span>
				</label>
			</div>
		</fieldset>
		<?php
		break;
		
		case 'job_company_email':
		?>
		<fieldset>
			<div class="inline-edit-col">
				<label>
					<span class="title"><?php _e('Company Email'); ?></span>
					<span class="input-text-wrap"><input type="text" name="job_company_email" class="ptitle" value="" /></span>
				</label>
			</div>
		</fieldset>
		<?php
		break;
		
		case 'job_company_url':
		?>
		<fieldset>
			<div class="inline-edit-col">
				<label>
					<span class="title"><?php _e('Company URL'); ?></span>
					<span class="input-text-wrap"><input type="text" name="job_company_url" class="ptitle" value="" /></span>
				</label>
			</div>
		</fieldset>
		<?php
		break;
		
		case 'job_company_active':
		?>
		<fieldset>
			<div class="inline-edit-col">
				<label>
					<span class="title"><?php _e('Active', 'wpnuke'); ?></span>
					<span class="input-text-wrap">
						<select class="postform" id="job_company_active" name="job_company_active" style="min-width:125px;">
							<option value="yes"><?php _e('Yes', 'wpnuke'); ?></option>
							<option value="no"><?php _e('No', 'wpnuke'); ?></option>
						</select>
					</span>
				</label>
			</div>
		</fieldset>
		<?php
		break;
		
		default:
		break;
	}
}
add_action('quick_edit_custom_box', 'wpnuke_job_company_quick_edit_values', 10, 3);

/**
 * Enqueue script for quick edit job company
 */
function wpnuke_job_company_quick_edit_script() {  
	global $pagenow;
  
	if($pagenow == 'edit-tags.php' && (isset($_GET['taxonomy']) && $_GET['taxonomy'] == 'job_company') && !isset($_GET['action'])) {  
		wp_register_script('quick-edit-job_company-js', get_bloginfo('template_directory').'/admin/assets/js/quick-edit-job-company.js', array('jquery'));  
		wp_enqueue_script('quick-edit-job_company-js');  
	}  
} 
add_action('admin_enqueue_scripts', 'wpnuke_job_company_quick_edit_script', 10, 1);  

/**
 * Fix for the per_page option
 *
 * Trac: http://core.trac.wordpress.org/ticket/19465
 *
 * @access public
 * @param mixed $per_page
 * @param mixed $post_type
 * @return void
 */
function wpnuke_fix_edit_posts_per_page($per_page, $post_type) {

	if ($post_type !== 'job' || $post_type !== 'resume')
		return $per_page;

	$screen = get_current_screen();

	if (strstr($screen->id, '-')) {

		$option = 'edit_' . str_replace('edit-', '', $screen->id) . '_per_page';

		if (isset($_POST['wp_screen_options']['option']) && $_POST['wp_screen_options']['option'] == $option) {

			update_user_meta(get_current_user_id(), $option, $_POST['wp_screen_options']['value']);

			wp_redirect(remove_query_arg(array('pagenum', 'apage', 'paged'), wp_get_referer()));
			exit;

		}

		$user_per_page = (int) get_user_meta(get_current_user_id(), $option, true);

		if ($user_per_page)
			$per_page = $user_per_page;

	}

	return $per_page;
}
add_filter('edit_posts_per_page', 'wpnuke_fix_edit_posts_per_page', 1, 2);


/**
 * Add description to Job Company Edit Screen
 */
function wpnuke_job_company_description() {
	echo wpautop(__('Job company/providers for your job site can be managed here. To see more companies (job providers) listed click the "screen options" link at the top of the page.', 'wpnuke'));
}
add_action('job_company_pre_add_form', 'wpnuke_job_company_description');

/**
 * Add description to Job Category Edit Screen
 */
function wpnuke_job_category_description() {
	echo wpautop(__('Job categories for your job site can be managed here. Job category is useful to categorize/organize your job post.', 'wpnuke'));
}
add_action('job_category_pre_add_form', 'wpnuke_job_category_description');

/**
 * Add description to Resume Category Edit Screen
 */
function wpnuke_resume_category_description() {
	echo wpautop(__('Resume categories for your job site can be managed here. You can organize your job applicant\'s resume/cv here.', 'wpnuke'));
}
add_action('resume_category_pre_add_form', 'wpnuke_resume_category_description');

?>
