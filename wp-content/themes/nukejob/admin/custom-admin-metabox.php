<?php
/**
 * Custom admin post metabox setup
 * temporary hack until WP will fully support custom post statuses
 */
function wpnuke_admin_post_metaboxes_setup() {
	// add custom admin post metaboxes
	remove_meta_box('submitdiv', 'job', 'core');
	remove_meta_box('job_companydiv', 'job', 'side');
	add_meta_box('submitdiv', __('Job Publishing Tool'), 'wpnuke_job_submit_meta_box', 'job', 'side', 'high');
	add_meta_box('job_companydiv', __('Job Companies'), 'wpnuke_job_companies_meta_box', 'job', 'side', 'medium', array( 'taxonomy' => 'job_company' ));

	// remove post revision box
	remove_meta_box('revisionsdiv', 'job', 'advanced');
	remove_meta_box('revisionsdiv', 'resume', 'advanced');
	
	// remove post comments box and replace with applicants box
	remove_meta_box('commentsdiv', 'job', 'advanced');
	remove_meta_box('commentstatusdiv', 'resume', 'advanced');
	
	// remove post custom fields metabox
	remove_meta_box( 'postcustom' , 'job' , 'normal' ); 
	remove_meta_box( 'postcustom' , 'resume' , 'normal' ); 
}
add_action('admin_menu', 'wpnuke_admin_post_metaboxes_setup');

/**
 * Add and display a new "expired" status to post submit form fields.
 *
 * Temporary hack until WP will fully support custom post statuses
 *
 * @since 1.0
 *
 * @param object $post
 */
function wpnuke_job_submit_meta_box($post) {
	global $action;

	$post_type = $post->post_type;
	$post_type_object = get_post_type_object($post_type);
	$can_publish = current_user_can($post_type_object->cap->publish_posts);
	?>
	<div class="submitbox" id="submitpost">
	<div id="minor-publishing">

	<?php // Hidden submit button early on so that the browser chooses the right button when form is submitted with Return key ?>
	<div style="display:none;">
	<?php submit_button( __( 'Save' ), 'button', 'save' ); ?>
	</div>

	<div id="minor-publishing-actions">
	<div id="save-action">
	<?php if ( 'publish' != $post->post_status && 'future' != $post->post_status && 'pending' != $post->post_status && 'expired' != $post->post_status )  { ?>
	<input <?php if ( 'private' == $post->post_status ) { ?>style="display:none"<?php } ?> type="submit" name="save" id="save-post" value="<?php esc_attr_e('Save Draft'); ?>" tabindex="4" class="button button-highlighted" />
	<?php } elseif ( 'pending' == $post->post_status && $can_publish ) { ?>
	<input type="submit" name="save" id="save-post" value="<?php esc_attr_e('Save as Pending'); ?>" tabindex="4" class="button button-highlighted" />
	<?php } ?>
	<span class="spinner"></span>
	</div>

	<div id="preview-action">
	<?php
	if ( 'publish' == $post->post_status || 'expired' == $post->post_status ) {
		$preview_link = esc_url( get_permalink( $post->ID ) );
		$preview_button = __( 'Preview Changes' );
	} else {
		$preview_link = get_permalink( $post->ID );
		if ( is_ssl() )
			$preview_link = str_replace( 'http://', 'https://', $preview_link );
		$preview_link = esc_url( apply_filters( 'preview_post_link', add_query_arg( 'preview', 'true', $preview_link ) ) );
		$preview_button = __( 'Preview' );
	}
	?>
	<a class="preview button" href="<?php echo $preview_link; ?>" target="wp-preview" id="post-preview" tabindex="4"><?php echo $preview_button; ?></a>
	<input type="hidden" name="wp-preview" id="wp-preview" value="" />
	</div>

	<div class="clear"></div>
	</div>
	<?php // /minor-publishing-actions ?>

	<div id="misc-publishing-actions">

	<div class="misc-pub-section<?php if ( !$can_publish ) { echo ' misc-pub-section-last'; } ?>"><label for="post_status"><?php _e('Status:') ?></label>
	<span id="post-status-display">
	<?php
	switch ( $post->post_status ) {
		case 'private':
			_e('Privately Published');
			break;
		case 'publish':
			_e('Published');
			break;
		case 'expired':
			_e('Expired');
			break;
		case 'future':
			_e('Scheduled');
			break;
		case 'pending':
			_e('Pending Review');
			break;
		case 'draft':
		case 'auto-draft':
			_e('Draft');
			break;
	}
	?>
	</span>
	<?php if ( 'publish' == $post->post_status || 'private' == $post->post_status || $can_publish || 'expired' == $post->post_status ) { ?>
	<a href="#post_status" <?php if ( 'private' == $post->post_status ) { ?>style="display:none;" <?php } ?>class="edit-post-status hide-if-no-js" tabindex='4'><?php _e('Edit') ?></a>

	<div id="post-status-select" class="hide-if-js">
	<input type="hidden" name="hidden_post_status" id="hidden_post_status" value="<?php echo esc_attr( ('auto-draft' == $post->post_status ) ? 'draft' : $post->post_status); ?>" />
	<select name='post_status' id='post_status' tabindex='4'>
	<?php if ( 'publish' == $post->post_status ) : ?>
	<option<?php selected( $post->post_status, 'publish' ); ?> value='publish'><?php _e('Published') ?></option>
	<?php elseif ( 'private' == $post->post_status ) : ?>
	<option<?php selected( $post->post_status, 'private' ); ?> value='publish'><?php _e('Privately Published') ?></option>
	<?php elseif ( 'future' == $post->post_status ) : ?>
	<option<?php selected( $post->post_status, 'future' ); ?> value='future'><?php _e('Scheduled') ?></option>
	<?php else : ?>
	<option<?php selected( $post->post_status, 'publish' ); ?> value='publish'><?php _e('Published') ?></option>
	<?php endif; ?>

	<option<?php selected( $post->post_status, 'expired' ); ?> value='expired'><?php _e('Expired') ?></option>
	<option<?php selected( $post->post_status, 'pending' ); ?> value='pending'><?php _e('Pending Review') ?></option>
	<?php if ( 'auto-draft' == $post->post_status ) : ?>
	<option<?php selected( $post->post_status, 'auto-draft' ); ?> value='draft'><?php _e('Draft') ?></option>
	<?php else : ?>
	<option<?php selected( $post->post_status, 'draft' ); ?> value='draft'><?php _e('Draft') ?></option>
	<?php endif; ?>
	</select>
	 <a href="#post_status" class="save-post-status hide-if-no-js button"><?php _e('OK'); ?></a>
	 <a href="#post_status" class="cancel-post-status hide-if-no-js"><?php _e('Cancel'); ?></a>
	</div>

	<?php } ?>
	</div>
	<?php // /misc-pub-section ?>

	<div class="misc-pub-section " id="visibility">
	<?php _e('Visibility:'); ?> <span id="post-visibility-display"><?php

	if ( 'private' == $post->post_status ) {
		$post->post_password = '';
		$visibility = 'private';
		$visibility_trans = __('Private');
	} elseif ( !empty( $post->post_password ) ) {
		$visibility = 'password';
		$visibility_trans = __('Password protected');
	} elseif ( $post_type == 'post' && is_sticky( $post->ID ) ) {
		$visibility = 'public';
		$visibility_trans = __('Public, Sticky');
	} else {
		$visibility = 'public';
		$visibility_trans = __('Public');
	}

	echo esc_html( $visibility_trans ); ?></span>
	<?php if ( $can_publish ) { ?>
	<a href="#visibility" class="edit-visibility hide-if-no-js"><?php _e('Edit'); ?></a>

	<div id="post-visibility-select" class="hide-if-js">
	<input type="hidden" name="hidden_post_password" id="hidden-post-password" value="<?php echo esc_attr($post->post_password); ?>" />
	<?php if ($post_type == 'post'): ?>
	<input type="checkbox" style="display:none" name="hidden_post_sticky" id="hidden-post-sticky" value="sticky" <?php checked(is_sticky($post->ID)); ?> />
	<?php endif; ?>
	<input type="hidden" name="hidden_post_visibility" id="hidden-post-visibility" value="<?php echo esc_attr( $visibility ); ?>" />


	<input type="radio" name="visibility" id="visibility-radio-public" value="public" <?php checked( $visibility, 'public' ); ?> /> <label for="visibility-radio-public" class="selectit"><?php _e('Public'); ?></label><br />
	<?php if ( $post_type == 'post' && current_user_can( 'edit_others_posts' ) ) : ?>
	<span id="sticky-span"><input id="sticky" name="sticky" type="checkbox" value="sticky" <?php checked( is_sticky( $post->ID ) ); ?> tabindex="4" /> <label for="sticky" class="selectit"><?php _e( 'Stick this post to the front page' ); ?></label><br /></span>
	<?php endif; ?>
	<input type="radio" name="visibility" id="visibility-radio-password" value="password" <?php checked( $visibility, 'password' ); ?> /> <label for="visibility-radio-password" class="selectit"><?php _e('Password protected'); ?></label><br />
	<span id="password-span"><label for="post_password"><?php _e('Password:'); ?></label> <input type="text" name="post_password" id="post_password" value="<?php echo esc_attr($post->post_password); ?>" /><br /></span>
	<input type="radio" name="visibility" id="visibility-radio-private" value="private" <?php checked( $visibility, 'private' ); ?> /> <label for="visibility-radio-private" class="selectit"><?php _e('Private'); ?></label><br />

	<p>
	 <a href="#visibility" class="save-post-visibility hide-if-no-js button"><?php _e('OK'); ?></a>
	 <a href="#visibility" class="cancel-post-visibility hide-if-no-js"><?php _e('Cancel'); ?></a>
	</p>
	</div>
	<?php } ?>

	</div>
	<?php // /misc-pub-section ?>

	<?php
	// translators: Publish box date format, see http://php.net/date
	$datef = __( 'M j, Y @ G:i' );
	if ( 0 != $post->ID ) {
		if ( 'future' == $post->post_status ) { // scheduled for publishing at a future date
			$stamp = __('Scheduled for: <b>%1$s</b>');
		} else if ( 'publish' == $post->post_status || 'private' == $post->post_status || 'expired' == $post->post_status ) { // already published
			$stamp = __('Published on: <b>%1$s</b>');
		} else if ( '0000-00-00 00:00:00' == $post->post_date_gmt ) { // draft, 1 or more saves, no date specified
			$stamp = __('Publish <b>immediately</b>');
		} else if ( time() < strtotime( $post->post_date_gmt . ' +0000' ) ) { // draft, 1 or more saves, future date specified
			$stamp = __('Schedule for: <b>%1$s</b>');
		} else { // draft, 1 or more saves, date specified
			$stamp = __('Publish on: <b>%1$s</b>');
		}
		$date = date_i18n( $datef, strtotime( $post->post_date ) );
	} else { // draft (no saves, and thus no date specified)
		$stamp = __('Publish <b>immediately</b>');
		$date = date_i18n( $datef, strtotime( current_time('mysql') ) );
	}

	if ( $can_publish ) : // Contributors don't get to choose the date of publish ?>
	<div class="misc-pub-section curtime misc-pub-section-last">
		<span id="timestamp">
		<?php printf($stamp, $date); ?></span>
		<a href="#edit_timestamp" class="edit-timestamp hide-if-no-js" tabindex='4'><?php _e('Edit') ?></a>
		<div id="timestampdiv" class="hide-if-js"><?php touch_time(($action == 'edit'),1,4); ?></div>
	</div><?php // /misc-pub-section ?>
	<?php endif; ?>

	<?php do_action('post_submitbox_misc_actions'); ?>
	</div>
	<div class="clear"></div>
	</div>

	<div id="major-publishing-actions">
	<?php do_action('post_submitbox_start'); ?>
	<div id="delete-action">
	<?php
	if ( current_user_can( "delete_post", $post->ID ) ) {
		if ( !EMPTY_TRASH_DAYS )
			$delete_text = __('Delete Permanently');
		else
			$delete_text = __('Move to Trash');
		?>
	<a class="submitdelete deletion" href="<?php echo get_delete_post_link($post->ID); ?>"><?php echo $delete_text; ?></a><?php
	} ?>
	</div>

	<div id="publishing-action">
	<span class="spinner"></span>
	<?php
	if ( !in_array( $post->post_status, array('publish', 'future', 'private', 'expired') ) || 0 == $post->ID ) {
		if ( $can_publish ) :
			if ( !empty($post->post_date_gmt) && time() < strtotime( $post->post_date_gmt . ' +0000' ) ) : ?>
			<input name="original_publish" type="hidden" id="original_publish" value="<?php esc_attr_e('Schedule') ?>" />
			<?php submit_button( __( 'Schedule' ), 'primary', 'publish', false, array( 'tabindex' => '5', 'accesskey' => 'p' ) ); ?>
	<?php	else : ?>
			<input name="original_publish" type="hidden" id="original_publish" value="<?php esc_attr_e('Publish') ?>" />
			<?php submit_button( __( 'Publish' ), 'primary', 'publish', false, array( 'tabindex' => '5', 'accesskey' => 'p' ) ); ?>
	<?php	endif;
		else : ?>
			<input name="original_publish" type="hidden" id="original_publish" value="<?php esc_attr_e('Submit for Review') ?>" />
			<?php submit_button( __( 'Submit for Review' ), 'primary', 'publish', false, array( 'tabindex' => '5', 'accesskey' => 'p' ) ); ?>
	<?php
		endif;
	} else { ?>
			<input name="original_publish" type="hidden" id="original_publish" value="<?php esc_attr_e('Update') ?>" />
			<input name="save" type="submit" class="button-primary" id="publish" tabindex="5" accesskey="p" value="<?php esc_attr_e('Update') ?>" />
	<?php
	} ?>
	</div>
	<div class="clear"></div>
	</div>
	</div>
	<?php
}

/**
 * Add quick/bulk edit jobs js script into admin header script
 *
 * Temporary hack until WP will fully support custom post statuses
 *
 * @since 1.0
 *
 * @param object $post
 */
function wpnuke_statuses_quick_edit_script() {  
	global $pagenow;  
		
	if($pagenow == 'edit.php' && (isset($_GET['post_type']) && $_GET['post_type'] == 'job') && !isset($_GET['action'])) {  
?>
	<script type="text/javascript">	
		//<![CDATA[	
		jQuery(document).ready(function() {

		if ( jQuery('select[name="_status"]').length > 0 ) {
			wpnuke_append_to_dropdown('select[name="_status"]');
			// Refresh the custom status dropdowns everytime Quick Edit is loaded
			jQuery('#the-list a.editinline').bind( 'click', function() {
				wpnuke_append_to_dropdown('#the-list select[name="_status"]');
			} );
		}
	  
		function wpnuke_append_to_dropdown( id ) {
			// Add "Expired" status to quick-edit
			if ( id=='select[name="_status"]' ) {
				jQuery(id).append(jQuery('<option></option')
					.attr('value','expired')
					.text('Expired')
				);
			}
		}
		
		});	
		//]]>
	</script>
<?php
	}
}
add_action('admin_head', 'wpnuke_statuses_quick_edit_script', 10, 1);

/**
 * Display job companies form fields admin meta box.
 *
 * Temporary fix for custom job_category taxonomy meta box
 *
 * @since 1.0
 *
 * @param object $post
 */
function wpnuke_job_companies_meta_box( $post, $box ) {
	$defaults = array('taxonomy' => 'job_company');
	if ( !isset($box['args']) || !is_array($box['args']) )
		$args = array();
	else
		$args = $box['args'];
	extract( wp_parse_args($args, $defaults), EXTR_SKIP );
	$tax = get_taxonomy($taxonomy);	
	?>
	<div id="taxonomy-<?php echo $taxonomy; ?>" class="categorydiv">
		<ul id="<?php echo $taxonomy; ?>-tabs" class="category-tabs">
			<li class="tabs"><a href="#<?php echo $taxonomy; ?>-all"><?php echo $tax->labels->all_items; ?></a></li>
			<li class="hide-if-no-js"><a href="#<?php echo $taxonomy; ?>-pop"><?php _e( 'Most Used' ); ?></a></li>
		</ul>

		<div id="<?php echo $taxonomy; ?>-pop" class="tabs-panel" style="display: none;">
			<ul id="<?php echo $taxonomy; ?>checklist-pop" class="categorychecklist form-no-clear" >
				<?php $popular_ids = wp_popular_terms_checklist($taxonomy); ?>
			</ul>
		</div>

		<div id="<?php echo $taxonomy; ?>-all" class="tabs-panel">
			<?php
            $name = ( $taxonomy == 'category' ) ? 'post_category' : 'tax_input[' . $taxonomy . ']';
            echo "<input type='hidden' name='{$name}[]' value='0' />"; // Allows for an empty term set to be sent. 0 is an invalid Term ID and will be ignored by empty() checks.
            ?>
			<ul id="<?php echo $taxonomy; ?>checklist" data-wp-lists="list:<?php echo $taxonomy?>" class="categorychecklist form-no-clear">
				<?php
				// modify
				// wp_terms_checklist($post->ID, array( 'taxonomy' => $taxonomy, 'popular_cats' => $popular_ids ) )
				wp_terms_checklist($post->ID, array( 'taxonomy' => $taxonomy, 'popular_cats' => $popular_ids, 'checked_ontop' => false ) )
				?>
			</ul>
		</div>
	<?php if ( current_user_can($tax->cap->edit_terms) ) : ?>
			<div id="<?php echo $taxonomy; ?>-adder" class="wp-hidden-children">
				<h4>
					<a id="<?php echo $taxonomy; ?>-add-toggle" href="#<?php echo $taxonomy; ?>-add" class="hide-if-no-js">
						<?php
							/* translators: %s: add new taxonomy label */
							printf( __( '+ %s' ), $tax->labels->add_new_item );
						?>
					</a>
				</h4>
				<p id="<?php echo $taxonomy; ?>-add" class="category-add wp-hidden-child">
					<label class="screen-reader-text" for="new<?php echo $taxonomy; ?>"><?php echo $tax->labels->add_new_item; ?></label>
					<input type="text" name="new<?php echo $taxonomy; ?>" id="new<?php echo $taxonomy; ?>" class="form-required form-input-tip" value="<?php echo esc_attr( $tax->labels->new_item_name ); ?>" aria-required="true"/>
					<label class="screen-reader-text" for="new<?php echo $taxonomy; ?>_parent">
						<?php echo $tax->labels->parent_item_colon; ?>
					</label>
					<?php wp_dropdown_categories( array( 'taxonomy' => $taxonomy, 'hide_empty' => 0, 'name' => 'new'.$taxonomy.'_parent', 'orderby' => 'name', 'hierarchical' => 1, 'show_option_none' => '&mdash; ' . $tax->labels->parent_item . ' &mdash;' ) ); ?>
					<input type="button" id="<?php echo $taxonomy; ?>-add-submit" data-wp-lists="add:<?php echo $taxonomy ?>checklist:<?php echo $taxonomy ?>-add" class="button category-add-submit" value="<?php echo esc_attr( $tax->labels->add_new_item ); ?>" />
					<?php wp_nonce_field( 'add-'.$taxonomy, '_ajax_nonce-add-'.$taxonomy, false ); ?>
					<span id="<?php echo $taxonomy; ?>-ajax-response"></span>
				</p>
			</div>
		<?php endif; ?>
	</div>
	<?php
}

?>
