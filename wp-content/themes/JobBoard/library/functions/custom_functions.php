<?php 
// Custom fields for WP write panel
// This code is protected under Creative Commons License: http://creativecommons.org/licenses/by-nc-nd/3.0/

//Custom Settings
$pt_metaboxes = array(
		"image" => array (
			"name"		=> "image",
			"default" 	=> "",
			"label" 	=> "Custom Image Location",
			"type" 		=> "text",
			"desc"      => "Enter full URL path for image to be used by the Dynamic Image resizer. (including <code>http://</code>). Image must be uploaded to your blog or it won't resize due to copyright restrictions of TimThumb script. You also need to Chmod <code>cache</code> folder in theme files to 777 restrictions."
		),
	);

// Excerpt length

function bm_better_excerpt($length, $ellipsis) {
$text = get_the_content();
$text = strip_tags($text);
$text = substr($text, 0, $length);
$text = substr($text, 0, strrpos($text, " "));
$text = $text.$ellipsis;
return $text;
}
// Custom fields for WP write panel
// This code is protected under Creative Commons License: http://creativecommons.org/licenses/by-nc-nd/3.0/

function ptthemes_meta_box_content() {
    global $post, $pt_metaboxes;
    $output = '';
    $output .= '<div class="pt_metaboxes_table">'."\n";
    foreach ($pt_metaboxes as $pt_id => $pt_metabox) {
    if($pt_metabox['type'] == 'text' OR $pt_metabox['type'] == 'select' OR $pt_metabox['type'] == 'checkbox' OR $pt_metabox['type'] == 'textarea')
            $pt_metaboxvalue = get_post_meta($post->ID,$pt_metabox["name"],true);
            if ($pt_metaboxvalue == "" || !isset($pt_metaboxvalue)) {
                $pt_metaboxvalue = $pt_metabox['default'];
            }
            if($pt_metabox['type'] == 'text'){
            
                $output .= "\t".'<div>';
                $output .= "\t\t".'<br/><p><strong><label for="'.$pt_id.'">'.$pt_metabox['label'].'</label></strong></p>'."\n";
                $output .= "\t\t".'<p><input size="100" class="pt_input_text" type="'.$pt_metabox['type'].'" value="'.$pt_metaboxvalue.'" name="ptthemes_'.$pt_metabox["name"].'" id="'.$pt_id.'"/></p>'."\n";
                $output .= "\t\t".'<p><span style="font-size:11px">'.$pt_metabox['desc'].'</span></p>'."\n";
                $output .= "\t".'</div>'."\n";
                              
            }
            
            elseif ($pt_metabox['type'] == 'textarea'){
            			
				$output .= "\t".'<div>';
                $output .= "\t\t".'<br/><p><strong><label for="'.$pt_id.'">'.$pt_metabox['label'].'</label></strong></p>'."\n";
                $output .= "\t\t".'<p><textarea rows="5" cols="98" class="pt_input_textarea" name="ptthemes_'.$pt_metabox["name"].'" id="'.$pt_id.'">' . $pt_metaboxvalue . '</textarea></p>'."\n";
                $output .= "\t\t".'<p><span style="font-size:11px">'.$pt_metabox['desc'].'</span></p>'."\n";
                $output .= "\t".'</div>'."\n";
                              
            }

            elseif ($pt_metabox['type'] == 'select'){
                            
                $output .= "\t".'<div>';
                $output .= "\t\t".'<br/><p><strong><label for="'.$pt_id.'">'.$pt_metabox['label'].'</label></strong></p>'."\n";
                $output .= "\t\t".'<p><select class="pt_input_select" id="'.$pt_id.'" name="ptthemes_'. $pt_metabox["name"] .'"></p>'."\n";
                $output .= '<option>Select a Upload</option>';
                
                $array = $pt_metabox['options'];
                
                if($array){
                    foreach ( $array as $id => $option ) {
                        $selected = '';
                        if($pt_metabox['default'] == $option){$selected = 'selected="selected"';} 
                        if($pt_metaboxvalue == $option){$selected = 'selected="selected"';}
                        $output .= '<option value="'. $option .'" '. $selected .'>' . $option .'</option>';
                    }
                }
                
                $output .= '</select><p><span style="font-size:11px">'.$pt_metabox['desc'].'</span></p>'."\n";
                $output .= "\t".'</div>'."\n";
            }
            
            elseif ($pt_metabox['type'] == 'checkbox'){
                if($pt_metaboxvalue == 'on') { $checked = 'checked="checked"';} else {$checked='';}
                
				$output .= "\t".'<div>';
                $output .= "\t\t".'<br/><p><strong><label for="'.$pt_id.'">'.$pt_metabox['label'].'</label></strong></p>'."\n";
                $output .= "\t\t".'<p><input type="checkbox" '.$checked.' class="pt_input_checkbox"  id="'.$pt_id.'" name="ptthemes_'. $pt_metabox["name"] .'" /></p>'."\n";
                $output .= "\t\t".'<p><span style="font-size:11px">'.$pt_metabox['desc'].'</span></p>'."\n";
                $output .= "\t".'</div>'."\n";

            }
        
        }
    
    $output .= '</div>'."\n\n";
    echo $output;
}

function ptthemes_metabox_insert() {
    global $pt_metaboxes;
    global $globals;
    $pID = $_POST['post_ID'];
    $counter = 0;

    
    foreach ($pt_metaboxes as $pt_metabox) { // On Save.. this gets looped in the header response and saves the values submitted
    if($pt_metabox['type'] == 'text' OR $pt_metabox['type'] == 'select' OR $pt_metabox['type'] == 'checkbox' OR $pt_metabox['type'] == 'textarea') // Normal Type Things...
        {
            $var = "ptthemes_".$pt_metabox["name"];
            if (isset($_POST[$var])) {            
                if( get_post_meta( $pID, $pt_metabox["name"] ) == "" )
                    add_post_meta($pID, $pt_metabox["name"], $_POST[$var], true );
                elseif($_POST[$var] != get_post_meta($pID, $pt_metabox["name"], true))
                    update_post_meta($pID, $pt_metabox["name"], $_POST[$var]);
                elseif($_POST[$var] == "")
                    delete_post_meta($pID, $pt_metabox["name"], get_post_meta($pID, $pt_metabox["name"], true));
            }  
        } 
    }
}

function ptthemes_header_inserts(){
	echo '<link rel="stylesheet" type="text/css" href="'.get_bloginfo('template_directory').'/library/functions/admin_style.css" media="screen" />';
}

function ptthemes_meta_box() {
    if ( function_exists('add_meta_box') ) {
        add_meta_box('ptthemes-settings',$GLOBALS['themename'].' Custom Settings','ptthemes_meta_box_content','post','normal','high');
    }
}

//add_action('admin_menu', 'ptthemes_meta_box');
//add_action('admin_head', 'ptthemes_header_inserts');
//add_action('save_post', 'ptthemes_metabox_insert');


function relativeDate($posted_date) {
    
    $tz = 0;    // change this if your web server and weblog are in different timezones
                // see project page for instructions on how to do this
    
    $month = substr($posted_date,4,2);
    
    if ($month == "02") { // february
    	// check for leap year
    	$leapYear = isLeapYear(substr($posted_date,0,4));
    	if ($leapYear) $month_in_seconds = 2505600; // leap year
    	else $month_in_seconds = 2419200;
    }
    else { // not february
    // check to see if the month has 30/31 days in it
    	if ($month == "04" or 
    		$month == "06" or 
    		$month == "09" or 
    		$month == "11")
    		$month_in_seconds = 2592000; // 30 day month
    	else $month_in_seconds = 2678400; // 31 day month;
    }
  
/* 
some parts of this implementation borrowed from:
http://maniacalrage.net/archives/2004/02/relativedatesusing/ 
*/
  
    $in_seconds = strtotime(substr($posted_date,0,8).' '.
                  substr($posted_date,8,2).':'.
                  substr($posted_date,10,2).':'.
                  substr($posted_date,12,2));
    $diff = time() - ($in_seconds + ($tz*3600));
    $months = floor($diff/$month_in_seconds);
    $diff -= $months*2419200;
    $weeks = floor($diff/604800);
    $diff -= $weeks*604800;
    $days = floor($diff/86400);
    $diff -= $days*86400;
    $hours = floor($diff/3600);
    $diff -= $hours*3600;
    $minutes = floor($diff/60);
    $diff -= $minutes*60;
    $seconds = $diff;

    if ($months>0) {
        // over a month old, just show date ("Month, Day Year")
        echo ''; the_time('F jS, Y');
    } else {
        if ($weeks>0) {
            // weeks and days
            $relative_date .= ($relative_date?', ':'').$weeks.' '.get_option('ptthemes_relative_week').''.($weeks>1?''.get_option('ptthemes_relative_s').'':'');
            $relative_date .= $days>0?($relative_date?', ':'').$days.' '.get_option('ptthemes_relative_day').''.($days>1?''.get_option('ptthemes_relative_s').'':''):'';
        } elseif ($days>0) {
            // days and hours
            $relative_date .= ($relative_date?', ':'').$days.' '.get_option('ptthemes_relative_day').''.($days>1?''.get_option('ptthemes_relative_s').'':'');
            $relative_date .= $hours>0?($relative_date?', ':'').$hours.' '.get_option('ptthemes_relative_hour').''.($hours>1?''.get_option('ptthemes_relative_s').'':''):'';
        } elseif ($hours>0) {
            // hours and minutes
            $relative_date .= ($relative_date?', ':'').$hours.' '.get_option('ptthemes_relative_hour').''.($hours>1?''.get_option('ptthemes_relative_s').'':'');
            $relative_date .= $minutes>0?($relative_date?', ':'').$minutes.' '.get_option('ptthemes_relative_minute').''.($minutes>1?''.get_option('ptthemes_relative_s').'':''):'';
        } elseif ($minutes>0) {
            // minutes only
            $relative_date .= ($relative_date?', ':'').$minutes.' '.get_option('ptthemes_relative_minute').''.($minutes>1?''.get_option('ptthemes_relative_s').'':'');
        } else {
            // seconds only
            $relative_date .= ($relative_date?', ':'').$seconds.' '.get_option('ptthemes_relative_minute').''.($seconds>1?''.get_option('ptthemes_relative_s').'':'');
        }
        
        // show relative date and add proper verbiage
    	echo ''.get_option('ptthemes_relative_posted').' '.$relative_date.' '.get_option('ptthemes_relative_ago').'';
    }
    
}

function isLeapYear($year) {
        return $year % 4 == 0 && ($year % 400 == 0 || $year % 100 != 0);
}

    if(!function_exists('how_long_ago')){
        function how_long_ago($timestamp){
            $difference = time() - $timestamp;

            if($difference >= 60*60*24*365){        // if more than a year ago
                $int = intval($difference / (60*60*24*365));
                $s = ($int > 1) ? ''.get_option('ptthemes_relative_s').'' : '';
                $r = $int . ' '.get_option('ptthemes_relative_year').'' . $s . ' '.get_option('ptthemes_relative_ago').'';
            } elseif($difference >= 60*60*24*7*5){  // if more than five weeks ago
                $int = intval($difference / (60*60*24*30));
                $s = ($int > 1) ? ''.get_option('ptthemes_relative_s').'' : '';
                $r = $int . ' '.get_option('ptthemes_relative_month').'' . $s . ' '.get_option('ptthemes_relative_ago').'';
            } elseif($difference >= 60*60*24*7){        // if more than a week ago
                $int = intval($difference / (60*60*24*7));
                $s = ($int > 1) ? ''.get_option('ptthemes_relative_s').'' : '';
                $r = $int . ' '.get_option('ptthemes_relative_week').'' . $s . ' '.get_option('ptthemes_relative_ago').'';
            } elseif($difference >= 60*60*24){      // if more than a day ago
                $int = intval($difference / (60*60*24));
                $s = ($int > 1) ? ''.get_option('ptthemes_relative_s').'' : '';
                $r = $int . ' '.get_option('ptthemes_relative_day').'' . $s . ' '.get_option('ptthemes_relative_ago').'';
            } elseif($difference >= 60*60){         // if more than an hour ago
                $int = intval($difference / (60*60));
                $s = ($int > 1) ? ''.get_option('ptthemes_relative_s').'' : '';
                $r = $int . ' '.get_option('ptthemes_relative_hour').'' . $s . ' '.get_option('ptthemes_relative_ago').'';
            } elseif($difference >= 60){            // if more than a minute ago
                $int = intval($difference / (60));
                $s = ($int > 1) ? ''.get_option('ptthemes_relative_s').'' : '';
                $r = $int . ' '.get_option('ptthemes_relative_minute').'' . $s . ' '.get_option('ptthemes_relative_ago').'';
            } else {                                // if less than a minute ago
                $r = ''.get_option('ptthemes_relative_moments').' '.get_option('ptthemes_relative_ago').'';
            }

            return $r;
        }
    }

/*
Plugin Name: WP-PageNavi 
Plugin URI: http://www.lesterchan.net/portfolio/programming.php 
*/ 

if(!function_exists('wp_pagenavi')) {
function wp_pagenavi($before = '', $after = '', $prelabel = '', $nxtlabel = '', $pages_to_show = 5, $always_show = false) {
	global $request, $posts_per_page, $wpdb, $paged, $totalpost_count, $posts_per_page_homepage;
	if($posts_per_page_homepage)
	{
		$posts_per_page = $posts_per_page_homepage;
	}
	if(empty($prelabel)) {
		$prelabel  = '<strong>&laquo;</strong>';
	}
	if(empty($nxtlabel)) {
		$nxtlabel = '<strong>&raquo;</strong>';
	}
	$half_pages_to_show = round($pages_to_show/2);
	if (!is_single()) {
		if(is_tag()) {
			preg_match('#FROM\s(.*)\sGROUP BY#siU', $request, $matches);
		} elseif (!is_category()) {
			preg_match('#FROM\s(.*)\sORDER BY#siU', $request, $matches);
		} else {
			preg_match('#FROM\s(.*)\sGROUP BY#siU', $request, $matches);
		}
		$fromwhere = $matches[1];
		$numposts = $wpdb->get_var("SELECT COUNT(DISTINCT ID) FROM $fromwhere");
	}
	if($totalpost_count)
	{
		$numposts = $totalpost_count;
	}
	$max_page = ceil($numposts /$posts_per_page);
		if(empty($paged)) {
			$paged = 1;
		}
		if($max_page > 1 || $always_show) {
			echo "$before <div class='Navi'>";
			if ($paged >= ($pages_to_show-1)) {
				echo '<a href="'.str_replace('&','&amp;',str_replace('&','&amp;',get_pagenum_link())).'">&laquo; First</a>';
			}
			previous_posts_link($prelabel);
			for($i = $paged - $half_pages_to_show; $i  <= $paged + $half_pages_to_show; $i++) {
				if ($i >= 1 && $i <= $max_page) {
					if($i == $paged) {
						echo "<strong class='on'>$i</strong>";
					} else {
						echo ' <a href="'.str_replace('&','&amp;',get_pagenum_link($i)).'">'.$i.'</a> ';
					}
				}
			}
			next_posts_link($nxtlabel, $max_page);
			if (($paged+$half_pages_to_show) < ($max_page)) {
				echo '<a href="'.str_replace('&','&amp;',get_pagenum_link($max_page)).'">Last &raquo;</a>';
			}
			echo "</div> $after";
		}
}
}

function ptthemes_noindex_head() { 
	$meta_string = '';
    if ((is_category() && get_option('ptthemes_noindex_category') == 'Yes') ||
	    (is_tag() && get_option('ptthemes_noindex_tag') == 'Yes') ||
		(is_day() && get_option('ptthemes_noindex_daily') == 'Yes') ||
		(is_month() && get_option('ptthemes_noindex_monthly') == 'Yes') ||
		(is_year() && get_option('ptthemes_noindex_yearly') == 'Yes') ||
		(is_author() && get_option('ptthemes_noindex_author') == 'Yes') ||
		(is_search() && get_option('ptthemes_noindex_search') == 'Yes')) {

		$meta_string .= '<meta name="robots" content="noindex,follow" />';
	}
	
	echo $meta_string;
	
}

add_action('wp_head', 'ptthemes_noindex_head');

///////////NEW FUNCTIONS  START//////
function bdw_get_images($iPostID,$img_size='thumb',$no_images='') 
{
    $arrImages =& get_children('order=ASC&orderby=menu_order ID&post_type=attachment&post_mime_type=image&post_parent=' . $iPostID );
	$counter = 0;
	$return_arr = array();
	if($arrImages) 
	{		
       foreach($arrImages as $key=>$val)
	   {
	   		$id = $val->ID;
			if($img_size == 'large')
			{
				$img_arr = wp_get_attachment_image_src($id,'full');	// THE FULL SIZE IMAGE INSTEAD
				$return_arr[] = $img_arr[0];
			}
			elseif($img_size == 'medium')
			{
				$img_arr = wp_get_attachment_image_src($id, 'medium'); //THE medium SIZE IMAGE INSTEAD
				$return_arr[] = $img_arr[0];
			}
			elseif($img_size == 'thumb')
			{
				$img_arr = wp_get_attachment_image_src($id, 'thumbnail'); // Get the thumbnail url for the attachment
				$return_arr[] = $img_arr[0];
			}
			elseif($img_size == 'homeslide')
			{
				$img_arr = wp_get_attachment_image_src($id, 'homeslide'); // Get the thumbnail url for the attachment
				$return_arr[] = $img_arr[0];
			}
			elseif($img_size == 'widget-thumb')
			{
				$img_arr = wp_get_attachment_image_src($id, 'widget-thumb'); // Get the thumbnail url for the attachment
				$return_arr[] = $img_arr[0];
			}

			$counter++;
			if($no_images!='' && $counter==$no_images)
			{
				break;	
			}
	   }
	  return $return_arr;
	}
}
function bdw_get_images_with_info($iPostID,$img_size='thumb') 
{ 
    $arrImages =& get_children('order=ASC&orderby=menu_order ID&post_type=attachment&post_mime_type=image&post_parent=' . $iPostID );
	$return_arr = array();
	if($arrImages) 
	{		
       foreach($arrImages as $key=>$val)
	   {
	   		$id = $val->ID;
			if($img_size == 'large')
			{
				$img_arr = wp_get_attachment_image_src($id,'full');	// THE FULL SIZE IMAGE INSTEAD
				$imgarr['id'] = $id;
				$imgarr['file'] = $img_arr[0];
				$return_arr[] = $imgarr;
			}
			elseif($img_size == 'medium')
			{
				$img_arr = wp_get_attachment_image_src($id, 'medium'); //THE medium SIZE IMAGE INSTEAD
				$imgarr['id'] = $id;
				$imgarr['file'] = $img_arr[0];
				$return_arr[] = $imgarr;
			}
			elseif($img_size == 'thumb')
			{
				$img_arr = wp_get_attachment_image_src($id, 'thumbnail'); // Get the thumbnail url for the attachment
				$imgarr['id'] = $id;
				$imgarr['file'] = $img_arr[0];
				$return_arr[] = $imgarr;
				
			}elseif($img_size == 'single-image')
			{
				$img_arr = wp_get_attachment_image_src($id, 'single-image'); // Get the thumbnail url for the attachment
				$imgarr['id'] = $id;
				$imgarr['file'] = $img_arr[0];
				$return_arr[] = $imgarr;
				
			}elseif($img_size == 'single-image')
			{
				$img_arr = wp_get_attachment_image_src($id, 'single-image'); // Get the thumbnail url for the attachment
				$imgarr['id'] = $id;
				$imgarr['file'] = $img_arr[0];
				$return_arr[] = $imgarr;
				
			}elseif($img_size == 'widget-thumb')
			{
				$img_arr = wp_get_attachment_image_src($id, 'widget-thumb'); // Get the thumbnail url for the attachment
				$imgarr['id'] = $id;
				$imgarr['file'] = $img_arr[0];
				$return_arr[] = $imgarr;
				
			}elseif($img_size == 'homeslide')
			{
				$img_arr = wp_get_attachment_image_src($id, 'homeslide'); // Get the thumbnail url for the attachment
				$imgarr['id'] = $id;
				$imgarr['file'] = $img_arr[0];
				$return_arr[] = $imgarr;
				
			}
	   }
	  return $return_arr;
	}
}

function get_cat_id_from_name($catname)
{
	global $wpdb;
	if($catname)
	{
	return $pn_categories_obj = $wpdb->get_var("SELECT $wpdb->terms.term_id as cat_ID 
	                            FROM $wpdb->term_taxonomy,  $wpdb->terms
                                WHERE $wpdb->term_taxonomy.term_id =  $wpdb->terms.term_id AND $wpdb->terms.name like \"$catname\"
                                AND $wpdb->term_taxonomy.taxonomy = 'pcategory'");
	}
}
function in_sub_category($parentid,$postid)
{
	$catarr = getCategoryList($parentid);
	if($catarr)
	{
		foreach($catarr as $key=>$val)
		{
			if($val['ID'] != '')
			{
				if(in_category($val['ID'],$postid))
				{
					return true;
				}
			}
		}
	}
	return false;
}

function get_property_all_cat_ids()
{
	$property_parent_ids = get_property_parent_catids();
	$property_parent_ids_arr = explode(',',$property_parent_ids);
	$str = '';
	for($i=0;$i<count($property_parent_ids_arr);$i++)
	{
		$str .= get_sub_categories($property_parent_ids_arr[$i],'string');
	}
	return $str;	
}
function is_sub_category($parentid)
{
	$catarr = getCategoryList($parentid);
	if($catarr)
	{
		foreach($catarr as $key=>$val)
		{
			if($val['ID'] != '')
			{
				if(is_category($val['ID']))
				{
					return true;
				}
			}
		}
	}
	return false;
}
function get_property_price($postid)
{
	if(get_post_meta($postid,'price',true) && get_post_meta($postid,'price',true)>0)
	{
		return get_currency_sym().(get_post_meta($postid,'price',true));
	}
}
function get_area_srch_params()
{
	global $wpdb;
	$option_value = get_option('ptthemes_area_range');
	if($option_value)
	{
		return stripslashes($option_value);
	}
}

/* - Get the symbol of currency - */
function get_currency_sym()
{
	global $wpdb;
	$option_value = get_option('ptttheme_currency_symbol');
	if($option_value)
	{
		return $option_value;
	}else
	{
		return '$';
	}
}
function get_currency_type()
{
	global $wpdb;
	$option_value = get_option('ptttheme_currency_code');
	if($option_value)
	{
		return stripslashes($option_value);
	}else
	{
		return 'USD';
	}
	
}
function get_site_emailId()
{
	$generalinfo = get_option('mysite_general_settings');
	if($generalinfo['site_email'])
	{
		return $generalinfo['site_email'];
	}else
	{
		return get_option('admin_email');
	}
}
function get_site_emailName()
{
	$generalinfo = get_option('mysite_general_settings');
	if($generalinfo['site_email_name'])
	{
		return stripslashes($generalinfo['site_email_name']);
	}else
	{
		return stripslashes(get_option('blogname'));
	}
}
function is_allow_user_register()
{
	$generalinfo = get_option('users_can_register');
	if($generalinfo)
	{
		return true;
	}else
	{
		return false;
	}
}
function get_default_status()
{
	$generalinfo = get_option('approve_status');
	if($generalinfo)
	{
		return $generalinfo;
	}else
	{
		return 'publish';
	}
}

function get_job_price_info($pro_type='',$price='')
{
	global $price_db_table_name,$wpdb;
	if($pro_type !="")
	{
		$subsql = " and pid=\"$pro_type\"";	
	}
	$pricesql = "select * from $price_db_table_name where status=1 $subsql";
	$priceinfo = $wpdb->get_results($pricesql);
	$price_info = array();
	if($priceinfo !="")
	{
		foreach($priceinfo as $priceinfoObj)
		{
			$info = array();
			$vper = $priceinfoObj->validity_per;
			$validity = $priceinfoObj->validity;
			if(($priceinfoObj->validity != "" || $priceinfoObj->validity != 0))
			{
				if($vper == 'M')
				{
					$tvalidity = $validity*30 ;
				}else if($vper == 'Y'){
					$tvalidity = $validity*365 ;
				}else{
					$tvalidity = $validity ;
				}
			}
		$info['title'] = $priceinfoObj->price_title;
		$info['price'] = $price;
		$info['days'] = $tvalidity;
		$info['alive_days'] =$tvalidity;
		$info['cat'] =$priceinfoObj->price_post_cat;
		$info['is_featured'] = $priceinfoObj->is_featured;
		$info['title_desc'] =$priceinfoObj->title_desc;
		$info['is_recurring'] =$priceinfoObj->is_recurring;
		if($priceinfoObj->is_recurring == '1') {
			$info['billing_num'] =$priceinfoObj->billing_num;
			$info['billing_per'] =$priceinfoObj->billing_per;
			$info['billing_cycle'] =$priceinfoObj->billing_cycle;
		}
		$price_info[] = $info;
		}
	}
	return $price_info;

}
/**- I will call when any mails awill be fire --**/
function sendEmail($fromEmail,$fromEmailName,$toEmail,$toEmailName,$subject,$message,$extra='')
{
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
	
	// Additional headers
	$headers .= 'To: '.$toEmailName.' <'.$toEmail.'>' . "\r\n";
	//$headers .= 'From: '.$fromEmailName.' <'.$fromEmail.'>' . "\r\n";

/*	echo "Header : headers <br>";
	echo "To : $toEmail  Name : $to_name <br>";
	echo "Subject $subject <br>";
	echo "$message";
	exit;*/
	// Mail it
	if(@mail($toEmail, $subject, $message, $headers))
	{
		//mail($toEmail, $subject, $message, $headers);
	}else
	{
		wp_mail($toEmail, $subject, $message, $headers);
	}
}
function get_image_phy_destination_path()
{	
	$wp_upload_dir = wp_upload_dir();
	$path = $wp_upload_dir['path'];
	$url = $wp_upload_dir['url'];
	  $destination_path = $path."/";
      if (!file_exists($destination_path)){
      $imagepatharr = explode('/',str_replace(ABSPATH,'', $destination_path));
	   $year_path = ABSPATH;
		for($i=0;$i<count($imagepatharr);$i++)
		{
		  if($imagepatharr[$i])
		  {
			$year_path .= $imagepatharr[$i]."/";
			  if (!file_exists($year_path)){
				  mkdir($year_path, 0777);
			  }     
			}
		}
	}
	  return $destination_path;
}
/* This function give print the image if uploaded earlier or print avtar */
function get_user_profile_pic($user_id,$height=100,$width=100)
{
	 $user_data = get_userdata(intval($user_id));
	 if($user_data ->user_photo !='')
	 {
	     $img_data =  '<img class="agent_photo" src="'.$user_data ->user_photo.'" width="'.$width.'" alt="'.$user_data ->display_name.'"  />';
      }else{
		  $img_data =  '<img class="agent_photo" src="'.get_bloginfo('template_directory').'/images/no-image.png" width="'.$width.'" height="'.$height.'" alt="'.$user_data ->display_name.'"  />';
	 } 
	 echo $img_data;
}

/* This function would return paths of folder to which upload the image */
function get_image_phy_destination_path_user()
{	
	global $upload_folder_path;
	$tmppath = $upload_folder_path;
	$destination_path = ABSPATH . $tmppath."users/";
      if (!file_exists($destination_path)){
      $imagepatharr = explode('/',$tmppath."users");
	   $year_path = ABSPATH;
		for($i=0;$i<count($imagepatharr);$i++)
		{
		  if($imagepatharr[$i])
		  {
			$year_path .= $imagepatharr[$i]."/";
			  if (!file_exists($year_path)){
				  mkdir($year_path, 0777);
			  }     
			}
		}
	}
	 return $destination_path;
	
}

/**- Why ??? --**/
function get_image_rel_destination_path_user()
{	
	global $upload_folder_path;
	$destination_path = get_option( 'siteurl' ) ."/".$upload_folder_path."users/";
	  return $destination_path;
	
}

function get_image_rel_destination_path()
{
	$today = getdate();
	if ($today['month'] == "January"){
	  $today['month'] = "01";
	}
	elseif ($today['month'] == "February"){
	  $today['month'] = "02";
	}
	elseif  ($today['month'] == "March"){
	  $today['month'] = "03";
	}
	elseif  ($today['month'] == "April"){
	  $today['month'] = "04";
	}
	elseif  ($today['month'] == "May"){
	  $today['month'] = "05";
	}
	elseif  ($today['month'] == "June"){
	  $today['month'] = "06";
	}
	elseif  ($today['month'] == "July"){
	  $today['month'] = "07";
	}
	elseif  ($today['month'] == "August"){
	  $today['month'] = "08";
	}
	elseif  ($today['month'] == "September"){
	  $today['month'] = "09";
	}
	elseif  ($today['month'] == "October"){
	  $today['month'] = "10";
	}
	elseif  ($today['month'] == "November"){
	  $today['month'] = "11";
	}
	elseif  ($today['month'] == "December"){
	  $today['month'] = "12";
	}
	global $upload_folder_path;
	$tmppath = $upload_folder_path;
	global $blog_id;
	if($blog_id)
	{
		return $user_path = $today['year']."/".$today['month']."/";
	}else
	{
		return $user_path = get_option( 'siteurl' ) ."/$tmppath".$today['year']."/".$today['month']."/";
	}
}
function get_image_tmp_phy_path()
{	
	global $upload_folder_path;
	$tmppath = $upload_folder_path;
	return $destination_path = ABSPATH . "$tmppath/tmp/";
}

function move_original_image_file($src,$dest)
{
	copy($src, $dest);
	unlink($src);
	$dest = explode('/',$dest);
	$img_name = $dest[count($dest)-1];
	$img_name_arr = explode('.',$img_name);

	$my_post = array();
	$my_post['post_title'] = $img_name_arr[0];
	/* Code added on 13-03-2012 */
	//$my_post['guid'] = get_image_rel_destination_path().$img_name;
	$my_post['guid'] = get_bloginfo('url')."/files/".get_image_rel_destination_path().$img_name;

	return $my_post;
}
function get_image_size($src)
{
	$filextenson = stripExtension($src);
	if($filextenson == "jpeg" || $filextenson == "jpg")
	  {
		$img = imagecreatefromjpeg($src);  
	  }
	
	if($filextenson == "png")
	  {
		$img = imagecreatefrompng($src);  
	  }

	if($filextenson == "gif")
	  {
		$img = imagecreatefromgif($src);  
	  }

	$width = imageSX($img);
	$height = imageSY($img);
	return array('width'=>$width,'height'=>$height);
	
}

function stripExtension($filename = '') {
    if (!empty($filename)) 
	   {
        $filename = strtolower($filename);
        $extArray = split("[/\\.]", $filename);
        $p = count($extArray) - 1;
        $extension = $extArray[$p];
        return $extension;
    } else {
        return false;
    }
}

function get_attached_file_meta_path($imagepath)
{
	$imagepath_arr = explode('/',$imagepath);
	$imagearr = array();
	for($i=0;$i<count($imagepath_arr);$i++)
	{
		$imagearr[] = $imagepath_arr[$i];
		if($imagepath_arr[$i] == 'uploads')
		{
			break;
		}
	}
	$imgpath_ini = implode('/',$imagearr);
	return str_replace($imgpath_ini.'/','',$imagepath);
}

/** resize user uploaded images  BOF**/
function image_resize_custom($src,$dest,$twidth,$theight)
{
	global $image_obj;
	// Get the image and create a thumbnail
	$img_arr = explode('.',$dest);
	$imgae_ext = strtolower($img_arr[count($img_arr)-1]);
	if($imgae_ext == 'jpg' || $imgae_ext == 'jpeg')
	{
		$img = imagecreatefromjpeg($src);
	}elseif($imgae_ext == 'gif')
	{
		$img = imagecreatefromgif($src);
	}
	elseif($imgae_ext == 'png')
	{
		$img = imagecreatefrompng($src);
	}
	
	if($img)
	{
		$width = imageSX($img);
		$height = imageSY($img);
	
		if (!$width || !$height) {
			echo "ERROR:Invalid width or height";
			exit(0);
		}
		
		if(($twidth<=0 || $theight<=0))
		{
			return false;
		}
		$image_obj->load($src);
		$image_obj->resize($twidth,$theight);
		$new_width = $image_obj->getWidth();
		$new_height = $image_obj->getHeight();
		$imgname_sub = '-'.$new_width.'X'. $new_height.'.'.$imgae_ext;
		$img_arr1 = explode('.',$dest);
		unset($img_arr1[count($img_arr1)-1]);
		$dest = implode('.',$img_arr1).$imgname_sub;
		$image_obj->save($dest);
		
		
		return array(
					'file' => basename( $dest ),
					'width' => $new_width,
					'height' => $new_height,
				);
	}else
	{
		return array();
	}
}
/** resize user uploaded images  EOF**/

function get_author_info($aid)
{
	global $wpdb;
	$infosql = "select * from $wpdb->users where ID=$aid";
	$info = $wpdb->get_results($infosql);
	if($info)
	{
		return $info[0];
	}
}
function get_time_difference( $start, $pid )
{
	if($start)
	{
		$alive_days = get_post_meta($pid,'alive_days',true);
		$uts['start']      =    strtotime( $start );
		$uts['end']        =    mktime(0,0,0,date('m',strtotime($start)),date('d',strtotime($start))+$alive_days,date('Y',strtotime($start)));
	
		$post_days = gregoriantojd(date('m'), date('d'), date('Y')) - gregoriantojd(date('m',strtotime($start)), date('d',strtotime($start)), date('Y',strtotime($start)));
		$days = $alive_days-$post_days;
	
		if($days>0)
		{
			return $days;	
		}else{
			return( false );
		}
	}
}
function category_listing($linkparam = '')
{
	global $wpdb;
	$catsql = "select c.term_id, c.name from $wpdb->terms c,$wpdb->term_taxonomy tt  where tt.term_id=c.term_id and tt.taxonomy='category' and count>0 order by c.name";
	$catinfo = $wpdb->get_results($catsql);
	if($_REQUEST['jtype'])
	{
		$linkparam1 = 'jtype='.$_REQUEST['jtype'];
	}else
	{
		$linkparam1 = 'jtype=all';
	}
	
	if($catinfo)
	{
		$counter = 0;
		foreach($catinfo as $catinfo_obj)
		{
			$counter++;
			$termid = $catinfo_obj->term_id;
			$name = $catinfo_obj->name;
			$linkparam = $linkparam1 . '&catid='.$termid;
			?>
			<?php /*?> <li class="cat-item cat-item-5"><a title="View all posts filed under All" href="<?php echo get_option('siteurl');?>/?<?php echo $linkparam; ?>"><?php echo $name; ?></a></li><?php */?>
            <li class="cat-item cat-item-5"><a title="View all posts filed under All" href="javascript:void(0);" onclick="categorywiselisting('<?php echo $termid;?>');"><?php echo $name; ?></a></li>
			<?php
			//get_category_link( $category_id )
		}
		?>
    <form method="post" name="jobbycategory_frm" action="<?php echo get_option('siteurl');?>/?<?php echo $linkparam1; ?>">
    <input type="hidden" name="catid" value="" id="job_search_by_catid" /></form>
    <script>function categorywiselisting(catid){document.getElementById('job_search_by_catid').value = catid; document.jobbycategory_frm.submit();}</script>
    <?php
	}
}
// Exclude Categories by Name
function category_exclude() {
	$options[] = array(	"type" => "wraptop");						
	
	global $wpdb;
								
	$cats = $wpdb->get_results("SELECT $wpdb->terms.name as name, $wpdb->term_taxonomy.count as count, $wpdb->terms.term_id as cat_ID 
	                            FROM $wpdb->term_taxonomy,  $wpdb->terms
                                WHERE $wpdb->term_taxonomy.term_id =  $wpdb->terms.term_id
                                AND $wpdb->term_taxonomy.taxonomy = 'category'
								ORDER BY name");

	
	$cat_arr = array();
	$cat_arr[''] = 'Select Category';
	foreach ($cats as $cat) {	
	  
	  $cat_arr[] = $cat->name;
	}	
	return $cat_arr;
}

function get_category_by_cat_name($catname)
{
	if($catname)
	{
		global $wpdb;
		return $wpdb->get_var("SELECT $wpdb->terms.term_id FROM $wpdb->terms WHERE $wpdb->terms.name = \"$catname\"");
	}
}

function get_discount_amount($coupon,$amount)
{
	global $wpdb;
	if($coupon!='' && $amount>0)
	{
		$couponsql = "select option_value from $wpdb->options where option_name='discount_coupons'";
		$couponinfo = $wpdb->get_results($couponsql);
		if($couponinfo)
		{
			foreach($couponinfo as $couponinfoObj)
			{
				$option_value = unserialize($couponinfoObj->option_value);
				foreach($option_value as $key=>$value)
				{
					$start_date = strtotime($value['startdate']);
					$end_date = strtotime($value['enddate']);
					$todays_date = strtotime(date("Y-m-d"));
					if ($start_date <= $todays_date && $end_date >= $todays_date)
					 {
						if($value['couponcode'] == $coupon)
						{
							if($value['dis_per']=='per')
							{
								$discount_amt = ($amount*$value['dis_amt'])/100;
							}else
							if($value['dis_per']=='amt')
							{
								$discount_amt = $value['dis_amt'];
							}
						}
					 }
				}
			}
			return $discount_amt;
		}
	}
	return false;			
}


function get_post_info($pid)
{
	if($pid)
	{
		global $wpdb;
		$productinfosql = "select * from $wpdb->posts where ID=$pid";
		$productinfo = $wpdb->get_results($productinfosql);
		foreach($productinfo[0] as $key=>$val)
		{
			$productArray[$key] = $val; 
		}
		return $productArray;
	}
}

function _cat_rows1( $parent = 0, $level = 0, $categories, &$children, $page = 1, $per_page = 20, &$count )
{
	//global $category_array;
	$start = ($page - 1) * $per_page;
	$end = $start + $per_page;
	ob_start();

	foreach ( $categories as $key => $category ) 
	{
		if ( $count >= $end )
			break;

		$_GET['s']='';
		if ( $category->parent != $parent && empty($_GET['s']) )
			continue;

		// If the page starts in a subtree, print the parents.
		if ( $count == $start && $category->parent > 0 ) {
			$my_parents = array();
			$p = $category->parent;
			while ( $p ) {
				$my_parent = get_category( $p );
				$my_parents[] = $my_parent;
				if ( $my_parent->parent == 0 )
					break;
				$p = $my_parent->parent;
			}

			$num_parents = count($my_parents);
			while( $my_parent = array_pop($my_parents) ) {
				$category_array[] = _cat_rows1( $my_parent, $level - $num_parents );
				$num_parents--;
			}
		}

		if ($count >= $start)
		{
			$categoryinfo = array();
			$category = get_category( $category, '', '' );
			$default_cat_id = (int) get_option( 'default_category' );
			$pad = str_repeat( '&#8212; ', max(0, $level) );
			$name = ( $name_override ? $name_override : $pad . ' ' . $category->name );
			$categoryinfo['ID'] = $category->term_id;
			$categoryinfo['name'] = $name;
			$category_array[] = $categoryinfo;
		}

		unset( $categories[ $key ] );
		$count++;
		if ( isset($children[$category->term_id]) )
			_cat_rows1( $category->term_id, $level + 1, $categories, $children, $page, $per_page, $count );
	}
	$output = ob_get_contents();
	ob_end_clean();
	return $category_array;
}
		
function getCategoryList( $parent = 0, $level = 0, $categories = 0, $page = 1, $per_page = 1000 ) 
{
	$count = 0;
	if ( empty($categories) ) 
	{
		$args = array('hide_empty' => 0,'orderby'=>'id');
			
		$categories = get_categories( $args );
		if ( empty($categories) )
			return false;
	}		
	$children = _get_term_hierarchy('category');
	return _cat_rows1( $parent, $level, $categories, $children, $page, $per_page, $count );
}
function get_sub_categories($parentid,$return_type='array')
{
	$cat_arr = array();
	$catarr = getCategoryList($parentid);
	if($catarr)
	{
		foreach($catarr as $key=>$val)
		{
			$cat_arr[] = $val['ID'];
		}
	}	
	$cat_arr[0] = $parentid;
	if($return_type=='array')
	{
		return $cat_arr;
	}else
	{
		return implode(',',$cat_arr);
	}
}

function custom_list_authors($args = '',$params = array()) {
	global $wpdb,$posts_per_page, $paged;
	if($paged<=0)
	{
		$paged = 1;
	}
	if($params['pagination'])
	{
		$paged = 1;
	}
	if($params['show_count'])
	{
		$posts_per_page = $params['show_count'];
	}
	$startlimit = ($paged-1)*$posts_per_page;
	$endlimit = $paged*$posts_per_page;
	$defaults = array(
		'optioncount' => false, 'exclude_admin' => true,
		'show_fullname' => false, 'hide_empty' => true,
		'feed' => '', 'feed_image' => '', 'feed_type' => '', 'echo' => true,
		'style' => 'list', 'html' => true
	);

	$r = wp_parse_args( $args, $defaults );
	extract($r, EXTR_SKIP);
	$return = '';
	
	global $table_prefix, $wpdb;
	$capabilities = "wp_capabilities";
	$capabilities2 = $table_prefix."capabilities";
	if ( is_multisite() ){
	$sub_sql = "select user_id from $wpdb->usermeta where (meta_key like \"$capabilities2\" and meta_value like \"%agent%\")";
	}else{
	$sub_sql = "select user_id from $wpdb->usermeta where (meta_key like \"$capabilities\" and meta_value like \"%agent%\") OR (meta_key like \"$capabilities2\" and meta_value like \"%agent%\")";

	}
		$sql = "select u.* from $wpdb->users u where u.ID in ($sub_sql) ";
	if($params['sort']=='alpha')
	{
		if($_REQUEST['kw'])
		{
			$kw = $_REQUEST['kw'];
		}else
		{
			$kw = 'a';	
		}
		$sql .= " and u.display_name like \"$kw%\" ";	
	}
	if($params['sort']=='most')
	{
		$sql .= " ORDER BY (select count(p.ID) from $wpdb->posts p where u.ID=p.post_author and p.post_status='publish') desc ";	
	}
	else
	{
		$sql .= " ORDER BY display_name ";	
	}
	$sql .= " limit $startlimit,$posts_per_page";
	
	$authors = $wpdb->get_results($sql);
	$return_arr = array();
	foreach ( (array) $authors as $author ) 
	{
		$return_arr[] = get_userdata( $author->ID );
	}	
	return $return_arr;
}
function get_max_number_of_bathroom()
{
	global $wpdb;
	return $wpdb->get_var("select max(meta_value) from $wpdb->postmeta where meta_key='bath_rooms'");
}

/**-- Fecth all the enabled payment options from backend BOF --**/
function get_payment_optins($method)
{
	global $wpdb;
	$paymentsql = "select * from $wpdb->options where option_name like 'payment_method_$method'";
	$paymentinfo = $wpdb->get_results($paymentsql);
	if($paymentinfo)
	{
		foreach($paymentinfo as $paymentinfoObj)
		{
			$option_value = unserialize($paymentinfoObj->option_value);
			$paymentOpts = $option_value['payOpts'];
			$optReturnarr = array();
			for($i=0;$i<count($paymentOpts);$i++)
			{
				$optReturnarr[$paymentOpts[$i]['fieldname']] = $paymentOpts[$i]['value'];
			}
			//echo "<pre>";print_r($optReturnarr);
			return $optReturnarr;
		}
	}
}
/**-- Fecth all the enabled payment options from backend EOF --**/

/** - Set the status(draft,published) of jobs/resume while user listing the post BOF - **/
function set_property_status($pid,$status='publish')
{
	if($pid)
	{
		global $wpdb;
		$wpdb->query("update $wpdb->posts set post_status=\"$status\" where ID=\"$pid\"");
	}
}
/** - Set the status(draft,published) of jobs/resume while user listing the post EOF - **/

function get_usernumposts_count($userid,$post_status='publish')
{
	global $wpdb;
	if($userid)
	{
		$propertycat = get_cat_id_from_name(get_option('ptthemes_propertycategory'));
		$propertycatcatids = get_sub_categories($propertycat,'string');
		
		$ptthemes_featuredcategory = get_cat_id_from_name(get_option('ptthemes_featuredcategory'));
		$feapropertycatcatids = get_sub_categories($ptthemes_featuredcategory,'string');
		if($feapropertycatcatids!='' && $propertycatcatids!='')
		{
			$propertycatcatids .= ','.$feapropertycatcatids;
		}else
		{
			$propertycatcatids = $feapropertycatcatids;	
		}
		if($propertycatcatids)
		{
			$srch_blog_pids = $wpdb->get_var("SELECT group_concat(tr.object_id) FROM $wpdb->term_taxonomy tt join $wpdb->term_relationships tr on tr.term_taxonomy_id=tt.term_taxonomy_id where tt.term_id in ($propertycatcatids)");
			if($srch_blog_pids)
			{
				$sub_cat_sql .= " and p.ID in ($srch_blog_pids) ";
			}
		}

		$srch_sql = "select count(p.ID) from $wpdb->posts p where  p.post_author=\"$userid\" and p.post_type='property'  ";
		if($post_status=='all')
		{
			$srch_sql .= " and p.post_status in ('publish','draft')";
		}else
		if($post_status=='publish')
		{
			$srch_sql .= " and p.post_status in ('publish')";
		}
		else
		if($post_status=='draft')
		{
			$srch_sql .= " and p.post_status in ('draft')";
		}

		echo $totalpost_count = $wpdb->get_var($srch_sql);	
	}

}

function get_payable_amount_with_coupon($total_amt,$coupon_code)
{
	$discount_amt = get_discount_amount($coupon_code,$total_amt);
	if($discount_amt>0)
	{
		return $total_amt-$discount_amt;
	}else
	{
		return $total_amt;
	}
}

function is_allow_ssl()
{
	global $wpdb;
	$option_value = get_option('ptthemes_is_allow_ssl');
	if($option_value == 'Yes')
	{
		return true;
	}else
	{
		return false;
	}
	
}
function get_ssl_normal_url($url,$pid='')
{
	if($pid)
	{
		return $url;
	}else
	{
		if(is_allow_ssl())
		{
			$url = str_replace('http://','https://',$url);
		}
	}
	return $url;
}

function get_user_nice_name($fname,$lname='')
{
	global $wpdb;
	if($lname)
	{
		$uname = $fname.'-'.$lname;
	}else
	{
		$uname = $fname;
	}

	$nicename = strtolower(str_replace(array("'",'"',"?",".","!","@","#","$","%","^","&","*","(",")","-","+","+"," "),array('','','','-','','-','-','','','','','','','','','','-','-',''),$uname));
	$nicenamecount = $wpdb->get_var("select count(user_nicename) from $wpdb->users where user_nicename like \"$nicename\"");
	if($nicenamecount=='0')
	{
		return trim($nicename);
	}else
	{
		$lastuid = $wpdb->get_var("select max(ID) from $wpdb->users");
		return $nicename.'-'.$lastuid;
	}
}

function get_blog_sub_cats_str($type='array'){
		$catid = get_option('ptthemes_blogcategory');
		$catid_arr[] = get_cat_ID( $catid);
		$blogcatids = '';
		$subcatids_arr = array();
		for($i=0;$i<count($catid_arr);$i++)
		{
			if($catid_arr[$i])
			{
				$subcatids_arr = array_merge($subcatids_arr,array($catid_arr[$i]),get_term_children( $catid_arr[$i],'category'));
			}
		}
		if($subcatids_arr && $type=='string')
		{
			$blogcatids = implode(',',$subcatids_arr);
			return $blogcatids;	
		}else
		{
			return $subcatids_arr;
		}			
}
	
/**--- Function : Count/fetch the daily views and total views BOF--**/
function view_counter($pid){
		if($_SERVER['HTTP_REFERER'] == '' || !strstr($_SERVER['HTTP_REFERER'],$_SERVER['REQUEST_URI']))
		{
		$viewed_count = get_post_meta($pid,'viewed_count',true);
		$viewed_count_daily = get_post_meta($pid,'viewed_count_daily',true);
		$daily_date = get_post_meta($pid,'daily_date',true);

		update_post_meta($pid,'viewed_count',$viewed_count+1);

		if(get_post_meta($pid,'daily_date',true) == date('Y-m-d')){
			update_post_meta($pid,'viewed_count_daily',$viewed_count_daily+1);
		} else {
			update_post_meta($pid,'viewed_count_daily','1');
		}
		update_post_meta($pid,'daily_date',date('Y-m-d'));
		}
	}
	function user_post_visit_count($pid)
	{
		if(get_post_meta($pid,'viewed_count',true))
		{
			return get_post_meta($pid,'viewed_count',true);
		}else
		{
			return '0';	
		}
	}
	function user_post_visit_count_daily($pid)
	{
		if(get_post_meta($pid,'viewed_count_daily',true))
		{
			return get_post_meta($pid,'viewed_count_daily',true);
		}else
		{
			return '0';	
		}
	}
/**--- Function : Count/fetch the daily views and total views EOF--**/

	function templ_get_date_format()
	{
		return templ_date_format();
	}
	
	function templ_date_format()
	{
		$date_format = get_option('date_format');
		if(!$date_format){$date_format = get_option('date_format');}
		if(!$date_format){$date_format = 'M j, Y';}
		return apply_filters('templ_date_formate_filter',$date_format);
	}

	function remove_post_custom_fields() {
		remove_meta_box( 'postcustom' , 'job' , 'normal' ); 
		remove_meta_box( 'postcustom' , 'resume' , 'normal' ); 
	}
	add_action( 'admin_menu' , 'remove_post_custom_fields' );
	
    /**-- Function to calculate hot properties BOF --**/

/* Paginaton start BOF
   Function that performs a Boxed Style Numbered Pagination (also called Page Navigation).
   Function is largely based on Version 2.4 of the WP-PageNavi plugin */
function pagenavi($before = '', $after = '') {
    global $wpdb, $wp_query;
	
    $pagenavi_options = array();
   // $pagenavi_options['pages_text'] = ('Page %CURRENT_PAGE% of %TOTAL_PAGES%:');
    $pagenavi_options['current_text'] = '%PAGE_NUMBER%';
    $pagenavi_options['page_text'] = '%PAGE_NUMBER%';
    $pagenavi_options['first_text'] = ('First Page');
    $pagenavi_options['last_text'] = ('Last Page');
    $pagenavi_options['next_text'] = '<strong>&raquo;</strong>';
    $pagenavi_options['prev_text'] = '<strong>&laquo;</strong>';
    $pagenavi_options['dotright_text'] = '...';
    $pagenavi_options['dotleft_text'] = '...';
    $pagenavi_options['num_pages'] = 5; //continuous block of page numbers
    $pagenavi_options['always_show'] = 0;
    $pagenavi_options['num_larger_page_numbers'] = 0;
    $pagenavi_options['larger_page_numbers_multiple'] = 5;
 
    if (!is_single()) {
        $request = $wp_query->request;
        $posts_per_page = intval(get_query_var('posts_per_page'));
        $paged = intval(get_query_var('paged'));
        $numposts = $wp_query->found_posts;
        $max_page = $wp_query->max_num_pages;
 
        if(empty($paged) || $paged == 0) {
            $paged = 1;
        }
 
        $pages_to_show = intval($pagenavi_options['num_pages']);
        $larger_page_to_show = intval($pagenavi_options['num_larger_page_numbers']);
        $larger_page_multiple = intval($pagenavi_options['larger_page_numbers_multiple']);
        $pages_to_show_minus_1 = $pages_to_show - 1;
        $half_page_start = floor($pages_to_show_minus_1/2);
        $half_page_end = ceil($pages_to_show_minus_1/2);
        $start_page = $paged - $half_page_start;
 
        if($start_page <= 0) {
            $start_page = 1;
        }
 
        $end_page = $paged + $half_page_end;
        if(($end_page - $start_page) != $pages_to_show_minus_1) {
            $end_page = $start_page + $pages_to_show_minus_1;
        }
        if($end_page > $max_page) {
            $start_page = $max_page - $pages_to_show_minus_1;
            $end_page = $max_page;
        }
        if($start_page <= 0) {
            $start_page = 1;
        }
 
        $larger_per_page = $larger_page_to_show*$larger_page_multiple;
        //round_num() custom function - Rounds To The Nearest Value.
        $larger_start_page_start = (round_num($start_page, 10) + $larger_page_multiple) - $larger_per_page;
        $larger_start_page_end = round_num($start_page, 10) + $larger_page_multiple;
        $larger_end_page_start = round_num($end_page, 10) + $larger_page_multiple;
        $larger_end_page_end = round_num($end_page, 10) + ($larger_per_page);
 
        if($larger_start_page_end - $larger_page_multiple == $start_page) {
            $larger_start_page_start = $larger_start_page_start - $larger_page_multiple;
            $larger_start_page_end = $larger_start_page_end - $larger_page_multiple;
        }
        if($larger_start_page_start <= 0) {
            $larger_start_page_start = $larger_page_multiple;
        }
        if($larger_start_page_end > $max_page) {
            $larger_start_page_end = $max_page;
        }
        if($larger_end_page_end > $max_page) {
            $larger_end_page_end = $max_page;
        }
        if($max_page > 1 || intval($pagenavi_options['always_show']) == 1) {
			 echo $before.'<div class="wp-pagenavi">'."\n";
             $pages_text = str_replace("%CURRENT_PAGE%", number_format_i18n($paged), $pagenavi_options['pages_text']);
            $pages_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pages_text);
			previous_posts_link($pagenavi_options['prev_text']);
       
            if ($start_page >= 2 && $pages_to_show < $max_page) {
                $first_page_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pagenavi_options['first_text']);

                echo '<a href="'.esc_url(get_pagenum_link()).'" class="first" title="'.$first_page_text.'"></a>';
                if(!empty($pagenavi_options['dotleft_text'])) {
                    echo '<span class="expand">'.$pagenavi_options['dotleft_text'].'</span>';
                }
            }
 
            if($larger_page_to_show > 0 && $larger_start_page_start > 0 && $larger_start_page_end <= $max_page) {
                for($i = $larger_start_page_start; $i < $larger_start_page_end; $i+=$larger_page_multiple) {
                    $page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['page_text']);
                    echo '<a href="'.esc_url(get_pagenum_link($i)).'" class="single_page" title="'.$page_text.'">'.$page_text.'</a>';
                }
            }
 
            for($i = $start_page; $i  <= $end_page; $i++) {
                if($i == $paged) {
                    $current_page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['current_text']);
                    echo '<a  class="on">'.$current_page_text.'</a>';
                } else {
                    $page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['page_text']);
                    echo '<a href="'.esc_url(get_pagenum_link($i)).'" class="single_page" title="'.$page_text.'"><strong>'.$page_text.'</strong></a>';
                }
            }
 
            if ($end_page < $max_page) {
                if(!empty($pagenavi_options['dotright_text'])) {
                    echo '<span class="expand">'.$pagenavi_options['dotright_text'].'</span>';
                }
                $last_page_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pagenavi_options['last_text']);

                echo '<a href="'.esc_url(get_pagenum_link($max_page)).'" title="'.$last_page_text.'">'.$max_page.'</a>';

            }
           
            if($larger_page_to_show > 0 && $larger_end_page_start < $max_page) {
                for($i = $larger_end_page_start; $i <= $larger_end_page_end; $i+=$larger_page_multiple) {
                    $page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['page_text']);
                    echo '<a href="'.esc_url(get_pagenum_link($i)).'" class="single_page" title="'.$page_text.'">'.$page_text.'</a>';
                }
            }
          
			 next_posts_link($pagenavi_options['next_text'], $max_page);
			  echo '</div>'.$after."\n";
        }
    }
}
function round_num($num, $to_nearest) {
   /*Round fractions down (http://php.net/manual/en/function.floor.php)*/
   return floor($num/$to_nearest)*$to_nearest;
}
/*--Paginaton start EOF--*/

/**-- Settings for job expiration procedure BOF --**/
global $table_prefix, $wpdb;
$table_name = $table_prefix . "job_expire_session";
$current_date = date('Y-m-d');
if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name)
{
   global $table_prefix, $wpdb,$table_name;
	$sql = 'CREATE TABLE `'.$table_name.'` (
			`session_id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			`execute_date` DATE NOT NULL ,
			`is_run` TINYINT( 4 ) NOT NULL DEFAULT "0"
			) ENGINE = MYISAM ;';
   mysql_query($sql);
}
$today_executed = $wpdb->get_var("select session_id from $table_name where execute_date=\"$current_date\"");
if($today_executed && $today_executed<0){
}else{ 
		if(get_option('listing_email_notification') != ""){
			$number_of_grace_days = get_option('listing_email_notification');
			$postid_str = $wpdb->get_results("select p.ID,p.post_author,p.post_date, p.post_title from $wpdb->posts p where (p.post_type='job') and p.post_status='publish' and datediff(\"$current_date\",date_format(p.post_date,'%Y-%m-%d')) = (select meta_value from $wpdb->postmeta pm where post_id=p.ID  and meta_key='alive_days')-$number_of_grace_days");
			
			foreach($postid_str as $postid_str_obj)
			{
				
				$ID = $postid_str_obj->ID;
				$auth_id = $postid_str_obj->post_author;
				$post_author = $postid_str_obj->post_author;
				$post_date = date('dS m,Y',strtotime($postid_str_obj->post_date));
				$post_title = $postid_str_obj->post_title;
				$userinfo = $wpdb->get_results("select user_email,display_name,user_login from $wpdb->users where ID=\"$auth_id\"");
				
				$user_email = $userinfo[0]->user_email;
				$display_name = $userinfo[0]->display_name;
				$user_login = $userinfo[0]->user_login;
				
				$fromEmail = get_site_emailId();
				$fromEmailName = get_site_emailName();
				$store_name = get_option('blogname');
				$alivedays = get_post_meta($ID,'alive_days',true);
				$productlink = get_permalink($ID);
				$loginurl = site_url().'/?ptype=login';
				$siteurl = site_url();
				$client_message = __("<p>Dear $display_name,<p><p>Your listing -<a href=\"$productlink\"><b>$post_title</b></a> posted on  <u>$post_date</u> for $alivedays days.</p>
				<p>It's going to expiry after $number_of_grace_days day(s). If the listing expire, it will no longer appear on the site.</p>
				<p> If you want to renew, Please login to your member area of our site and renew it as soon as it expire. You may like to login the site from <a href=\"$loginurl\">$loginurl</a>.</p>
				<p>Your login ID is <b>$user_login</b> and Email ID is <b>$user_email</b>.</p>
				<p>Thank you,<br />$store_name.</p>","templatic");				
				$subject = __('Listing expiration Notification','templatic');
				templ_sendEmail($fromEmail,$fromEmailName,$user_email,$display_name,$subject,$client_message,$extra='');
			}
		}
		$postid_str = $wpdb->get_var("select group_concat(p.ID) from $wpdb->posts p where (p.post_type='job') and p.post_status='publish' and datediff(\"$current_date\",date_format(p.post_date,'%Y-%m-%d')) = (select meta_value from $wpdb->postmeta pm where post_id=p.ID  and meta_key='alive_days')");

		if($postid_str)
		{
			$listing_ex_status = get_option('ptthemes_listing_ex_status');
			if($listing_ex_status=='')
			{
				$listing_ex_status = 'draft';	
			}
				
			$wpdb->query("update $wpdb->posts set post_status=\"$listing_ex_status\" where ID in ($postid_str)");
		}

		$wpdb->query("insert into $table_name (execute_date,is_run) values (\"$current_date\",'1')");	
}
/**-- Settings for job expiration procedure EOF --**/

/**-- Function to fecth categories of custom taxonomies BOF --**/
function wp_list_categories_custom( $args = '' ) {
	$defaults = array(
		'show_option_all' => '', 'orderby' => 'name',
		'order' => 'ASC', 'show_last_update' => 0,
		'style' => 'list', 'show_count' => 0,
		'hide_empty' => 1, 'use_desc_for_title' => 1,
		'child_of' => 0, 'feed' => '', 'feed_type' => '',
		'feed_image' => '', 'exclude' => '', 'exclude_tree' => '', 'current_category' => 0,
		'hierarchical' => true, 'title_li' => __( 'Categories' ),'taxonomy' => 'jcategory',
		'echo' => 1, 'depth' => 0
	);

	$r = wp_parse_args( $args, $defaults );

	if ( !isset( $r['pad_counts'] ) && $r['show_count'] && $r['hierarchical'] ) {
		$r['pad_counts'] = true;
	}

	if ( isset( $r['show_date'] ) ) {
		$r['include_last_update_time'] = $r['show_date'];
	}

	if ( true == $r['hierarchical'] ) {
		$r['exclude_tree'] = $r['exclude'];
		$r['exclude'] = '';
	}

	extract( $r );

	$categories = get_categories( $r );

	$output = '';
	if ( $title_li && 'list' == $style )
			$output = '<li class="categories">' . $r['title_li'] . '<ul>';

	if ( empty( $categories ) ) {
		if ( 'list' == $style )
			$output .= '<li>' . __( "No categories" ) . '</li>';
		else
			$output .= __( "No categories" );
	} else {
		global $wp_query;

		foreach($categories as $key=>$val)
		{
			$termid = $val->term_id;
			$name = $val->name;
			$catlink = get_term_link($val->slug, 'jcategory');
			$output .= '<li class="cat-item cat-item-'.$termid.'"><a href="'.$catlink.'">'. $name .'</a></li>';
		}
	}


	if ( $echo )
		echo $output;
	else
		return $output;
}
/**-- Function to fecth categories of custom taxonomies EOF --**/

/**-- Function to fecth categories of custom taxonomies BOF --**/
function wp_list_categories_resume( $args = '' ) {
	$defaults = array(
		'show_option_all' => '', 'orderby' => 'name',
		'order' => 'ASC', 'show_last_update' => 0,
		'style' => 'list', 'show_count' => 0,
		'hide_empty' => 1, 'use_desc_for_title' => 1,
		'child_of' => 0, 'feed' => '', 'feed_type' => '',
		'feed_image' => '', 'exclude' => '', 'exclude_tree' => '', 'current_category' => 0,
		'hierarchical' => true, 'title_li' => __( 'Categories' ),'taxonomy' => 'rcategory',
		'echo' => 1, 'depth' => 0
	);

	$r = wp_parse_args( $args, $defaults );

	if ( !isset( $r['pad_counts'] ) && $r['show_count'] && $r['hierarchical'] ) {
		$r['pad_counts'] = true;
	}

	if ( isset( $r['show_date'] ) ) {
		$r['include_last_update_time'] = $r['show_date'];
	}

	if ( true == $r['hierarchical'] ) {
		$r['exclude_tree'] = $r['exclude'];
		$r['exclude'] = '';
	}

	extract( $r );

	$categories = get_categories( $r );

	$output = '';
	if ( $title_li && 'list' == $style )
			$output = '<li class="categories">' . $r['title_li'] . '<ul>';

	if ( empty( $categories ) ) {
		if ( 'list' == $style )
			$output .= '<li>' . __( "No categories" ) . '</li>';
		else
			$output .= __( "No categories" );
	} else {
		global $wp_query;

		foreach($categories as $key=>$val)
		{
			$termid = $val->term_id;
			$name = $val->name;
			$catlink = get_term_link($val->slug, 'rcategory');
			$output .= '<li class="cat-item cat-item-'.$termid.'"><a href="'.$catlink.'">'. $name .'</a></li>';
		}
	}


	if ( $echo )
		echo $output;
	else
		return $output;
}
/**-- Function to fecth categories of custom taxonomies EOF --**/


/**-- Upload resume BOF --**/
function get_resume_upload($_FILES)
{
	global $upload_folder_path;
	$imagepath = 'resumes';
	$wp_upload_dir = wp_upload_dir();
	$path = $wp_upload_dir['path'];
	$url = $wp_upload_dir['url'];
	$destination_path = $wp_upload_dir['path'].'/';
	if (!file_exists($destination_path))
	{
		$imagepatharr = explode('/',$upload_folder_path."$imagepath");
		$year_path = ABSPATH;
		for($i=0;$i<count($imagepatharr);$i++)
		{
		  if($imagepatharr[$i])
		  {
			 $year_path .= $imagepatharr[$i]."/";
			  if (!file_exists($year_path)){
				  mkdir($year_path, 0777);
			  }     
			}
		}
	 $imagepatharr = explode('/',$imagepath);
	   $upload_path = ABSPATH . "$upload_folder_path";
	  if (!file_exists($upload_path)){
		mkdir($upload_path, 0777);
	  }
	  for($i=0;$i<count($imagepatharr);$i++)
	  {
		  if($imagepatharr[$i])
		  {
			  $year_path = ABSPATH . "$upload_folder_path".$imagepatharr[$i]."/";
			  if (!file_exists($year_path))
			  {
				  mkdir($year_path, 0777);
			  }     
			  @mkdir($destination_path, 0777);
		}
	  }
	}
	if($_FILES['apply_resume']['name'])
	{
		$srch_arr = array(' ',"'",'"','?','*','!','@','#','$','%','^','&','(',')','+','=');
		$replace_arr = array('_','','','','','','','','','','','','','','','');
		$name = time().'_'.str_replace($srch_arr,$replace_arr,$_FILES['apply_resume']['name']);
		$tmp_name = $_FILES['apply_resume']['tmp_name'];
		$target_path = $destination_path . str_replace(',','',$name);
		if(@move_uploaded_file($tmp_name, $target_path))
		{
			$imagepath1 = $url."/".$name;
			return $imagepath1 = $imagepath1;
		}
	}	
}
/**-- Upload resume EOF --**/

/**-- Function to fetch logo  BOF --**/
function get_company_logo($_FILES)
{
	$imagepath = '';
	$wp_upload_dir = wp_upload_dir();
	$path = $wp_upload_dir['path'];
	$url = $wp_upload_dir['url'];
	$destination_path = $wp_upload_dir['path'].'/';
	
	if (!file_exists($destination_path))
	{
		$imagepatharr = explode('/',$destination_path);
		$year_path = '';
		for($i=0;$i<count($imagepatharr);$i++)
		{
		  if($imagepatharr[$i])
		  {
			 $year_path .= $imagepatharr[$i]."/";
			 
			  if (!file_exists($year_path)){
				  mkdir($year_path, 0777);
			  }     
			}
		}
	}
	if($_FILES['company_logo']['name'])
	{
		$name = time().'_'.$_FILES['company_logo']['name'];
		$tmp_name = $_FILES['company_logo']['tmp_name'];
		$target_path = $destination_path . str_replace(',','',$name);
		if(move_uploaded_file($tmp_name, $target_path)) 
		{
			$imagepath1 = $url."/".$name;
			$upload_path = get_option('upload_path');
			return $imagepath1;
		}
	}	
}

function get_location_dl($location_id)
{
	$location_dl_params = explode(',',get_option('ptthemes_locations'));
	for($i=0;$i<count($location_dl_params);$i++)
	{
		if(trim($location_dl_params[$i]))
		{
			echo '<option ';
			if(trim($location_dl_params[$i])==$location_id)
			{
				echo ' selected="selected" ';
			}
			echo  'value="'. trim($location_dl_params[$i]).'">'. trim($location_dl_params[$i]).'</option>';
		}
	}
}

function get_location_resume($location_id)
{
	$location_dl_params = explode(',',get_option('ptthemes_locations_resume'));
	for($i=0;$i<count($location_dl_params);$i++)
	{
		if(trim($location_dl_params[$i]))
		{
			echo '<option ';
			if(trim($location_dl_params[$i])==$location_id)
			{
				echo ' selected="selected" ';
			}
			echo  'value="'. trim($location_dl_params[$i]).'">'. trim($location_dl_params[$i]).'</option>';
		}
	}
}

/**-- Function to fetch logo  EOF --**/

/**-- Function to check radius search is enabled or not BOF --**/
function is_enable_radius(){
	if(strtolower(get_option('ptttheme_enable_radius_search')) == strtolower('Yes')){
		return true;
	}else{
		return false;
	}
}
/**-- Function to check radius search is enabled or not EOF --**/

/* Get User posts count */

function custom_get_user_posts_count($post_author=null,$post_type=array(),$post_status=array()) {
    global $wpdb;

    if(empty($post_author))
        return 0;

    $post_status = (array) $post_status;
    $post_type = (array) $post_type;

    $sql = $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_author = %d AND ", $post_author );

    //Post status
    if(!empty($post_status)){
        $argtype = array_fill(0, count($post_status), '%s');
        $where = "(post_status=".implode( " OR post_status=", $argtype).') AND ';
        $sql .= $wpdb->prepare($where,$post_status);
    }

    //Post type
    if(!empty($post_type)){
        $argtype = array_fill(0, count($post_type), '%s');
        $where = "(post_type=".implode( " OR post_type=", $argtype).') AND ';
        $sql .= $wpdb->prepare($where,$post_type);
    }

    $sql .='1=1';
    $count = $wpdb->get_results($sql);
	foreach($count as $_count)
	{
		$ID = $_count->ID;
	}
    return $ID;
} 
function is_currentuser_resume($userid)
{
	global $wpdb;
	$resume = $wpdb->get_row("select ID from $wpdb->posts where post_author = '".$userid."' and post_type ='resume'");

	if($resume){ return true;
	}else{ return false;	}
}

function job_application_html($user_id,$post_id)
{
	global $current_user;
	
	$user_meta_data = get_user_meta($current_user->ID,'user_applied_jobs',true);
	if($user_meta_data && in_array($post_id,$user_meta_data))
	{
		?>
	<span id="applied_job_<?php echo $post_id;?>" class="job"> <a href="javascript:void(0);" class="removejob" onclick="javascript:applyForJob('<?php echo $post_id;?>','remove');"><?php _e('Remove Applied','templatic'); ?></a></span>    
		<?php
	}else{
	?>
	<span id="applied_job_<?php echo $post_id;?>" class="job"><a href="javascript:void(0);" class="applyjob"  onclick="javascript:applyForJob(<?php echo $post_id;?>,'add');"><?php echo APPLY_FOR_TEXT;?></a></span>
	<?php } 
}
//This function would add propery to favorite listing and store the value in wp_usermeta table user_favorite field
function apply_for_job($post_id)
{
	if(!get_current_user_id()):
		echo 'Kindly Register as a job seeker from <a href="'.get_option("siteurl").'/?page=register">here</a>';
		exit;
	endif;	
	global $current_user,$post;
	$user_meta_data = array();
	$user_meta_data = get_user_meta($current_user->ID,'user_applied_jobs',true);
	$user_meta_data[]=$post_id;
	update_usermeta($current_user->ID, 'user_applied_jobs', $user_meta_data);
	
	$author_id = $post->post_author;
	$meta_data = get_user_meta($author_id,'user_applied_jobs',true);
	$meta_data[] = $current_user->ID;
	update_usermeta($author_id, 'user_applied_jobs', $meta_data);
	echo '<a href="javascript:void(0);" class="applyjob" onclick="javascript:applyForJob(\''.$post_id.'\',\'remove\');">'.__('Remove application','templatic').'</a>';
	global $post;
	job_application_mail($post_id);
}
//This function would remove the favorited job earlier
function remove_from_job($post_id)
{
	global $current_user,$post;
	$user_meta_data = array();
	$user_meta_data = get_user_meta($current_user->ID,'user_applied_jobs',true);
	if(in_array($post_id,$user_meta_data))
	{
		$user_new_data = array();
		foreach($user_meta_data as $key => $value)
		{
			if($post_id == $value)
			{
				$value= '';
			}else{
				$user_new_data[] = $value;
			}
		}
		$user_meta_data	= $user_new_data;
	}
	update_usermeta($current_user->ID, 'user_applied_jobs', $user_meta_data);
	
	$author_id = $post->post_author;
	$meta_data = get_user_meta($author_id,'user_applied_jobs',true);
	$array_data = array_diff($meta_data,array($current_user->ID));
	update_usermeta($author_id, 'user_applied_jobs', $array_data);
	job_remove_application_mail($post_id);
	echo '<a class="applyjob" href="javascript:void(0);"  onclick="javascript:applyForJob(\''.$post_id.'\',\'add\');">'.APPLY_FOR_TEXT.'</a>';
}

/*-- Function to sent the mail for new job BOF --*/

function job_application_mail($post_id){
		global $current_user,$post,$wpdb;
		$post = $wpdb->get_row("select * from $wpdb->posts where ID = '".$post_id."'");
		$apply_name = $current_user->display_name;
		$apply_email = $current_user->user_email;
		$apply_commnets = get_usermeta($current_user->ID,'description');
		global $wpdb,$current_user;
		$user_id = $current_user->ID;
		$args = array('author'=> $user_id);
		$id = custom_get_user_posts_count($user_id,'resume','publish');
		$attachment = get_post_meta($id,'attachment',true);
		$requesturl = $_SERVER['REQUEST_URI'];
		
		$post_title = $post->post_title;
		$post_id = $post->ID;
		$post_link = get_permalink($post->ID);
		/////SEND RESUME TO EMAIL///
		$site_email_id = get_post_meta($post->ID,'company_email', $single = true);
		$companyname = get_post_meta($post->ID,'company_name', $single = true);
		
		$subject = get_option('job_apply_email_subject');
		if(!$subject){
			$subject = __('Mr/Mrs/Miss').' '.$apply_name. __(" Application for - ").'[#post_title#]';
		}
		
		$subject = str_replace("[#post_title#]",$post_title,$subject);
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'To: '.$companyname.' <'.$site_email_id.'>' . "\r\n";
		//$headers .= 'From: '.$apply_name.' <'.$apply_email.'>' . "\r\n";
		
		$message = get_option('job_apply_email_content');
		if(!$message)
		 {
			$message = "Hello [#companyname#], <br><br>
			<p><b>Online application for the job post - <a href=\"[#post_link#]\" target=\"_blank\">[#post_title#]</a></b></p>
			<p>Applicant Name : [#apply_name#] </p>
			<p>Applicant Email : [#apply_email#] </p>
			<p>Description : [#apply_comments#] </p>";
			if($attachment)
			{
				$message .= "<p>Resume : <a target=\"_blank\" href=\"[#attachment#]\">View Resume</a>   OR   [#attachment#] </p>";
			}
			$message .= "<br>Thank You.";
		 }

		$search_array = array('[#post_link#]','[#post_title#]','[#apply_name#]','[#apply_email#]','[#apply_comments#]','[#attachment#]','[#companyname#]');
		$replace_array = array($post_link,$post_title,$apply_name,$apply_email,nl2br($apply_commnets),$attachment,$companyname);
		$message = str_replace($search_array,$replace_array,$message);
 
		@mail($site_email_id,$subject,$message,$headers);
		//$subject = 'Information received confirmation email';
		//@mail($apply_email,$subject,$message,$headers,$attachments);
}
/*-- Function to sent the mail for new job EOF --*/


function job_remove_application_mail($post_id){

		global $current_user,$post,$wpdb;
		$post = $wpdb->get_row("select * from $wpdb->posts where ID = '".$post_id."'");
		$apply_name = $current_user->display_name;
		$apply_email = $current_user->user_email;
		$apply_commnets = get_usermeta($current_user->ID,'description');
		global $wpdb,$current_user;
		$user_id = $current_user->ID;
		$args = array('author'=> $user_id);
		$id = custom_get_user_posts_count($user_id,'resume','publish');
		$attachment = get_post_meta($id,'attachment',true);
		$requesturl = $_SERVER['REQUEST_URI'];
		
		$post_title = $post->post_title;
		$post_id = $post->ID;
		$post_link = get_permalink($post->ID);
		/////SEND RESUME TO EMAIL///
		$site_email_id = get_post_meta($post->ID,'company_email', $single = true);
		$companyname = get_post_meta($post->ID,'company_name', $single = true);
		
		$subject = get_option('job_apply_email_subject');
		if(!$subject){
			$subject = __('Mr/Mrs/Miss').' '.$apply_name. __(" Application for - ").'[#post_title#]';
		}
		
		$subject = str_replace("[#post_title#]",$post_title,$subject);
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'To: '.$companyname.' <'.$site_email_id.'>' . "\r\n";
		//$headers .= 'From: '.$apply_name.' <'.$apply_email.'>' . "\r\n";
		
		$message = get_option('job_apply_email_content');
		if(!$message)
		 {
			$message = "Hello [#companyname#], <br><br>
			<p><b>[#apply_name#] removed application for the job post - <a href=\"[#post_link#]\" target=\"_blank\">[#post_title#]</a></b></p>
			<p>Applicant Name : [#apply_name#] </p>
			<p>Applicant Email : [#apply_email#] </p>";
			$message .= "<br>Thank You.";
		 }

		$search_array = array('[#post_link#]','[#post_title#]','[#apply_name#]','[#apply_email#]','[#apply_comments#]','[#attachment#]','[#companyname#]');
		$replace_array = array($post_link,$post_title,$apply_name,$apply_email,nl2br($apply_commnets),$attachment,$companyname);
		$message = str_replace($search_array,$replace_array,$message);
 
		@mail($site_email_id,$subject,$message,$headers);
		//$subject = 'Information received confirmation email';
		//@mail($apply_email,$subject,$message,$headers,$attachments);
	
}
/*-- Function to fetch user role BOF --*/
function get_currentuser_role(){
	global $current_user;
	$role =  $current_user->roles[0];
	return $role;
}
/*-- Function to fetch user role EOF --*/

function dashboard_add_edit_form_multipart_encoding() {

    echo ' enctype="multipart/form-data"';

}
add_action('post_edit_form_tag', 'dashboard_add_edit_form_multipart_encoding');

/**-- Function to fetch alivedays of user post --**/

function get_alive_days($cur_user_id){
	global $wpdb;
	
	$qry= "select * from $wpdb->posts p, $wpdb->postmeta pm where p.ID = pm.post_id and p.post_author = '".$cur_user_id."' and (pm.meta_key LIKE '%alive_days%') order by p.post_date desc LIMIT 0,1";
	$adays = $wpdb->get_row($qry);
	
	if($adays){
	$alive_day = $adays->meta_value;
	$publish_date = $adays->post_date;
	$curdate = date('Y-m-d');
	$diff = abs(strtotime($curdate) - strtotime($publish_date));
	$years = floor($diff / (365*60*60*24));
	$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
	$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
	return $days; }
}
/**-- Function to check more alive days or not --**/
function is_more_alive_days($cur_user_id){
	global $wpdb;
	if(strtolower(get_option('ptthemes_package_type')) == strtolower('Pay per subscriptions')){
		if($cur_user_id){
		$qry= "select * from $wpdb->posts p, $wpdb->postmeta pm where p.ID = pm.post_id and p.post_author = '".$cur_user_id."' and (pm.meta_key LIKE '%alive_days%') order by p.post_date desc LIMIT 0,1";
		$adays = $wpdb->get_row($qry);
		if($adays->ID){
		$alive_day = $adays->meta_value;
		$publish_date = $adays->post_date;
		$curdate = date('Y-m-d');
		$diff = abs(strtotime($curdate) - strtotime($publish_date));
		$years = floor($diff / (365*60*60*24));
		$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
		$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
		//echo $alive_day."=".$days;
			if($alive_day >= $days && ($alive_day - $days) == 0){
				return true;
			}else{
				return false;
			}
		}else{
			return true;
		}
		}else{
			return true;
		}
	}else{
		return true;
	}
}

function restirct_admin_area() {
    if( !current_user_can('administrator' )):
        wp_redirect(site_url() );
		exit;
    endif;
}
add_action( 'admin_init', 'restirct_admin_area' );

?>
