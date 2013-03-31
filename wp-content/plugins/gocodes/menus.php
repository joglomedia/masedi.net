<?php

//***** Manage Menu *****
function wsc_gocodes_managemenu() {
echo '<div class="wrap">';

if ($_GET['editgc'] == "") {

//Add Redirect
if ($_GET['savegc'] == "yes") {
$gckey = $_POST['Key'];
$gctarget = $_POST['Target'];
$gckey = ereg_replace("[^a-zA-Z0-9._-]", "", $gckey );
$gcdocount = $_POST['DoCount'];
if ($gcdocount == "on") { $gcdocount=1; } else { $gcdocount=0; }
if ($gckey!="" && $gctarget!="" && $gctarget!="http://") {
global $wpdb, $table_prefix;
$table_name = $wpdb->prefix . "wsc_gocodes";
$insert = "INSERT INTO " . $table_name . " (target, key1, docount) " . "VALUES ('" . $wpdb->escape($gctarget) . "','" . $wpdb->escape($gckey) . "','". $wpdb->escape($gcdocount) . "')";
$results = $wpdb->query( $insert );
echo '<div id="message" class="updated fade"><p>Redirect added successfully.</p></div>';
} else { echo '<div id="message" class="updated fade"><p>Could not add redirect. You did not properly fill-out both fields!</p></div>'; }
}

//Delete Redirect
if ($_GET['deletegc'] != "") {
$gcid = $_GET['deletegc'];
echo '<div id="message" class="updated fade"><p>Are you sure you want to delete the redirect? <a href="'.GOCODES_URL.'&deletegcconf=yes&gcid='.$gcid.'">Yes</a> &nbsp; <a href="'.GOCODES_URL.'">No!</a></p></div>';
}
if ($_GET['deletegcconf'] != "") {
$gcid = $_GET['gcid'];
global $wpdb, $table_prefix;
$table_name = $wpdb->prefix . "wsc_gocodes";
$wpdb->query("DELETE FROM $table_name WHERE id = '$gcid'");
echo '<div id="message" class="updated fade"><p>Redirect removed successfully.</p></div>';
}

//Uninstall plugin
if ($_GET['uninstallgc'] == "yes") {
echo '<div id="message" class="updated fade"><p><strong>Are you sure you want to delete the GoCodes database entries? You will lose all of your redireccts!</strong><br/><a href="'.GOCODES_URL.'&uninstallgc=yes&confirm=yes">Yes, delete.</a> &nbsp; <a href="index.php">NO!</a></p></div>';
if ($_GET['uninstallgc'] == "yes" && $_GET['confirm'] == "yes") {
global $wpdb, $table_prefix;
$table_name = $wpdb->prefix . "wsc_gocodes";
$uninstallgc = "DROP TABLE ".$table_name;
$results = $wpdb->query( $uninstallgc );
echo '<div id="message" class="updated fade"><p>GoCodes has removed its database entries. Now deactivate the plugin.</p></div>';
return;
}
}

//Update Redirect
if ($_GET['editgcconf'] == "yes") {
$gcpostid = $_POST['id'];
$gcpostkey = $_POST['Key'];
$gcposttarget = $_POST['Target'];
$gcpostdocount = $_POST['DoCount'];
$gcpostkey = ereg_replace("[^a-zA-Z0-9._-]", "", $gcpostkey);
if ($gcpostdocount == "on") { $gcpostdocount=1; } else { $gcpostdocount=0; }
if ($gcpostkey!="" && $gcposttarget!="" && $gcposttarget!="http://") {
global $wpdb, $table_prefix;
$table_name = $wpdb->prefix . "wsc_gocodes";
$insert = "UPDATE $table_name SET target='".$wpdb->escape($gcposttarget)."', key1='".$wpdb->escape($gcpostkey)."', docount='".$wpdb->escape($gcpostdocount)."' WHERE id=$gcpostid";
$results = $wpdb->query( $insert );
echo '<div id="message" class="updated fade"><p>Redirect saved successfully.</p></div>';
}
else { echo '<div id="message" class="updated fade"><p>Could not update redirect. You did not properly fill-out a field!</p></div>'; }
}

//Reset Redirect Counter
if ($_GET['gcresetcount'] == "yes") {
$gcid = $_GET['gcid'];
echo '<div id="message" class="updated fade"><p>Are you sure you want to reset the hit count for the redirect? <a href="'.GOCODES_URL.'&gcresetcountconf=yes&gcid='.$gcid.'">Yes</a> &nbsp; <a href="'.GOCODES_URL.'">No!</a></p></div>';
}
if ($_GET['gcresetcountconf'] == "yes") {
$gcid = $_GET['gcid'];
global $wpdb, $table_prefix;
$table_name = $wpdb->prefix . "wsc_gocodes";
$insert = "UPDATE $table_name SET hitcount=0 WHERE id=$gcid";
$results = $wpdb->query( $insert );
}


//Form
echo "<h2>Add GoCode</h2>";
echo '<div>';
echo '<form method="post" action="'.GOCODES_URL.'&savegc=yes">';
echo '<table class="form-table">';
echo '<tr class="form-field form-required">';
echo '<th scope="row" valign="top"><label for="Key">Redirection Key</label></th>';
echo '<td><input type="text" name="Key" value="" />';
echo ' <br />The text after /go/ that triggers the redirect (e.g. yourblog.com/go/thekey/).</td>';
echo '</tr>';
echo '<tr class="form-field form-required">';
echo '<th scope="row" valign="top"><label for="Target">Target URL</label></th>';
echo '<td><input type="text" name="Target" value="http://" />';
echo ' <br />The URL you wish to redirect to. "http://" is required.</td>';
echo '</tr>';
echo '<tr class="form-field form-required">';
echo '<th scope="row" valign="top"><label for="DoCount">Count hits?</label></th>';
echo ' <td><input type="checkbox" name="DoCount" /> Yes, track the number of times this redirect is used.</td>';
echo '</tr>';
echo '</table>';
echo ' <p class="submit"><input type="submit" name="Submit" class="button" value="Add Redirect" /></p>';
echo '</form>';
echo '<br/>';
echo '</div>';

//List
echo "<h2>Manage GoCodes</h2><br />";
echo '<div class="subsubsub" style="margin-top:-10px;"><strong>Sort by:</strong> <a href="'.GOCODES_URL.'">Date Added</a> | <a href="'.GOCODES_URL.'&sortby=key">Key</a> | <a href="'.GOCODES_URL.'&sortby=hits">Hits</a></div>';
echo '<div>';
echo '<table class="widefat">';
echo '<thead>';
echo '<tr>';
echo '<th scope="col"><div style="text-align: center">Key</div></th>';
echo '<th scope="col"><div style="text-align: center">Target</div></th>';
echo '<th scope="col"><div style="text-align: center">Hits</div></th>';
echo '<th scope="col"></th>';
echo '<th scope="col"></th>';
echo '</tr>';
echo '</thead>';
echo '<tbody id="the-list">';

global $wpdb, $table_prefix;
$table_name = $wpdb->prefix . "wsc_gocodes";
$trigger = get_option("wsc_gocodes_url_trigger");
if ($trigger=='') { $trigger == 'go'; }
$sortby = $_GET['sortby'];
if ($sortby == 'key') {
	$sort = 'key1 ASC';
} else if ($sortby == 'hits') {
	$sort = 'hitcount DESC';
} else {
	$sort = 'id DESC';
}
$gocodes = $wpdb->get_results("SELECT id, target, key1, docount, hitcount FROM $table_name WHERE key1 != '' ORDER BY $sort", OBJECT);
$basewpurl = get_option('siteurl');
if ($gocodes):
foreach ($gocodes as $gocode):
if($gocode->docount != 1) { $gocode->hitcount = ""; }
echo '<tr class="alternate"> <td><strong>'.$gocode->key1.'</strong><br /><small>'.$basewpurl.'/'.$trigger.'/'.$gocode->key1.'/</small></td> <td>'.wsc_gocodes_truncate($gocode->target).'</td> <td style="text-align: center">'.$gocode->hitcount.'</td> <td><a href="'.GOCODES_URL.'&editgc='.$gocode->id.'">Edit</a></td> <td><a href="'.GOCODES_URL.'&deletegc='.$gocode->id.'" class="delete">Delete</a></td> </tr>';
endforeach; 
else : 
echo "<tr><td colspan='3'>Not Found</td></tr>";
endif;

echo '</tbody>';
echo '</table>';
echo '</div>';

}

if ($_GET['editgc'] != "") {
$gcid = $_GET['editgc'];
global $wpdb, $table_prefix;
$table_name = $wpdb->prefix . "wsc_gocodes";
$editquery = "SELECT id, target, key1, docount, hitcount FROM $table_name WHERE id=$gcid";
$gocode = $wpdb->get_row($editquery, OBJECT);
echo '<div class="wrap">';
echo "<h2>Edit GoCode</h2>";
echo '<div>';
echo '<form method="post" action="'.GOCODES_URL.'&editgcconf=yes">';
echo '<table class="form-table">';
echo '<table class="form-table">';
echo '<tr class="form-field form-required">';
echo '<th scope="row" valign="top"><label for="Key">Redirection Key</label></th>';
echo '<td><input type="text" name="Key" value="'.$gocode->key1.'" />';
echo '<br />The text after /go/ that triggers the redirect (e.g. yourblog.com/go/thekey/).</td>';
echo '</tr>';
echo '<tr class="form-field form-required">';
echo '<th scope="row" valign="top"><label for="Target">Target URL</label></th>';
echo '<td><input type="text" name="Target" value="'.$gocode->target.'" />';
echo '<br />The URL you wish to redirect to. "http://" is required.</td>';
echo '</tr>';
echo '<tr class="form-field form-required">';
echo '<th scope="row" valign="top"><label for="DoCount">Count hits?</label></th>';
echo ' <td><input type="checkbox" name="DoCount"'; if($gocode->docount==1) { echo 'checked="checked"'; } echo '/> Yes, track the number of times this redirect is used. &nbsp;&nbsp; <a href="'.GOCODES_URL.'&gcresetcount=yes&gcid='.$gcid.'">Reset count</a></td>';
echo '</tr>';
echo '</table>';
echo ' <input type="hidden" name="id" value="'.$gcid.'" />';
echo ' <p class="submit"><input type="submit" name="Submit" class="button" value="Edit Redirect" /></p>';
echo '</form>';
echo '</div>';
echo '</div>';
}


wsc_gocodes_footer();
echo '</div>';
}



//***** Options Menu *****
function wsc_gocodes_optionsmenu() {
	echo '<div class="wrap">';
	if (function_exists('screen_icon')) { screen_icon(); }
	echo "<h2>GoCodes Settings</h2>";

	if ($_POST['issubmitted']=='yes') {
		$post_urltrigger = $_POST['urltrigger'];
		$post_nofollow = $_POST['nofollow'];
		if ($post_nofollow=='on') { $post_nofollow = 'yes'; } else { $post_nofollow = ''; }
		update_option("wsc_gocodes_url_trigger", $post_urltrigger);
		update_option("wsc_gocodes_nofollow", $post_nofollow);
	}
	$setting_url_trigger = get_option("wsc_gocodes_url_trigger");
	$setting_nofollow = get_option("wsc_gocodes_nofollow");
	if ($setting_url_trigger=='') { $setting_url_trigger == 'go'; }

	echo '<form method="post" action="http://'.$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"].'">';
	echo '<table class="form-table">';
	?>

	<tr valign="top">
	<th scope="row">URL Trigger</th>
	<td><input name="urltrigger" type="text" id="urltrigger" value="<?php echo $setting_url_trigger; ?>" size="50" /><br/>Change the <em>/go/</em> part of your redirects to something else. Enter without slashes.</td>
	</tr>

	<tr valign="top">
	<th scope="row">Nofollow</th>
	<td><input type="checkbox" name="nofollow" <?php if ($setting_nofollow!='') { echo 'checked="checked"'; } ?> /> Nofollow GoCodes <br/>Adds a <em>nofollow</em> into the redirection sequence.</td>
	</tr>

	<?php
	echo '</table>';
	echo '<input name="issubmitted" type="hidden" value="yes" />';
	echo '<p class="submit"><input type="submit" name="Submit" value="Save settings" /></p>';
	echo '</form>';
	wsc_gocodes_footer();
	echo '</div>';
}



//***** Common Elements *****
function wsc_gocodes_admin_script() {
	if (function_exists('wp_enqueue_style')) { wp_enqueue_script('thickbox'); }
}
function wsc_gocodes_admin_style() {
	if (function_exists('wp_enqueue_style')) { wp_enqueue_style('thickbox'); }
}

add_action('init', 'wsc_gocodes_admin_script');
add_action('wp_head', 'wsc_gocodes_admin_style');

function wsc_gocodes_footer() {
	echo '<div style="margin-top:45px; font-size:0.87em;">';
	echo '<div style="float:right;"><a href="http://www.webmaster-source.com/static/donate_plugin.php?plugin=gocodes&amp;KeepThis=true&amp;TB_iframe=true&amp;height=250&amp;width=550" class="thickbox" title="Donate"><img src="http://www.paypal.com/en_US/i/btn/btn_donate_SM.gif" alt="Donate" /></a></div>';
	echo '<div><a href="'.wsc_gocodes_get_plugin_dir('url').'/readme.txt?KeepThis=true&amp;TB_iframe=true&amp;height=450&amp;width=680" class="thickbox" title="Documentation">Documentation</a> | <a href="http://www.webmaster-source.com/gocodes-redirection-plugin-wordpress/">GoCodes Homepage</a></div>';
	echo '</div>';
}

?>