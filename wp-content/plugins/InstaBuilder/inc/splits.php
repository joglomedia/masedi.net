<?php if ( !defined('ABSPATH') ) die('No direct access');
global $wpdb;

$totalcount = $wpdb->get_var("SELECT COUNT(*) FROM `{$wpdb->prefix}opl_links`");
$offset = ( isset($_GET['paged']) ) ? $_GET['paged'] - 1 : 0;
if( $offset < 0 ) $offset = 0;
$perpage = 20;  
$offset = $offset * $perpage;

$links = $wpdb->get_results("SELECT * FROM `{$wpdb->prefix}opl_links` ORDER BY ID DESC LIMIT $offset, $perpage");

$pagination = array(
			'base' => add_query_arg('paged', '%#%'),
			'format' => '',
			'total' => ceil($totalcount / $perpage),
			'current' => $offset / $perpage + 1
		);
?>
<div class="wrap">
	<div id="optinlite-admin-header">InstaBuilder</div>
	<div id="optinline-links-holder">
		<ul id="optinlite_links">
			<li><a href="http://instabuilder.com/faq" target="_blank">F.A.Q</a></li>
			<li><a href="http://instabuilder.com/trainingvideos" target="_blank">Training Videos</a></li>
			<li><a href="http://asksuzannatheresia.com" target="_blank">Support</a></li>
			<li><a href="http://instabuilder.com/affiliates" target="_blank">Make Money Now!</a></li>
		</ul>
		<div style="clear:left"></div>
	</div>
	
	<div style="width:99%">
	<h2>Manage Split Tests <a href="<?php echo admin_url('admin.php?page=opl-splits&mode=add-split-test'); ?>" class="button add-new-h2">Add New</a></h2>
	<form id="manage-links" name="manage-links" method="post">
	<input type="hidden" name="action" value="opl_bulk_actions" />
    <input type="hidden" name="bulk" value="splits" />
    <input type="hidden" name="_opl_nonce" value="<?php echo wp_create_nonce( 'opl-nonce' ); ?>" />
	<div style="margin:5px 0; float:left;">
		<select name="opl_action" id="opl_action" style="width:120px">
			<option value="" selected="selected">Bulk Actions</option>
			<option value="delete">Delete</option>
		</select>
		<input type="submit" name="opl-splits-submit" class="button-secondary" value="Apply"  />
	</div>
	<div style="margin:5px 0; float:right;"><?php echo paginate_links( $pagination ); ?></div>
	<div style="clear:both"></div>

	<table cellspacing="0" class="widefat page fixed">
		<thead>
		<tr>
			<th class="manage-column column-cb check-column" id="cb" scope="col"><input type="checkbox"></th>
			<th class="manage-column column-title sortable desc" scope="col"><span>Link Name</span></th>
			<th class="manage-column column-title sortable desc" scope="col"><span>Split Test URL</span></th>
			<th class="manage-column column-date sortable desc" scope="col" style="text-align:center"><span>Unique Clicks</span></th>
			<th class="manage-column column-date sortable desc" scope="col" style="text-align:center"><span>Conversions</span></th>
			<th class="manage-column column-date sortable desc" scope="col" style="text-align:center"><span>Conv. Rate</span></th>
		</tr>
		</thead>

		<tfoot>
		<tr>
			<th class="manage-column column-cb check-column" id="cb" scope="col"><input type="checkbox"></th>
			<th class="manage-column column-title sortable desc" scope="col"><span>Link Name</span></th>
			<th class="manage-column column-title sortable desc" scope="col"><span>Split Test URL</span></th>
			<th class="manage-column column-date sortable desc" scope="col" style="text-align:center"><span>Unique Clicks</span></th>
			<th class="manage-column column-date sortable desc" scope="col" style="text-align:center"><span>Conversions</span></th>
			<th class="manage-column column-date sortable desc" scope="col" style="text-align:center"><span>Conv. Rate</span></th>
		</tr>
		</tfoot>
		<tbody>
		<?php
		if ( count($links) > 0 ) {
			$i = 0;
			foreach ( $links as $link ) {
				$alternate = ($i%2) ? 'alternate ' : '';
				echo '<tr class="' . $alternate . 'iedit">';
				
				$click = opl_stat_clicks($link->ID);
				$conversions = opl_stat_conversions($link->ID);
				$cr = number_format(@(($conversions / $click['unique']) * 100), 2);
				?>
				<th scope="row" class="check-column"><input type="checkbox" name="opl_id[]" value="<?php echo $link->ID; ?>"></th>
				<td class="post-title page-title column-title">
					<a class="row-title" href="<?php echo admin_url('admin.php?page=opl-splits&mode=edit-split-test&id=' . $link->ID); ?>"><strong><?php echo $link->name; ?></strong></a>
					<div class="row-actions"><span class='edit'><a href="<?php echo admin_url('admin.php?page=opl-splits&mode=edit-split-test&id=' . $link->ID); ?>" title="view details">View Details</a> | </span><span class='trash'><a class='submitdelete' title='Delete this link' href='<?php echo admin_url('admin.php?page=opl-splits&id=' . $link->ID . '&action=opl-delete-split'); ?>&_opl_nonce=<?php echo wp_create_nonce( 'opl-nonce' ); ?>' onclick='return confirm("Are you sure you want to delete this split test?\nThis action cannot be undone.")'>Delete</a></span></div>
				</td>
				<td class="post-title page-title column-title"><input type="text" value="<?php echo trailingslashit(get_option('home')); ?><?php echo opl_isset($link->slug); ?>" class="regular-text" readonly /> <a href="<?php echo trailingslashit(get_option('home')); ?><?php echo opl_isset($link->slug); ?>" target="_blank"><img src="<?php echo OPL_URL; ?>/images/visit_icon.png" border="0" /></a></td>
				<td style="text-align:center"><?php echo $click['unique']; ?></td>
				<td style="text-align:center"><?php echo $conversions; ?></td>
				<td style="text-align:center"><?php echo $cr; ?>%</td>
				<?php
				echo '</tr>';
				$i++;
			}
		}
		?>
		</tbody>
	</table>
	<div style="margin:5px 0; float:left;">
		<select name="opl_action2" id="opl_action2" style="width:120px">
			<option value="" selected="selected">Bulk Actions</option>
			<option value="delete">Delete</option>
		</select>
		<input type="submit" name="opl-splits-submit2" class="button-secondary" value="Apply"  />
	</div>
	<div style="margin:5px 0; float:right;"><?php echo paginate_links( $pagination ); ?></div>
	<div style="clear:both"></div>
	</form>
	</div>
</div><!-- wrap -->