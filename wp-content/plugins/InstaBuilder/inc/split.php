<?php if ( !defined('ABSPATH') ) die('No direct access');
$submit_label = ( isset($_GET['id']) ) ? 'Update' : 'Create';
$title = ( isset($_GET['id']) ) ? 'Edit Split Test' : 'Create Split Test';
if ( isset($_GET['id']) ) {
	$link_id = (int) $_GET['id'];
	$link = opl_get_split( $link_id );
	$data = maybe_unserialize(opl_isset($link->data));
	$splits = opl_get_split_urls($link_id);
}
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
	
	<?php if ( opl_isset($_GET['added']) == 'true' ) echo '<div class="updated fade"><p><strong>Split Test Campaign Successfully Added.</strong></p></div>'; ?>
	<?php if ( opl_isset($_GET['updated']) == 'true' ) echo '<div class="updated fade"><p><strong>Split Test Campaign Updated.</strong></p></div>'; ?>

	<div style="width:99%">
	<h2 class="nav-tab-wrapper">
		<?php if ( isset($_GET['id']) ) { ?><a href="#" class="nav-tab nav-tab-active bwst-atab" rel="link-report">Report</a><?php } ?><a href="#" class="nav-tab <?php if ( !isset($_GET['id']) ) : ?>nav-tab-active <?php endif;?>bwst-atab" rel="link-form"><?php echo $title; ?></a>
	</h2>

	<form method="post" name="opl-split-form" id="opl-split-form">
	<div id="link-form" <?php if ( isset($_GET['id']) ) echo 'style="display:none"'; ?>>
		
	<table class="form-table">
	<?php if ( isset($_GET['id']) ) : ?>
	<tr valign="top">
		<th scope="row"><label>Split Test URL</label></th>
		<td><input type="text" value="<?php echo trailingslashit(get_option('home')); ?><?php echo opl_isset($link->slug); ?>" class="regular-text" readonly /> <a href="<?php echo trailingslashit(get_option('home')); ?><?php echo opl_isset($link->slug); ?>" target="_blank"><img src="<?php echo OPL_URL; ?>/images/visit_icon.png" border="0" /></a></td>
	</tr>
	<?php endif; ?>
	<tr valign="top">
		<th scope="row"><label for="link_name">Split Test Name</label></th>
		<td><input name="link_name" type="text" id="link_name" value="<?php echo stripslashes(opl_isset($link->name)); ?>" class="validate[required] regular-text" /></td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="link_slug">Slug</label></th>
		<td><span class="example"><code><?php echo trailingslashit(get_option('home')); ?></code></span> <input name="link_slug" type="text" id="link_slug" value="<?php if ( !isset($link->slug) ) echo opl_generate_slug(); else echo opl_isset($link->slug); ?>" class="validate[required] regular-text" style="width:160px" /> (e.g. <code>myslug</code> or <code>go/myslug</code>)
		<p><span class="description">The "slug" can be anything. It is usually all lowercase and contains<br />only letters, numbers, forward slash, and hyphens (no spaces).</span></p></td>
	</tr>
	<tr valign="top" id="dest_urls_field">
		<th scope="row"><label for="dest_urls">Choose Page(s)</label></th>
		<td>
		<div id="urls-holder">
			<?php
			if ( isset($splits) && count($splits) > 0 ) {
				$i = 0;
				foreach ( $splits as $split ) {
					$i++;
					$split_field = opl_split_pages($split->post_id);
					$remove_btn = ( $i > 2 ) ? '<img src="' . OPL_URL . 'images/delete.png" border="0" style="cursor:pointer; vertical-align:middle;" alt="remove" title="Remove" class="js-url-field" />&nbsp;<img src="' . OPL_URL . 'images/ajax-loader.gif" border="0" class="remove-url-loader" style="display:none; vertical-align:middle;" />' : '';
					echo '<div class="split-url">Page: ' . $split_field . '&nbsp;Weight: <input name="dest_urls_weight[]" type="text" id="dest_urls_weight" value="' . $split->weight . '" class="regular-text dest-weight" style="width:45px" /><input type="hidden" name="dest_urls_id[]" id="dest_urls_id" value="' . $split->ID . '" /> ' . $remove_btn . '</div>';
				}
			} else {
			?>
				<div class="split-url">Page: <?php echo opl_split_pages(); ?>&nbsp;Weight: <input name="dest_urls_weight[]" type="text" id="dest_urls_weight" value="1" class="regular-text dest-weight" style="width:45px" /><input type="hidden" name="dest_urls_id[]" id="dest_urls_id" value="0" /></div>
				<div class="split-url">Page: <?php echo opl_split_pages(); ?>&nbsp;Weight: <input name="dest_urls_weight[]" type="text" id="dest_urls_weight" value="1" class="regular-text dest-weight" style="width:45px" /><input type="hidden" name="dest_urls_id[]" id="dest_urls_id" value="0" /></div>
			<?php } ?>
		</div>
		<p style="margin-top:15px"><a href="#" class="add_new_url button">Add more page</a></p>
		<p><span class="description">The traffic will be directed in a circular pattern to each page, with a larger<br />proportion of requests being serviced by the page with a greater weight.</span></p>
		</td>
	</tr>
	<tr valign="top" id="redirect_type">
		<th scope="row"><label for="redir_type">Redirect Type</label></th>
		<td>
		<select name="redir_type" id="redir_type" style="width:150px">
			<option value="301" <?php if ( opl_isset($link->redir_type) == '301' ) echo 'selected="selected"'; ?>>301 Redirect</option>
			<option value="302" <?php if ( opl_isset($link->redir_type) == '302' || opl_isset($link->redir_type) == '' ) echo 'selected="selected"'; ?>>302 Redirect</option>
		</select></td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="main_tracker">Conversion Tracking</label></th>
		<td>
		<select name="c_page" id="c_page" style="width:280px">
			<option value="">[ -- Select Thank You Page -- ]</option>
			<?php
			$c_pages = get_pages();
			if ( $c_pages ) :
				foreach( $c_pages as $page ) {
					$selected = ( opl_isset($link->conversion_id) == $page->ID ) ? ' selected="selected"' : '';
					echo '<option value="' . $page->ID . '"' . $selected . '>' . $page->post_title . '</option>';
				}
			endif;
			?>
		</select>
		<p><span class="description">Please choose your thank you page if you want to track the conversion rate.</span></p>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="conversion_value">Conversion Value</label></th>
		<td><input name="conversion_value" type="text" id="conversion_value" value="<?php if ( isset($data['conversion_value']) ) echo $data['conversion_value']; else echo '0.00'; ?>" class="regular-text" style="width:120px" />
		<span class="description">How much you earn per sale/action.</span></td>
	</tr>
	</table>
	
	<p class="submit">
		<input type="submit" name="submit" id="submit" class="button-primary" value="<?php echo $submit_label; ?>" />
		<input type="hidden" name="_opl_nonce" value="<?php echo wp_create_nonce( 'opl-nonce' ); ?>" />
		<?php if ( isset($_GET['id']) ) echo '<input type="hidden" name="link_id" id="link_id" value="' . $_GET['id'] . '" />'; ?>
		<input type="hidden" name="action" value="opl_save_split" />
	</p>
	
	</div><!-- split-form -->
	<script>
	jQuery(document).ready(function(){
		jQuery("#opl-split-form").validationEngine();
	});
	</script>
	</form>
	
	<div id="link-report" <?php if ( !isset($_GET['id']) ) echo 'style="display:none"'; ?> >
		<?php if ( isset($_GET['id']) ) : ?>
		<table class="form-table">
		<tr valign="top">
			<th scope="row"><label>Split Test URL</label></th>
			<td><input type="text" value="<?php echo trailingslashit(get_option('home')); ?><?php echo opl_isset($link->slug); ?>" class="regular-text" readonly /> <a href="<?php echo trailingslashit(get_option('home')); ?><?php echo opl_isset($link->slug); ?>" target="_blank"><img src="<?php echo OPL_URL; ?>/images/visit_icon.png" border="0" /></a></td>
		</tr>
		</table>
		<?php endif; ?>
		
		<div style="margin-bottom:15px"></div>
		<h3>Today Stats</h3>
		<table cellspacing="0" class="widefat page fixed">
		<thead>
			<tr>
			<th class="manage-column column-comments" scope="col" style="text-align:center">No.</th>
			<th class="manage-column column-title sortable desc" scope="col"><p style="margin:0; padding:6px 0"><span>URL</span></p></th>
			<th class="manage-column column-date sortable desc" scope="col"><p style="margin:0; padding:6px 0"><span>Raw</span></p></th>
			<th class="manage-column column-date sortable desc" scope="col"><p style="margin:0; padding:6px 0"><span>Unique</span></p></th>
			<th class="manage-column column-date sortable desc" scope="col"><p style="margin:0; padding:6px 0"><span>Conv.</span></p></th>
			<th class="manage-column column-date sortable desc" scope="col"><p style="margin:0; padding:6px 0"><span>Conv. Rate</span></p></th>
			<th class="manage-column column-date sortable desc" scope="col"><p style="margin:0; padding:6px 0"><span>Revenue</span></p></th>
			</tr>
		</thead>
		<tbody>
		<?php if ( isset($splits) && count($splits) > 0 ) { 
			$j = 0;
			foreach ( $splits as $split ) :
				$rsplit_id = (int) $split->ID;
				$rpost_id = $split->post_id;
				$rsplit_url = get_permalink($rpost_id);
				$alternate = ($j%2) ? 'alternate ' : '';
				$j++;
				
				$click = opl_stat_clicks($_GET['id'], $rsplit_id, 'today');
				$conversions = opl_stat_conversions($_GET['id'], $rsplit_id, 'today');
				$cr = number_format(@(($conversions / $click['unique']) * 100), 2);
				$revenue = @number_format( opl_stat_revenue($_GET['id'], $rsplit_id, 'today'), 2 );
		?>
		
			<tr class="<?php echo $alternate; ?>iedit">
				<td scope="row" class="comments column-comments" style="text-align:center"><?php echo $j; ?>.</td>
				<td class="post-title page-title column-title"><?php echo $rsplit_url; ?></td>
				<td class="date column-date"><?php echo $click['raw']; ?></td>
				<td class="date column-date"><?php echo $click['unique']; ?></td>
				<td class="date column-date"><strong><?php echo $conversions; ?></strong></td>
				<td class="date column-date"><strong><?php echo $cr; ?>%</strong></td>
				<td class="date column-date"><strong><?php echo $revenue; ?></strong></td>
			</tr>
		
			<?php endforeach;
		} ?>
		</tbody>
		</table>
		
		<h3>Last 7 Days Stats</h3>
		<table cellspacing="0" class="widefat page fixed">
		<thead>
			<tr>
			<th class="manage-column column-comments" scope="col" style="text-align:center">No.</th>
			<th class="manage-column column-title sortable desc" scope="col"><p style="margin:0; padding:6px 0"><span>URL</span></p></th>
			<th class="manage-column column-date sortable desc" scope="col"><p style="margin:0; padding:6px 0"><span>Raw</span></p></th>
			<th class="manage-column column-date sortable desc" scope="col"><p style="margin:0; padding:6px 0"><span>Unique</span></p></th>
			<th class="manage-column column-date sortable desc" scope="col"><p style="margin:0; padding:6px 0"><span>Conv.</span></p></th>
			<th class="manage-column column-date sortable desc" scope="col"><p style="margin:0; padding:6px 0"><span>Conv. Rate</span></p></th>
			<th class="manage-column column-date sortable desc" scope="col"><p style="margin:0; padding:6px 0"><span>Revenue</span></p></th>
			</tr>
		</thead>
		<tbody>
		<?php if ( isset($splits) && count($splits) > 0 ) { 
			$j = 0;
			foreach ( $splits as $split ) :
				$rsplit_id = (int) $split->ID;
				$rpost_id = $split->post_id;
				$rsplit_url = get_permalink($rpost_id);
				$alternate = ($j%2) ? 'alternate ' : '';
				$j++;
				
				$click = opl_stat_clicks($_GET['id'], $rsplit_id, 'seven');
				$conversions = opl_stat_conversions($_GET['id'], $rsplit_id, 'seven');
				$cr = number_format(@(($conversions / $click['unique']) * 100), 2);
				$revenue = @number_format( opl_stat_revenue($_GET['id'], $rsplit_id, 'seven'), 2 );
		?>
		
			<tr class="<?php echo $alternate; ?>iedit">
				<td scope="row" class="comments column-comments" style="text-align:center"><?php echo $j; ?>.</td>
				<td class="post-title page-title column-title"><?php echo $rsplit_url; ?></td>
				<td class="date column-date"><?php echo $click['raw']; ?></td>
				<td class="date column-date"><?php echo $click['unique']; ?></td>
				<td class="date column-date"><strong><?php echo $conversions; ?></strong></td>
				<td class="date column-date"><strong><?php echo $cr; ?>%</strong></td>
				<td class="date column-date"><strong><?php echo $revenue; ?></strong></td>
			</tr>
		
			<?php endforeach;
		} ?>
		</tbody>
		</table>
		
		<h3>Last 30 Days Stats</h3>
		<table cellspacing="0" class="widefat page fixed">
		<thead>
			<tr>
			<th class="manage-column column-comments" scope="col" style="text-align:center">No.</th>
			<th class="manage-column column-title sortable desc" scope="col"><p style="margin:0; padding:6px 0"><span>URL</span></p></th>
			<th class="manage-column column-date sortable desc" scope="col"><p style="margin:0; padding:6px 0"><span>Raw</span></p></th>
			<th class="manage-column column-date sortable desc" scope="col"><p style="margin:0; padding:6px 0"><span>Unique</span></p></th>
			<th class="manage-column column-date sortable desc" scope="col"><p style="margin:0; padding:6px 0"><span>Conv.</span></p></th>
			<th class="manage-column column-date sortable desc" scope="col"><p style="margin:0; padding:6px 0"><span>Conv. Rate</span></p></th>
			<th class="manage-column column-date sortable desc" scope="col"><p style="margin:0; padding:6px 0"><span>Revenue</span></p></th>
			</tr>
		</thead>
		<tbody>
		<?php if ( isset($splits) && count($splits) > 0 ) { 
			$j = 0;
			foreach ( $splits as $split ) :
				$rsplit_id = (int) $split->ID;
				$rpost_id = $split->post_id;
				$rsplit_url = get_permalink($rpost_id);
				$alternate = ($j%2) ? 'alternate ' : '';
				$j++;
				
				$click = opl_stat_clicks($_GET['id'], $rsplit_id, 'thirty');
				$conversions = opl_stat_conversions($_GET['id'], $rsplit_id, 'thirty');
				$cr = number_format(@(($conversions / $click['unique']) * 100), 2);
				$revenue = @number_format( opl_stat_revenue($_GET['id'], $rsplit_id, 'thirty'), 2 );
		?>
		
			<tr class="<?php echo $alternate; ?>iedit">
				<td scope="row" class="comments column-comments" style="text-align:center"><?php echo $j; ?>.</td>
				<td class="post-title page-title column-title"><?php echo $rsplit_url; ?></td>
				<td class="date column-date"><?php echo $click['raw']; ?></td>
				<td class="date column-date"><?php echo $click['unique']; ?></td>
				<td class="date column-date"><strong><?php echo $conversions; ?></strong></td>
				<td class="date column-date"><strong><?php echo $cr; ?>%</strong></td>
				<td class="date column-date"><strong><?php echo $revenue; ?></strong></td>
			</tr>
		
			<?php endforeach;
		} ?>
		</tbody>
		</table>
		
		<h3>All Time Stats</h3>
		<table cellspacing="0" class="widefat page fixed">
		<thead>
			<tr>
			<th class="manage-column column-comments" scope="col" style="text-align:center">No.</th>
			<th class="manage-column column-title sortable desc" scope="col"><p style="margin:0; padding:6px 0"><span>URL</span></p></th>
			<th class="manage-column column-date sortable desc" scope="col"><p style="margin:0; padding:6px 0"><span>Raw</span></p></th>
			<th class="manage-column column-date sortable desc" scope="col"><p style="margin:0; padding:6px 0"><span>Unique</span></p></th>
			<th class="manage-column column-date sortable desc" scope="col"><p style="margin:0; padding:6px 0"><span>Conv.</span></p></th>
			<th class="manage-column column-date sortable desc" scope="col"><p style="margin:0; padding:6px 0"><span>Conv. Rate</span></p></th>
			<th class="manage-column column-date sortable desc" scope="col"><p style="margin:0; padding:6px 0"><span>Revenue</span></p></th>
			</tr>
		</thead>
		<tbody>
		<?php if ( isset($splits) && count($splits) > 0 ) { 
			$j = 0;
			foreach ( $splits as $split ) :
				$rsplit_id = (int) $split->ID;
				$rpost_id = $split->post_id;
				$rsplit_url = get_permalink($rpost_id);
				$alternate = ($j%2) ? 'alternate ' : '';
				$j++;
				
				$click = opl_stat_clicks($_GET['id'], $rsplit_id);
				$conversions = opl_stat_conversions($_GET['id'], $rsplit_id);
				$cr = number_format(@(($conversions / $click['unique']) * 100), 2);
				$revenue = @number_format( opl_stat_revenue($_GET['id'], $rsplit_id), 2 );
		?>
		
			<tr class="<?php echo $alternate; ?>iedit">
				<td scope="row" class="comments column-comments" style="text-align:center"><?php echo $j; ?>.</td>
				<td class="post-title page-title column-title"><?php echo $rsplit_url; ?></td>
				<td class="date column-date"><?php echo $click['raw']; ?></td>
				<td class="date column-date"><?php echo $click['unique']; ?></td>
				<td class="date column-date"><strong><?php echo $conversions; ?></strong></td>
				<td class="date column-date"><strong><?php echo $cr; ?>%</strong></td>
				<td class="date column-date"><strong><?php echo $revenue; ?></strong></td>
			</tr>
		
			<?php endforeach;
		} ?>
		</tbody>
		</table>
	</div><!-- link-report -->
	</div>
</div><!-- wrap -->