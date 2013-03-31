<?php

/*  Greg's Writing Additions
	
	Copyright (c) 2009-2012 Greg Mulhauser
	http://gregsplugins.com
	
	Released under the GPL license
	http://www.opensource.org/licenses/gpl-license.php
	
	**********************************************************************
	This program is distributed in the hope that it will be useful, but
	WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. 
	*****************************************************************
*/

if (!function_exists ('is_admin')) {
	header('Status: 403 Forbidden');
	header('HTTP/1.1 403 Forbidden');
	exit();
	}

class ghpseoWritingAdditions { // insert our various additions to the writing pages

	var $plugin_name;          // name of the plugin
	var $plugin_prefix;        // prefix for this plugin
	var $domain;               // text domain
	var $restricted;           // restrict access to the writing additions?
	var $post_set;             // additions for post editing
	var $page_set;             // additions for page editing
	var $docounter;            // add a character counter to this box
	var $cust_types;		   // support custom post types?

	function ghpseoWritingAdditions($args) {
		$this->__construct($args);
		return;
	}
	
	function __construct($args) {
		extract($args);
		$this->plugin_name = wptexturize($name);
		$this->plugin_prefix = $prefix;
		$this->domain = $prefix . '-plugin';
		$this->restricted = $restricted;
		$this->post_set = $post_set;
		$this->page_set = $page_set;
		$this->docounter = $docounter;
		$this->cust_types = $cust_types;
		// add actions depending on where user has told us to place additions
		if ($post_set || $page_set) {
			add_action('admin_menu', array(&$this, 'add_boxes'));
			add_action('admin_head', array(&$this, 'add_writing_css'));
			add_action('save_post', array(&$this, 'save_postdata'));
		}
		return;
	} // end constructor

	function restrict() { // check whether access to this stuff is restricted
		if ($this->restricted && (!current_user_can('publish_posts'))) return true;
		else return false;
	} // end check for restriction to just users who can publish

	function add_boxes() { // set up our meta boxes
		if ($this->restrict()) return; // if restricted and current user cannot publish posts, don't do anything
		$name = $this->plugin_name;
		$prefix = $this->plugin_prefix;
		if ($this->page_set)
			add_meta_box("{$prefix}-meta", $name, array(&$this,'meta_writing_page'), 'page', 'normal', 'high');
		if ($this->post_set)
			add_meta_box("{$prefix}-meta", $name, array(&$this,'meta_writing_post'), 'post', 'normal', 'high');
		if ($this->post_set && $this->cust_types) {
			$args = array(
					'_builtin' => false
					); 
			$post_types = get_post_types($args);
			foreach ($post_types  as $post_type ) {
				add_meta_box("{$prefix}-meta", $name, array(&$this,'meta_writing_post'), $post_type, 'normal', 'high');
			}
		}
		return;
	}

	function meta_writing_post() { // additions for posts
		$mymeta = $this->post_set;
		$this->do_meta_writing($mymeta);
		return;
	} // end writing additions for post

	function meta_writing_page() { // additions for pages
		$mymeta = $this->page_set;
		$this->do_meta_writing($mymeta);
		return;
	} // end writing additions for page

	function do_meta_writing($mymeta=array()) { // perform the actual insertions on the page
		if ($this->restrict()) return; // if restricted and current user cannot publish posts, don't do anything
		if (!$mymeta) return;
		$docounter = $this->docounter;
		$prefix = $this->plugin_prefix;
		$str = array ( // this defines the structure of our insertions
				"blockstart" => '<table>',
				"blockend" => '</table>',
				"tag_pre" => '', // was <p>
				"tag_post" => '', // was </p>
				"label_pre" => '<tr><td style="vertical-align:top;text-align:right">',
				"label_post" => '</td>',
				"label_tag_pre" => '<p><strong>',
				"label_tag_post" => '</strong></p>',
				"fulltag_pre" => '<td style="width:99%">',
				"fulltag_post" => '</td></tr>',
				);
		if ($docounter) { // simple JS character counter, if required
			$counter = <<<EOT
						<script type="text/javascript" charset="utf-8">
						/*<![CDATA[*//*---->*/
						function {$prefix}Counter(textarea) {
						document.post.{$prefix}Len.value = textarea.value.length;
						}
						/*--*//*]]>*/
						</script>
EOT;
			$mods = array( // modifications we'll need if we're using character counter
			"{$docounter}" => array(  
							"tagbefore" => "<div id='{$prefix}_counted_box'>",
							"tagextra" => " onkeydown='{$prefix}Counter(this)' onkeyup='{$prefix}Counter(this)'",
							"tagafter" => "</div><div id='{$prefix}_counter_box'><input readonly='readonly' type='text' name='{$prefix}Len' size='3' maxlength='3' value='0' style='width:auto;' /></div>",
							),
						 );
		} else $counter = $mods = '';
		echo $counter;
		$this->do_meta($mymeta,$str,true,true,$tabindex='2',$mods);
		return;
	} // end writing additions

	function add_writing_css() { // format our writing additions
		if ($this->restrict()) return; // if restricted and current user cannot publish posts, don't do anything
		$prefix = $this->plugin_prefix;
		$css = <<<EOT
				<style type="text/css">
				#{$prefix}-meta .input-text-wrap, #{$prefix}-meta .textarea-wrap {margin:.5em 0 0 0;border-right:1px solid white;}
				#{$prefix}-meta div#{$prefix}_counted_box {margin-right:4em;z-index:9;}
				#{$prefix}-meta div#{$prefix}_counter_box {float:right;position:relative;top:-3em;z-index:1;width:5em;height:100%;overflow:hidden;}
				#{$prefix}-meta div#{$prefix}_counter_box input {float:right;background:transparent;border:none;font-size:2em;color:#cccccc;text-align:right;padding:0;margin:0;}
				</style>
EOT;
		echo $css;
		return;
	}

	function do_meta($mymeta=array(), $str=array(), $withdesc=true, $echo=true, $tabindex='2', $mods=array()) { // construct the actual boxes to be inserted on the page
		global $post;
		if (!$mymeta) return;
		if (count($str) < 5)
		$str = array ( // determines the structure of our insertions
				"blockstart" => '<table>',
				"blockend" => '</table>',
				"tag_pre" => '', // was <p>
				"tag_post" => '', // was </p>
				"label_pre" => '<tr><td style="vertical-align:top;text-align:right">',
				"label_post" => '</td>',
				"label_tag_pre" => '<p><strong>',
				"label_tag_post" => '</strong></p>',
				"fulltag_pre" => '<td style="width:99%">',
				"fulltag_post" => '</td></tr>',
				);
		
		$output = $str['blockstart'];
		
		foreach($mymeta as $meta) {
			$meta_value = htmlspecialchars(get_post_meta($post->ID, $meta['name'], true));
			
			if($meta_value == "")
				$meta_value = $meta['std']; // use default
			
			$desc = ($withdesc) ? '<p class="%NAME%_desc">%DESCRIPTION%</p>' : '';
			
			$checked = '';
			
			if ($meta['type'] == 'text') {
				$fulltag = $str['tag_pre'] . '<div class="input-text-wrap %NAME%">%TAGBEFORE%<input style="width:98%" %TABINDEX% type="text" name="%NAME%" id="%NAME%" value="%VALUE%"%TAGEXTRA% /></div>%TAGAFTER%' . $str['tag_post'] . $desc;
			}
			elseif ($meta['type'] == 'textarea') {
				$fulltag = $str['tag_pre'] . '<div class="textarea-wrap %NAME%">%TAGBEFORE%<textarea style="width:98%" %TABINDEX% name="%NAME%" id="%NAME%" rows="'. $meta['rows'] .'" cols="'. $meta['cols'] .'"%TAGEXTRA%>%VALUE%</textarea>%TAGAFTER%</div>' . $str['tag_post'] . $desc;
			}
			elseif ($meta['type'] == 'checkbox') { // NOTE not updated to handle placement of label
				$fulltag = $str['tag_pre'] . '<label for="%NAME%"><input %TABINDEX% name="%NAME%" id="%NAME%" type="checkbox" value="1" %CHECKED% />&nbsp;%DESCRIPTION%</label>' . $str['tag_post'];
				$checked = ( 1 == $meta_value ) ? 'checked="checked"' : '';
			}
			
			if (isset($mods[$meta['name']]) && is_array($mods[$meta['name']])) { // have to do mods for char counter, for example
				$tagbefore = (array_key_exists('tagbefore',$mods[$meta['name']])) ? $mods[$meta['name']]['tagbefore'] : '';
				$tagextra = (array_key_exists('tagextra',$mods[$meta['name']])) ? $mods[$meta['name']]['tagextra'] : '';
				$tagafter = (array_key_exists('tagafter',$mods[$meta['name']])) ? $mods[$meta['name']]['tagafter'] : '';
			}
			else $tagbefore = $tagextra = $tagafter = '';
			
			$toreplace = array ('%NAME%','%VALUE%','%DESCRIPTION%','%CHECKED%','%TAGBEFORE%','%TAGEXTRA%','%TAGAFTER%','%TABINDEX%');
			$replacements = array ($meta['name'],$meta_value,$meta['description'],$checked,$tagbefore,$tagextra,$tagafter,'tabindex="' . $tabindex . '"');

			$here = basename(dirname( __FILE__)) . '/' . basename( __FILE__); // don't use plugin_basename
			
			$output .= $str['label_pre'];
			$output .= $str['label_tag_pre'] . '<label for="%NAME%">' . $meta['title'] . '</label>' . $str['label_tag_post'];
			$output .= '<input type="hidden" name="%NAME%_noncename" id="%NAME%_noncename" value="'.wp_create_nonce( $here ).'" />';
			$output .= $str['label_post'];
			$output .= $str['fulltag_pre'];
			$output .= $fulltag;
			$output .= $str['fulltag_post'];
			
			$output = str_replace($toreplace,$replacements,$output);
			
		} // end loop over boxes to display
		
		$output .= $str['blockend'];
		if ($echo) echo $output;
		else return $output;
		return;
	} // end function for showing boxes

	function save_postdata( $post_id ) { // welcome to the old days: we have to save this stuff ourselves; some day, hopefully, there will be an analogue of register_setting for this job
		global $post;
		if ($this->restrict()) return; // if restricted and current user cannot publish posts, don't do anything
		
		// *** NOTE problems may occur with the following line if dashboard ever has different set than post set
		$meta_set = ( ( isset($_POST['post_type']) ) && ( 'page' == $_POST['post_type'] ) ) ? $this->page_set : $this->post_set;
		
		$here = basename(dirname( __FILE__)) . '/' . basename( __FILE__); // don't use plugin_basename

		foreach ($meta_set as $meta) {
			// Verify this came from the appropriate screen and with authentication
			if (!isset($_POST[$meta['name'].'_noncename']) || !wp_verify_nonce( $_POST[$meta['name'].'_noncename'], $here )) {
				return $post_id;
			}
/*			if ( !wp_verify_nonce( $_POST[$meta['name'].'_noncename'], plugin_basename(__FILE__) )) {
				return $post_id;
			}
*/			
			if ( ( isset($_POST['post_type']) ) && ( 'page' == $_POST['post_type'] ) ) {
				if ( !current_user_can( 'edit_page', $post_id )) return $post_id;
			}
			else {
				if ( !current_user_can( 'edit_post', $post_id ))
				return $post_id;
			}
			
			// We're authenticated, so get on with handling data
			
			$data = ($meta['allow_tags']) ? stripslashes($_POST[$meta['name']]) : strip_tags(stripslashes($_POST[$meta['name']]));
			// 20100503: check for existing data first to address weird problems if user has manually saved multiple fields with same key (thanks to Jason)
			$existing_data = get_post_meta($post_id, $meta['name'], true);
			
			if ($data == "") {
				if ($existing_data != "")
					delete_post_meta($post_id, $meta['name'], $existing_data);
			}
			else {
				if ($existing_data == "")
					add_post_meta($post_id, $meta['name'], $data, true);
				else
					update_post_meta($post_id, $meta['name'], $data);
			}
			
			} // end loop over meta values to store
		return;
	} // end function for saving post metadata

} // end writing additions class

?>