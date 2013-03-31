<?php
//------------------------------------------------------
//-------------- DASHBOARD PAGE -------------------------

/**
 * Registers custom dashboard widget
 */
function wpnuke_admin_dashboard_setup(){
	$dashboard_title = apply_filters('wpnuke_dashboard_title', __('Jobs', 'wpnuke'));
	wp_add_dashboard_widget('job_dashboard', $dashboard_title, 'wpnuke_dashboard_widget');
}
//add_action('wp_dashboard_setup', 'wpnuke_admin_dashboard_setup' );
// Hint: For Multisite Network Admin Dashboard use wp_network_dashboard_setup instead of wp_dashboard_setup.

/**
 * Displays custom dashboard UI
 */
function wpnuke_dashboard_widget(){
	if(sizeof($forms) > 0){
	?>
	<table class="widefat" cellspacing="0" style="border:0px;">
	<thead>
	<tr>
	<td style="text-align:left; padding:8px 18px!important; font-weight:bold;"><i><?php _e("Title", "wpnuke") ?></i></td>
	<td style="text-align:center; padding:8px 18px!important; font-weight:bold;"><i><?php _e("Applicants", "wpnuke") ?></i></td>
	<td style="text-align:center; padding:8px 18px!important; font-weight:bold;"><i><?php _e("Status", "wpnuke") ?></i></td>
	</tr>
	</thead>

	<tbody class="list:user user-list">
	<?php
	foreach($forms as $form){
	$date_display = GFCommon::format_date($form["last_lead_date"]);
	if(!empty($form["total_leads"])){
	?>
	<tr class='author-self status-inherit' valign="top">
	<td class="column-title" style="padding:8px 18px;">
	<a style="display:inline; <?php echo  $form["unread_count"] > 0 ? "font-weight:bold;" : "" ?>" href="admin.php?page=wpnuke_entries&view=entries&id=<?php echo absint($form["id"]) ?>" title="<?php echo esc_html($form["title"]) ?> : <?php _e("View All Entries", "wpnuke") ?>"><?php echo esc_html($form["title"]) ?></a>
	</td>
	<td class="column-date" style="padding:8px 18px; text-align:center;"><a style="<?php echo $form["unread_count"] > 0 ? "font-weight:bold;" : "" ?>" href="admin.php?page=wpnuke_entries&view=entries&filter=unread&id=<?php echo absint($form["id"]) ?>" title="<?php printf(__("Last Entry: %s", "wpnuke"), $date_display); ?>"><?php echo absint($form["unread_count"]) ?></a></td>
	<td class="column-date" style="padding:8px 18px; text-align:center;"><a href="admin.php?page=wpnuke_entries&view=entries&id=<?php echo absint($form["id"]) ?>" title="<?php _e("View All Entries", "wpnuke") ?>"><?php echo absint($form["total_leads"]) ?></a></td>
	</tr>
	<?php
	}
	}
	?>
	</tbody>
	</table>

	<p class="textright">
	<a class="button" href="admin.php?page=wpnuke_edit_forms"><?php _e("View All Forms", "wpnuke") ?></a>
	</p>
	<?php
	}
	else{
	?>
		<div>
		<?php echo sprintf(__("You don't have any forms. Let's go %s create one %s!", 'wpnuke'), '<a href="admin.php?page=wpnuke_new_form">', '</a>'); ?>
		</div>
	<?php
	}
}
?>