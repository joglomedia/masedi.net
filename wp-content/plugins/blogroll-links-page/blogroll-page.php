<?php
/*
Plugin Name: Blogroll Page
Plugin URI: http://www.byte-me.org
Description: Outputs your blogroll links as a page or a post. Add the text <code>&lt;!--blogroll-page--&gt;</code> to a page or post and it will output your blogroll links organized by category heading. Don't use this version on WordPress 2.2 or earlier!
Author: Mark Allen
Version: 2.1
*/


/*
Links Page is a Wordpress Plugin that will create a list of blogroll links to a Post or Page on your Wordpress Blog.
Copyright (C) 2007 Dominic Foster
Copyright (C) 2008 Mark R. Allen

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

*/

//To replace the <!--blogroll-page--> with the blogroll links
function bp_text($text) {
	global $wpdb, $table_prefix;

	//Only perform plugin functionality if post/page text has <!--rs sitemap-->
	if (preg_match("|<!--blogroll-page-->|", $text)) {

	    	if (get_option('blogroll_page_new_window') == 'yes')
    		{
		      $target = 'target="_blank"';
		} else {
		      $target = '';
		}

		$displaycat = get_option('blogroll_page_display_cat');
		$linkorder1 = get_option('blogroll_page_link_order1');
		$linkorder2 = get_option('blogroll_page_link_order2');
		$links = '';

		// Get parent categories only
		$sql = "SELECT term_id, term_taxonomy_id FROM " . $table_prefix ."term_taxonomy WHERE taxonomy = 'link_category'";
		$categories = $wpdb->get_results($sql);
		foreach ($categories as $cat) {
			$nsql = "SELECT name FROM ". $table_prefix ."terms WHERE term_id = '".$cat->term_id."'";
			$catname = $wpdb->get_var($nsql);

			if ($displaycat == 'yes') {
				$links .= '<H2>' . $catname . '</H2><UL>';
			} else {
				$links .= '<UL>';
			}
			$lsql = "SELECT l.link_url, l.link_name, l.link_description FROM " . $table_prefix . "links as l, " . $table_prefix . "term_relationships as rel WHERE rel.object_id = l.link_id AND rel.term_taxonomy_id = " . $cat->term_taxonomy_id . " ORDER BY " . $linkorder1 . ", " . $linkorder2;


			$alllinks = $wpdb->get_results($lsql);

			foreach($alllinks as $link) {
				$url = $link->link_url;
				$name = $link->link_name;
				$description = (strlen($link->link_description) > 0) ? '<br>' . $link->link_description : '';

				$links .= '<li><a href=' . $url . ' ' . $target . '>' . $name . '</a>' . $description;
			} 

			$links .= '</UL>'; 
		} // end category loop

		if (get_option('blogroll_page_link') != 'yes')
		{
			$links .= '<a href="http://www.byte-me.org/" ' . $target . '>Blogroll Links Plugin 2.0</a>';
		}

		$text = preg_replace("|<!--blogroll-page-->|", $links, $text);

	}

	return $text;

} //end bp_text()

//admin menu
function blogroll_page_admin() {
	if (function_exists('add_options_page')) {
		add_options_page('blogroll-page', 'Blogroll Page', 1, basename(__FILE__), 'blogroll_page_admin_panel');
  }
}

function blogroll_page_admin_panel() {

	//Add options if first time running
	add_option('blogroll_page_link', 'no', 'Blogroll Page - disable link');
	add_option('blogroll_page_new_window', 'no', 'Blogroll Page - open link in new window');
	add_option('blogroll_page_display_cat', 'yes', 'Blogroll Page - display category header');
	add_option('blogroll_page_link_order1', 'link_id', 'Blogroll Page - link display order 1');
	add_option('blogroll_page_link_order2', 'link_id', 'Blogroll Page - link display order 2');

	if (isset($_POST['info_update'])) {
		//update settings
		if($_POST['disable'] == 'on') { $disable = 'yes'; } else { $disable = 'no'; }
		if($_POST['newwindow'] == 'on') { $new = 'yes'; } else { $new = 'no'; }
		if($_POST['displaycat'] == 'on') { $displaycat = 'yes'; } else { $displaycat = 'no'; }
		$linkorder1 = $_POST['linkorder1'];
		$linkorder2 = $_POST['linkorder2'];

		update_option('blogroll_page_link', $disable);
		update_option('blogroll_page_new_window', $new);
		update_option('blogroll_page_display_cat', $displaycat);
		update_option('blogroll_page_link_order1', $linkorder1);
		update_option('blogroll_page_link_order2', $linkorder2);
	} else {
		//load settings from database
		$disable = get_option('blogroll_page_link');
		$new = get_option('blogroll_page_new_window');
		$displaycat = get_option('blogroll_page_display_cat');
		$linkorder1 = get_option('blogroll_page_link_order1');
		$linkorder2 = get_option('blogroll_page_link_order2');
	}

	?>

	<div class=wrap>
		<form method="post">

			<h2>Blogroll Page Plugin Options</h2>

			<fieldset name="set1">
				<h3>Disable Link to Plugin Page:</h3>

				<p>
            It would be nice to get a link to the Blogroll Plugin Download page. But if you don't want to, I'll understand :(<br /><br />
					<label>
            <input type="checkbox" name="disable" <?php checked('yes', $disable); ?> class="tog"/>
						Don't show link to Plugin Download Page.
					</label>
				</p>

				<h3>Open Link in New Window:</h3>

				<p>
					<label>
            <input type="checkbox" name="newwindow" <?php checked('yes', $new); ?> class="tog"/>
						Open link in new window.
					</label>
				</p>

				<h3>Display Category Title:</h3>

				<p>
					<label>
            <input type="checkbox" name="displaycat" <?php checked('yes', $displaycat); ?> class="tog"/>
						Display category titles within the Blogroll listing.
					</label>
				</p>

				<h3>Set Link Order within Categories</h3>

				<p>
					<label>
			            Primary <select name="linkorder1" class="tog">
						<option value="link_id" <?php if( $linkorder1 ==  'link_id' ){ echo " selected"; } ?>>Link ID</option>
						<option value="link_name" <?php if( $linkorder1 ==  'link_name' ){ echo " selected"; } ?>>Name</option>
						<option value="link_url" <?php if( $linkorder1 ==  'link_url' ){ echo " selected"; } ?>>Address</option>
						<option value="link_rating" <?php if( $linkorder1 ==  'link_rating' ){ echo " selected"; } ?>>Rating</option>
					</select>
					</label>
					<label>
			            Secondary <select name="linkorder2" class="tog">
						<option value="link_id" <?php if( $linkorder2 ==  'link_id' ){ echo " selected"; } ?>>Link ID</option>
						<option value="link_name" <?php if( $linkorder2 ==  'link_name' ){ echo " selected"; } ?>>Name</option>
						<option value="link_url" <?php if( $linkorder2 ==  'link_url' ){ echo " selected"; } ?>>Address</option>
						<option value="link_rating" <?php if( $linkorder2 ==  'link_rating' ){ echo " selected"; } ?>>Rating</option>
					</select>
					</label>
				</p>
			</fieldset>

			<div class="submit">

				<input type="submit" name="info_update" value="Update Options" />

			</div>

		</form>
	</div><?php
}


//hooks
add_filter('the_content', 'bp_text', 2);
add_action('admin_menu', 'blogroll_page_admin');

?>
