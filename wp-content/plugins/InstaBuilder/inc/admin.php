<?php
require_once( OPL_PATH . 'inc/admin-shortcode.php' );
require_once( OPL_PATH . 'inc/styles.php' );
require_once( OPL_PATH . 'inc/media.php' );

function opl_admin_scripts() {
	// load js for admin page
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'jquery-ui-sortable' );
	
	wp_enqueue_script( 'ajax-upload', OPL_URL . 'js/ajaxupload.js' );
	wp_enqueue_script( 'opl-jscolor', OPL_URL . 'js/jscolor/jscolor.js' );
	wp_enqueue_script( 'validationEngine-lang', OPL_URL . 'js/validation/js/languages/jquery.validationEngine-en.js' );
	wp_enqueue_script( 'validationEngine', OPL_URL . 'js/validation/js/jquery.validationEngine.js' );
	wp_enqueue_script( 'opl-admin', OPL_URL . 'js/admin.js' );
}

function opl_admin_styles() {
	// load css for admin page
	wp_enqueue_style( 'validationEngine', OPL_URL . 'js/validation/css/validationEngine.jquery.css' );
	wp_enqueue_style( 'opl-admin', OPL_URL . 'css/admin.css' );
}

add_action('admin_init', 'opl_save_all');
function opl_save_all() {
	opl_update_settings();
}

add_action('admin_menu', 'opl_add_admin');
function opl_add_admin() {
	$opl = add_menu_page('InstaBuilder', 'InstaBuilder', 'manage_options', 'opl-settings', 'opl_admin', OPL_URL . 'images/ez-icon.png');
	$config = add_submenu_page('opl-settings', 'Settings', 'Settings', 'manage_options', 'opl-settings', 'opl_admin');
	$splits = add_submenu_page('opl-settings', 'Split Tests', 'Split Tests', 'manage_options', 'opl-splits', 'opl_admin');
	//$split = add_submenu_page('opl-settings', 'Split Tests', 'Add Split Test', 'manage_options', 'opl-splits&mode=add-split-test', 'opl_admin');
	
	add_action( "admin_print_scripts-$opl", 'opl_admin_scripts' );
	add_action( "admin_print_scripts-$config", 'opl_admin_scripts' );
	add_action( "admin_print_scripts-$splits", 'opl_admin_scripts' );
	//add_action( "admin_print_scripts-$split", 'opl_admin_scripts' );
	
	add_action( "admin_print_styles-$opl", 'opl_admin_styles' );
	add_action( "admin_print_styles-$config", 'opl_admin_styles' );
	add_action( "admin_print_styles-$splits", 'opl_admin_styles' );
	//add_action( "admin_print_scripts-$split", 'opl_admin_scripts' );
	
	add_action("admin_print_scripts-post.php", 'opl_admin_scripts');
	add_action("admin_print_scripts-post-new.php", 'opl_admin_scripts');
	add_action("admin_print_styles-post.php", 'opl_admin_styles');
	add_action("admin_print_styles-post-new.php", 'opl_admin_styles');
	add_action("admin_print_styles-edit.php", 'opl_admin_styles');
}

function opl_admin() {
	$page = ( isset($_GET['page']) ) ? $_GET['page'] : '';

	switch ( $page ) {
		case 'opl-settings':
			opl_settings();
			break;
		case 'opl-splits':
			opl_splits();
			break;
	}
}

function opl_settings() {
	require_once( OPL_PATH . 'inc/settings.php' );
}

function opl_splits() {
	$mode = ( isset($_GET['mode']) ) ? $_GET['mode'] : '';

	switch ( $mode ) {
		case 'edit-split-test':
		case 'add-split-test':
			require_once( OPL_PATH . 'inc/split.php' );
			break;
		default:
			require_once( OPL_PATH . 'inc/splits.php' );
	}
	
}

function opl_update_settings() {
	if ( isset($_POST['action']) && $_POST['action'] == 'save_opl_settings' ) {
		$settings = get_option('opl_settings');
		if ( !is_array($settings) )
			$settings = array();

		$settings['disable_powered'] = ( isset($_POST['disable_powered']) ) ? 1 : 0;
		foreach ( $_POST as $key => $value ) {
			$settings[$key] = $value;
		}

		update_option('opl_settings', $settings);

		wp_redirect(admin_url('admin.php?page=opl-settings&saved=true'));
		exit;
	}	
}

function opl_get_templates() {
	$templates = array();
	$template_path = OPL_PATH . '/templates';
	if ( is_dir($template_path) ) :
		if ( $tmp_dir = opendir($template_path) ) :
			while ( ( $template = readdir($tmp_dir) ) !== false ) :
				if ( $template != '.' && $template != '..' )
					$templates[] = $template;
			endwhile;
		endif;
	endif;
		
	$tmpl = array();
	$tmpl_num = count($templates);
	for ( $i=0; $i<$tmpl_num; $i++ ) {
		$tmpl_file = $template_path . '/' . $templates[$i] . '/style.css';
		if ( file_exists ( $tmpl_file ) ) :
			$tmpl_info = array(
					'Name' => 'Template Name',
					'URI' => 'Template URI',
					'Colors' => 'Colors',
					'Author' => 'Author',
					'AuthorURI' => 'Author URI'
				);
			
			$data = get_file_data($tmpl_file, $tmpl_info, 'theme' );
			$tmpl[$templates[$i]]['name'] = $data['Name'];
			$tmpl[$templates[$i]]['colors'] = $data['Colors'];
		endif;
	}

	unset($templates);
	
	return $tmpl;
}

function opl_get_template_color( $template ) {
	$tmp = opl_get_templates();
	
	return opl_isset($tmp[$template]['colors']);
}

function opl_default_template_color() {
	$tmp = opl_get_templates();

	$default_colors = '';
	if ( $tmp ) : 
		$i = 0;
		foreach ( $tmp as $k => $v ) :
			if ( $i == 0 && opl_isset($v['colors']) != '' ) :
				$default_colors = $v['colors'];
				break;
			endif;
			$i++;
		endforeach;
	endif;

	return $default_colors;
}

add_action('wp_ajax_opl_get_color', 'opl_get_color');
function opl_get_color() {
	if ( opl_isset($_POST['type']) == 'get_color' ) {
		$colors = opl_get_template_color( $_POST['template'] );
		echo $colors;
	}
	die;
}

function opl_get_menus() {
	$menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );
	return $menus;
}

add_action('wp_ajax_opl_upload', 'opl_upload_callback');
function opl_upload_callback() {
	if ( isset($_POST['type']) ) {
		if ( $_POST['type'] == 'upload' ) {
			$clickedID = $_POST['data'];
			$filename = $_FILES[$clickedID];
			$filename['name'] = preg_replace('/[^a-zA-Z0-9._\-]/', '', $filename['name']);

			$override['test_form'] = false;
			$override['action'] = 'wp_handle_upload';    
			$uploaded_file = wp_handle_upload( $filename, $override );

			$upload_tracking[] = $clickedID;

			if (!empty($uploaded_file['error'])) {
				echo 'Upload Error: ' . $uploaded_file['error']; 
			} else { 
				echo $uploaded_file['url']; 
			} // Is the Response

			die;
		}
	}
}

add_action('wp_ajax_opl_smart_url', 'opl_smart_url');
function opl_smart_url(){
	if ( isset($_POST['type']) && $_POST['type'] == 'get_smart_url' ) {
		$page_id = (int) $_POST['page_id'];
		$squeeze_id = (int) $_POST['squeeze_id'];
		$opl_list = md5('smart_optin' . $page_id . time());
		if ( !empty($page_id) )
			echo opl_format_url($page_id, "opl_ID={$squeeze_id}&opl_list={$opl_list}");
		else
			echo 'failed';
	}
	die;
}

add_action('admin_head', 'opl_js_vars');
function opl_js_vars() {
	if ( isset($_GET['post']) ) {
		$editor = get_post_meta($_GET['post'], 'opl_editor', true);
		if ( !empty($editor) && is_array($editor) ) {
			$num = count($editor) + 2;
			$el_num = 'var el_num_id = ' . $num . ';';
		} else {
			$el_num = 'var el_num_id = 0;';
		}
	} else {
		$el_num = 'var el_num_id = 0;';
	}
?>
	<script type="text/javascript">
		var opl_img_path = '<?php echo OPL_URL; ?>images/';
		<?php echo $el_num; ?>
	</script>
<?php
}

function opl_add_launch_item() {
	if ( isset($_REQUEST['type']) && $_REQUEST['type'] == 'add_launch_item' ) {
		$launch_num = $_REQUEST['launch_num'];
	?>
	<ul id="opl-meta" style="margin:0;padding:0">
		<li class="opl-property">
			<div style="float:right"><a href="#" class="remove-launch-item" title="Remove this item"><img src="<?php echo OPL_URL; ?>images/delete.png" border="0" title="Remove this item" /></a></div>
			<label for="opl_launch_text"><?php printf(__('Title #%s', 'opl'), $launch_num); ?></label>
			<input class="widefat" type="text" name="opl_launch_item[<?php echo $launch_num; ?>][title]" id="opl_launch_text" value="" />
		</li>
		<li class="opl-property">
			<label for="opl_launch_thumb"><?php printf(__('Thumb/Image URL #%s', 'opl'), $launch_num); ?></label>
			<input type="text" name="opl_launch_item[<?php echo $launch_num; ?>][thumb]" id="opl_launch_thumb" value="" class="widefat uploaded_url" style="width:75%;" />
			<span id="opl_<?php echo $launch_num; ?>_upload-btn" class="opl_upload_button button">Upload Image</span>
		</li>
		<li class="opl-property">
			<label for="opl_launch_page"><?php printf(__('Link To Page #%s', 'opl'), $launch_num); ?></label>
			<select name="opl_launch_item[<?php echo $launch_num; ?>][page]" id="opl_launch_page" class="widefat">
				<option value=''>[ -- Select Page -- ]</option>
				<option value='unreleased'>-- UNRELEASED --</option>
				<?php if ( get_pages() ) :
					foreach ( get_pages() as $page ) :
						echo '<option value="' . $page->ID . '">' . $page->post_title . '</option>';
					endforeach; endif;
				?>
			</select>
			<div class="opl-desc"><?php _e('Set the launch item\'s title, image/thumb, and choose the destination page. If the next launch sequence isn\'t ready or unreleased, then simply choose "UNRELEASED" in the page option above.', 'opl'); ?></div>
			<div class="opl-hr"></div>
		</li>
	</ul>
<?php
	}
	die;
}

// SPLIT TEST FUNCTIONS
add_action('admin_init', 'opl_split_process_form');
function opl_split_process_form() {
	if ( isset($_REQUEST['action']) ) {
		switch ( $_REQUEST['action'] ) {
			case 'opl_save_split':
				opl_save_split();
				break;
			case 'opl-delete-split':
				opl_delete_split();
				// Redirect
				wp_redirect(admin_url('admin.php?page=opl-splits'));
				exit;
				break;
			case 'opl_bulk_actions':
				opl_delete_splits();
				// Redirect
				wp_redirect(admin_url('admin.php?page=opl-splits'));
				exit;
				break;
			default:
				return;
		}
	}
}

function opl_delete_splits() {
	global $wpdb;
	
	$nonce = $_REQUEST['_opl_nonce'];
	if ( !wp_verify_nonce($nonce, 'opl-nonce') )
		wp_die('You do not have sufficient permissions to access this page.');
	
	if ( opl_isset($_POST['bulk']) == 'splits' ) {
		$bulk_action = ( isset($_POST['opl-splits-submit2']) ) ? $_POST['opl_action2'] : $_POST['opl_action'];
		if ( $bulk_action == 'delete' ) {
			if ( is_array($_POST['opl_id']) && count($_POST['opl_id']) > 0 ) {
				foreach ( $_POST['opl_id'] as $split ) {
					opl_delete_split( $split );
				}
			}
		}
	}
}

function opl_delete_split( $link_id = '' ) {
	global $wpdb;
	
	$nonce = $_REQUEST['_opl_nonce'];
	if ( !wp_verify_nonce($nonce, 'opl-nonce') )
		wp_die('You do not have sufficient permissions to access this page.');
	
	$id = ( $link_id == '' ) ? (int) $_GET['id'] : (int) $link_id;
	
	// Delete the stats & conversions entries
	$wpdb->query($wpdb->prepare("DELETE FROM `{$wpdb->prefix}opl_stats` WHERE link_id = %d", $id));
	$wpdb->query($wpdb->prepare("DELETE FROM `{$wpdb->prefix}opl_conversions` WHERE link_id = %d", $id));
	
	// Delete the split test URLs
	$wpdb->query($wpdb->prepare("DELETE FROM `{$wpdb->prefix}opl_splits` WHERE link_id = %d", $id));
	
	// Delete the main campaign
	$wpdb->query($wpdb->prepare("DELETE FROM `{$wpdb->prefix}opl_links` WHERE ID = %d", $id));
	
}

function opl_generate_slug() {
	$length = 16;
	$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
	$string = '';

	for ($p = 0; $p < $length; $p++) {
   		$string .= $characters[mt_rand(0, strlen($characters)-1)];
	}

	$encrypt = md5($string . time());
	$slug = strtolower(substr($encrypt, 0, 5));

	return $slug;
}

add_action('admin_footer', 'opl_split_admin_js');
function opl_split_admin_js() {
?>
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery(".add_new_url").click(function(e){
		var url_field = '<div class="split-url">Page: <?php echo opl_split_pages(); ?>&nbsp;Weight: <input name="dest_urls_weight[]" type="text" id="dest_urls_weight" value="1" class="regular-text dest-weight" style="width:45px" /><input type="hidden" name="dest_urls_id[]" id="dest_urls_id" value="0" /> <img src="<?php echo OPL_URL; ?>images/delete.png" border="0" style="cursor:pointer; vertical-align:middle;" alt="remove" title="Remove" class="js-empty-field" /></div>';
		jQuery("#urls-holder").append(url_field);
		jQuery('.js-empty-field').each(function(){
			var $this = jQuery(this);
			$this.click(function(e){
				$this.parent().remove();
			});
		});
		jQuery('.dest-weight').each(function(){
			var $this = jQuery(this);
			$this.keyup(function(){
				if ( $this.val() == 0 )
					$this.val(1);
			});
		});
		e.preventDefault();
	});
});
</script>
<?php
}

function opl_remove_split_url() {
	global $wpdb;

	if ( opl_isset($_POST['type']) == 'remove_url' ) {
		$id = (int) $_POST['sid'];
		$result = $wpdb->query($wpdb->prepare("DELETE FROM `{$wpdb->prefix}opl_splits` WHERE ID = %d", $id));
		if ( is_wp_error($result) ) {
			$error_msg = $result->get_error_message();
			echo $error_msg;
		} else {
			echo 'deleted';
		}
	}
	die;
}

function opl_split_pages( $post_id = 0 ) {
	$pages = get_pages();
	$html = '';
	if ( $pages ) {
		$html .= '<select name="dest_urls[]" id="dest_urls" style="width:280px" class="validate[required]">';
		$html .= '<option value="">[ -- Select a Page -- ]</option>';
		foreach ( $pages as $page ) {
			$selected = ( $page->ID == $post_id ) ? ' selected="selected"' : '';
			$html .= '<option value="' . $page->ID . '"' . $selected . '>' . $page->post_title . '</option>';
		}
		$html .= '</select>';
	}
	
	return str_replace( array("\r", "\n", "\r\n"), '', $html);
}

function opl_check_slug( $slug, $lid = '' ) {
	global $wpdb;
	$used = false;
	if ( $ID = $wpdb->get_var($wpdb->prepare("SELECT ID FROM `{$wpdb->posts}` WHERE `post_name` = '%s'", $slug)) )
		$used = $ID;

	// check slug for other created campaigns
	if ( $lid == '' && $ID = $wpdb->get_var($wpdb->prepare("SELECT ID FROM `{$wpdb->prefix}opl_links` WHERE `slug` = '%s'", $slug)) )
		$used = $ID;
	
	if ( is_numeric($lid) && $ID = $wpdb->get_var($wpdb->prepare("SELECT ID FROM `{$wpdb->prefix}opl_links` WHERE `slug` = '%s' AND ID != %d", $slug, $lid)) )
		$used = $ID;
		
	return $used;
}

function opl_save_split() {
	$nonce = $_REQUEST['_opl_nonce'];
	if ( !wp_verify_nonce($nonce, 'opl-nonce') )
		wp_die('You do not have sufficient permissions to access this page.');

	// Check slug first...
	if ( isset($_POST['link_id']) )
		$chk_slug = opl_check_slug( trim($_POST['link_slug']), $_POST['link_id']);
	else
		$chk_slug = opl_check_slug( trim($_POST['link_slug']) );
		
	if ( $chk_slug !== FALSE ) {
		echo '<script>alert("ERROR: Slug \'' . $_POST['link_slug'] . '\' is NOT available.\nPlease choose another name for the slug.");history.back();</script>';
		exit;
	}
	
	if ( opl_isset($_POST['dest_urls'][0]) == '' && opl_isset($_POST['dest_urls'][1]) == '' ) {
		echo '<script>alert("ERROR: You must choose at least two pages for the split test campaign.");history.back();</script>';
		exit;
	}

	if ( $_POST['c_page'] != '' && in_array($_POST['c_page'], $_POST['dest_urls']) ) {
		echo '<script>alert("ERROR: Conversion page already used as one of the split test pages. Please choose a different page.");history.back();</script>';
		exit;
	}
	
	global $wpdb;

	$metadata = array(
			'conversion_value' => trim($_POST['conversion_value'])
		);

	$values = array(
			'name' => trim($_POST['link_name']),
			'slug' => trim($_POST['link_slug']),
			'redir_type' => $_POST['redir_type'],
			'conversion_id' => $_POST['c_page'],
			'data' => maybe_serialize($metadata),
			'created' => time()
		);

	if ( isset($_POST['link_id']) ) {
		// update the link
		$link_id = (int) $_POST['link_id'];
		$wpdb->update("{$wpdb->prefix}opl_links", $values, array('ID' => $link_id));
		$redirect = admin_url('admin.php?page=opl-splits&mode=edit-split-test&id=' . $link_id . '&updated=true');
		
		$split = opl_get_split( $link_id );
		if ( opl_isset($split->conversion_id) !=  $_POST['c_page'] )
			delete_post_meta($_POST['dest_urls'], 'opl_split_conversion');
			
	} else {
		$values['created'] = time();
		// insert new link
		$wpdb->insert("{$wpdb->prefix}opl_links", $values);
		$link_id = $wpdb->insert_id;
		$redirect = admin_url('admin.php?page=opl-splits&mode=edit-split-test&id=' . $link_id . '&added=true');
	}
	
	if ( $_POST['c_page'] != '' )
		update_post_meta($_POST['c_page'], 'opl_split_conversion', array('conversion' => 'true', 'link_id' => $link_id));
	
	wp_cache_delete($link_id, 'opl_splits');
	opl_save_urls($_POST['dest_urls'], $_POST['dest_urls_weight'], $_POST['dest_urls_id'], $link_id);

	wp_redirect($redirect);
	exit;
}

function opl_save_urls($urls, $weights, $ids, $link_id) {
	global $wpdb;

	if ( empty($urls) )
		return false;

	if ( is_array($urls) && count($urls) > 0 ) {
		for ( $i=0; $i<count($urls); $i++ ) {
			if ( !empty($urls[$i]) ) {
				$weight = ( $weights[$i] == '' || $weights[$i] < 1 ) ? 1 : $weights[$i];
				$data = array(
					'link_id' => $link_id,
					'post_id' => $urls[$i],
					'weight' => $weight,
					'next' => 0
				);

				if ( $ids[$i] > 0 ) {
					$wpdb->update("{$wpdb->prefix}opl_splits", $data, array('ID' => $ids[$i]));
				} else {
					$wpdb->insert("{$wpdb->prefix}opl_splits", $data);
				}
			}
		}
		wp_cache_delete($link_id, 'opl_split_urls');
	}	
}

function opl_stat_clicks( $link_id, $split_id = 0, $mode = 'all' ) {
	global $wpdb;
	
	$today = strtotime("today");
	$yesterday = strtotime("yesterday");
	$seven_days_ago = strtotime("7 days ago");
	$thirty_days_ago = strtotime("30 days ago");
	
	$q = '';
	if ( $mode == 'today' )
		$q = " AND date >= $today";
	else if ( $mode == 'yesterday' )
		$q = " AND date >= $yesterday";
	else if ( $mode == 'seven' )
		$q = " AND date >= $seven_days_ago";
	else if ( $mode == 'thirty' )
		$q = " AND date >= $thirty_days_ago";
	
	if ( $split_id > 0 )
		$qry = $wpdb->get_results("SELECT `visitor_id` FROM `{$wpdb->prefix}opl_stats` WHERE link_id = {$link_id} AND split_id = {$split_id}{$q} ORDER BY ID ASC");
	else
		$qry = $wpdb->get_results("SELECT `visitor_id` FROM `{$wpdb->prefix}opl_stats` WHERE link_id = {$link_id}{$q} ORDER BY ID ASC");
	
	$raw_clicks = $wpdb->num_rows;
	
	if ( $split_id > 0 )
		$qry = $wpdb->get_results("SELECT DISTINCT `visitor_id` FROM `{$wpdb->prefix}opl_stats` WHERE link_id = {$link_id} AND split_id = {$split_id}{$q} ORDER BY ID ASC");
	else
		$qry = $wpdb->get_results("SELECT DISTINCT `visitor_id` FROM `{$wpdb->prefix}opl_stats` WHERE link_id = {$link_id}{$q} ORDER BY ID ASC");
	
	$clicks = $wpdb->num_rows;
	
	return array('raw' => $raw_clicks, 'unique' => $clicks );
}

function opl_stat_conversions( $link_id, $split_id = 0, $mode = 'all' ) {
	global $wpdb;
	
	$today = strtotime("today");
	$yesterday = strtotime("yesterday");
	$seven_days_ago = strtotime("7 days ago");
	$thirty_days_ago = strtotime("30 days ago");
	
	$q = '';
	if ( $mode == 'today' )
		$q = " AND date >= $today";
	else if ( $mode == 'yesterday' )
		$q = " AND date >= $yesterday";
	else if ( $mode == 'seven' )
		$q = " AND date >= $seven_days_ago";
	else if ( $mode == 'thirty' )
		$q = " AND date >= $thirty_days_ago";
	
	if ( $split_id > 0)
		$qry = $wpdb->get_results("SELECT DISTINCT `visitor_id` FROM `{$wpdb->prefix}opl_conversions` WHERE link_id = {$link_id} AND split_id = {$split_id}{$q} ORDER BY ID ASC");
	else
		$qry = $wpdb->get_results("SELECT DISTINCT `visitor_id` FROM `{$wpdb->prefix}opl_conversions` WHERE link_id = {$link_id}{$q} ORDER BY ID ASC");
	
	return $wpdb->num_rows;
}

function opl_stat_revenue( $link_id, $split_id = 0, $mode = 'all' ) {
	global $wpdb;
	
	$today = strtotime("today");
	$yesterday = strtotime("yesterday");
	$seven_days_ago = strtotime("7 days ago");
	$thirty_days_ago = strtotime("30 days ago");
	
	$q = '';
	if ( $mode == 'today' )
		$q = " AND date >= $today";
	else if ( $mode == 'yesterday' )
		$q = " AND date >= $yesterday";
	else if ( $mode == 'seven' )
		$q = " AND date >= $seven_days_ago";
	else if ( $mode == 'thirty' )
		$q = " AND date >= $thirty_days_ago";
	
	if ( $split_id > 0)
		$conversions = $wpdb->get_results("SELECT DISTINCT `visitor_id`, revenue FROM `{$wpdb->prefix}opl_conversions` WHERE link_id = {$link_id} AND split_id = {$split_id}{$q} ORDER BY ID ASC");
	else
		$conversions = $wpdb->get_results("SELECT DISTINCT `visitor_id`, revenue FROM `{$wpdb->prefix}opl_conversions` WHERE link_id = {$link_id}{$q} ORDER BY ID ASC");
		
	$total = 0;
	foreach ( $conversions as $conversion ) {
		$total += $conversion->revenue;
	}
	
	return $total;
}
// HOOKS
add_action('wp_ajax_opl_add_launch', 'opl_add_launch_item');
add_action('wp_ajax_opl_remove_url', 'opl_remove_split_url');