<?php
////////////DASHBOARD CUSTOM WIDGETS START/////
/**
 * Content of Dashboard-Widget
 */
function my_ads_summary()
{
	global $wpdb;
	$blogcat = get_cat_id_from_name(get_option('ptthemes_blogcategory'));
	$blogcatcatids = get_sub_categories($blogcat,'string');
	if($blogcatcatids)
	{
		$srch_blog_pids = $wpdb->get_var("SELECT group_concat(tr.object_id) FROM $wpdb->term_taxonomy tt join $wpdb->term_relationships tr on tr.term_taxonomy_id=tt.term_taxonomy_id where tt.term_id in ($blogcatcatids)");
		if($srch_blog_pids)
		{
			$sub_cat_sql .= " and p.ID not in ($srch_blog_pids) ";
		}
	}
	$srch_sql = "select p.ID,p.post_title,p.post_status,p.post_date,p.guid from $wpdb->posts p $post_meta_join where p.post_status='publish' and p.post_type='post'  $sub_cat_sql order by p.ID desc limit 0 , 10";
	$post_info = $wpdb->get_results($srch_sql);
	if($post_info)
	{
	?>
        <table width="100%">
        <tr>
        <td><strong><?php _e('Property Title');?></strong></td>
        <td><strong><?php _e('Type');?></strong></td>
		<td><strong><?php _e('Display as');?></strong></td>
        <td><strong><?php _e('Date');?></strong></td>
        <td><strong><?php _e('Status');?></strong></td>
        </tr>
        <?php
                foreach($post_info as $post_info_obj)
                {
                    $id = $post_info_obj->ID;
					$post_title = $post_info_obj->post_title;
					$post_status = $post_info_obj->post_status;
					$post_date = $post_info_obj->post_date;
					$type = get_post_meta($id,'property_type',true);
					$list_type = get_post_meta($id,'list_type',true);
        ?>
        <tr>
        <td><a href="<?php echo get_option('siteurl');?>/wp-admin/post.php?action=edit&post=<?php echo $id; ?>" rel="bookmark" title="Permanent Link to "><?php echo $post_title; ?></a></td>
        <td><?php echo $type;?></td>
		<td><?php echo $list_type;?></td>
        <td><?php echo date('d/m/Y',strtotime($post_date));?></td>
        <td><?php echo $post_status;?></td>
        </tr>
				<?php } ?>
        </table>
	<?php
	}else
	{
	?>
   	 <table width="100%">
        <tr>
        <td><?php _e('No Property Available.');?></strong></td>
       </tr>
       </table>
    <?php
	}
}
/**
 * add Dashboard Widget via function wp_add_dashboard_widget()
 */
function my_wp_dashboard_setup() 
{
	wp_add_dashboard_widget( 'my_ads_summary', __( 'Latest Properties' ), 'my_ads_summary' );
}
 
/**
 * use hook, to integrate new widget
 */
add_action('wp_dashboard_setup', 'my_wp_dashboard_setup');
?>