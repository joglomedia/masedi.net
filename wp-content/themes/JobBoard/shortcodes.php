<?php
function st_one_third( $atts, $content = null ) {
   return '<div class="one_third">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_third', 'st_one_third');

function st_one_third_last( $atts, $content = null ) {
   return '<div class="one_third last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}
add_shortcode('one_third_last', 'st_one_third_last');

function st_two_thirds( $atts, $content = null ) {
   return '<div class="two_thirds">' . do_shortcode($content) . '</div>';
}
add_shortcode('two_thirds', 'st_two_thirds');

function st_two_thirds_last( $atts, $content = null ) {
   return '<div class="two_thirds last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}
add_shortcode('two_thirds_last', 'st_two_thirds_last');

// Shortcodes - Messages -------------------------------------------------------- //
function message_download( $atts, $content = null ) {
   return '<p class="download">' . $content . '</p>';
}
add_shortcode( 'Download', 'message_download' );

function message_alert( $atts, $content = null ) {
   return '<p class="alert">' . $content . '</p>';
}
add_shortcode( 'Alert', 'message_alert' );

function message_note( $atts, $content = null ) {
   return '<p class="note">' . $content . '</p>';
}
add_shortcode( 'Note', 'message_note' );


function message_info( $atts, $content = null ) {
   return '<p class="info">' . $content . '</p>';
}
add_shortcode( 'Info', 'message_info' );


// Shortcodes - About Author -------------------------------------------------------- //

function about_author( $atts, $content = null ) {
   return '<div class="about_author">' . $content . '</p></div>';
}
add_shortcode( 'Author Info', 'about_author' );


function icon_list_view( $atts, $content = null ) {
   return '<div class="check_list">' . $content . '</p></div>';
}
add_shortcode( 'Icon List', 'icon_list_view' );


// Shortcodes - Boxes -------------------------------------------------------- //

function normal_box( $atts, $content = null ) {
   return '<div class="boxes normal_box">' . $content . '</p></div>';
}
add_shortcode( 'Normal_Box', 'normal_box' );

function warning_box( $atts, $content = null ) {
   return '<div class="boxes warning_box">' . $content . '</p></div>';
}
add_shortcode( 'Warning_Box', 'warning_box' );

function about_box( $atts, $content = null ) {
   return '<div class="boxes about_box">' . $content . '</p></div>';
}
add_shortcode( 'About_Box', 'about_box' );

function download_box( $atts, $content = null ) {
   return '<div class="boxes download_box">' . $content . '</p></div>';
}
add_shortcode( 'Download_Box', 'download_box' );

function info_box( $atts, $content = null ) {
   return '<div class="boxes info_box">' . $content . '</p></div>';
}
add_shortcode( 'Info_Box', 'info_box' );


function alert_box( $atts, $content = null ) {
   return '<div class="boxes alert_box">' . $content . '</p></div>';
}
add_shortcode( 'Alert_Box', 'alert_box' );

// Shortcodes - Small Buttons -------------------------------------------------------- //

function small_button( $atts, $content ) {
 return '<div class="small_button '.$atts['class'].'">' . $content . '</div>';
}
add_shortcode( 'Small_Button', 'small_button' );

//FUNCTION NAME : Related post as per tags
//RETURNS : a search box wrapped in a div

// 1-4 col 

function st_one_half( $atts, $content = null ) {
   return '<div class="one_half">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_half', 'st_one_half');


function st_one_half_last( $atts, $content = null ) {
   return '<div class="one_half last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}
add_shortcode('one_half_last', 'st_one_half_last');


function st_one_fourth( $atts, $content = null ) {
   return '<div class="one_fourth">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_fourth', 'st_one_fourth');


function st_one_fourth_last( $atts, $content = null ) {
   return '<div class="one_fourth last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}
add_shortcode('one_fourth_last', 'st_one_fourth_last');

function st_three_fourths( $atts, $content = null ) {
   return '<div class="three_fourths">' . do_shortcode($content) . '</div>';
}
add_shortcode('three_fourths', 'st_three_fourths');


function st_three_fourths_last( $atts, $content = null ) {
   return '<div class="three_fourths last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}
add_shortcode('three_fourths_last', 'st_three_fourths_last');


function st_one_fifth( $atts, $content = null ) {
   return '<div class="one_fifth">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_fifth', 'st_one_fifth');

function st_two_fifth( $atts, $content = null ) {
   return '<div class="two_fifth">' . do_shortcode($content) . '</div>';
}
add_shortcode('two_fifth', 'st_two_fifth');

function st_three_fifth( $atts, $content = null ) {
   return '<div class="three_fifth">' . do_shortcode($content) . '</div>';
}
add_shortcode('three_fifth', 'st_three_fifth');

function st_four_fifth( $atts, $content = null ) {
   return '<div class="four_fifth">' . do_shortcode($content) . '</div>';
}
add_shortcode('four_fifth', 'st_four_fifth');

//

function st_one_fifth_last( $atts, $content = null ) {
   return '<div class="one_fifth last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}
add_shortcode('one_fifth_last', 'st_one_fifth_last');

function st_two_fifth_last( $atts, $content = null ) {
   return '<div class="two_fifth last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}
add_shortcode('two_fifth_last', 'st_two_fifth_last');

function st_three_fifth_last( $atts, $content = null ) {
   return '<div class="three_fifth last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}
add_shortcode('three_fifth_last', 'st_three_fifth_last');

function st_four_fifth_last( $atts, $content = null ) {
   return '<div class="four_fifth last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}
add_shortcode('four_fifth_last', 'st_four_fifth_last');

// 1-6 col 

// one_sixth
function st_one_sixth( $atts, $content = null ) {
   return '<div class="one_sixth">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_sixth', 'st_one_sixth');

function st_one_sixth_last( $atts, $content = null ) {
   return '<div class="one_sixth last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}
add_shortcode('one_sixth_last', 'st_one_sixth_last');

// five_sixth
function st_five_sixth( $atts, $content = null ) {
   return '<div class="five_sixth">' . do_shortcode($content) . '</div>';
}
add_shortcode('five_sixth', 'st_five_sixth');

function st_five_sixth_last( $atts, $content = null ) {
   return '<div class="five_sixth last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}
add_shortcode('five_sixth_last', 'st_five_sixth_last');

function st_linebreak( $atts, $content = null ) {
	return '<hr /><div class="clear"></div>';
}
add_shortcode('clearline', 'st_linebreak');


// Shortcodes - Boxes - Equal -------------------------------------------------------- //

function normal_box_equal( $atts, $content = null ) {
   return '<div class="boxes normal_box small">' . $content . '</p></div>';
}
add_shortcode( 'Normal_Box_Equal', 'normal_box_equal' );

function warning_box_equal( $atts, $content = null ) {
   return '<div class="boxes warning_box small">' . $content . '</p></div>';
}
add_shortcode( 'Warning_Box_Equal', 'warning_box_equal' );

function about_box_equal( $atts, $content = null ) {
   return '<div class="boxes about_box small">' . $content . '</p></div>';
}
add_shortcode( 'About_Box_Equal', 'about_box' );

function download_box_equal( $atts, $content = null ) {
   return '<div class="boxes download_box small">' . $content . '</p></div>';
}
add_shortcode( 'Download_Box_Equal', 'download_box_equal' );

function info_box_equal( $atts, $content = null ) {
   return '<div class="boxes info_box small">' . $content . '</p></div>';
}
add_shortcode( 'Info_Box_Equal', 'info_box_equal' );


function alert_box_equal( $atts, $content = null ) {
   return '<div class="boxes alert_box small">' . $content . '</p></div>';
}
add_shortcode( 'Alert_Box_Equal', 'alert_box_equal' );


// Shortcodes - Content Columns -------------------------------------------------------- //

function one_half_column( $atts, $content = null ) {
   return '<div class="one_half_column left">' . $content . '</p></div>';
}
add_shortcode( 'One_Half', 'one_half_column' );

function one_half_last( $atts, $content = null ) {
   return '<div class="one_half_column right">' . $content . '</p></div><div class="clear_spacer clearfix"></div>';
}
add_shortcode( 'One_Half_Last', 'one_half_last' );


function one_third_column( $atts, $content = null ) {
   return '<div class="one_third_column left">' . $content . '</p></div>';
}
add_shortcode( 'One_Third', 'one_third_column' );

function one_third_column_last( $atts, $content = null ) {
   return '<div class="one_third_column_last right">' . $content . '</p></div><div class="clear_spacer clearfix"></div>';
}
add_shortcode( 'One_Third_Last', 'one_third_column_last' );


function one_fourth_column( $atts, $content = null ) {
   return '<div class="one_fourth_column left">' . $content . '</p></div>';
}
add_shortcode( 'One_Fourth', 'one_fourth_column' );

function one_fourth_column_last( $atts, $content = null ) {
   return '<div class="one_fourth_column_last right">' . $content . '</p></div><div class="clear_spacer clearfix"></div>';
}
add_shortcode( 'One_Fourth_Last', 'one_fourth_column_last' );


function two_thirds( $atts, $content = null ) {
   return '<div class="two_thirds left">' . $content . '</p></div>';
}
add_shortcode( 'Two_Third', 'two_thirds' );

function two_thirds_last( $atts, $content = null ) {
   return '<div class="two_thirds_last right">' . $content . '</p></div><div class="clear_spacer clearfix"></div>';
}
add_shortcode( 'Two_Third_Last', 'two_thirds_last' );


function dropcaps( $atts, $content = null ) {
   return '<p class="dropcaps">' . $content . '</p>';
}
add_shortcode( 'Dropcaps', 'dropcaps' );

// Callouts

function st_callout( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'width' => '',
		'align' => ''
    ), $atts));
	$style;
	if ($width || $align) {
	 $style .= 'style="';
	 if ($width) $style .= 'width:'.$width.'px;';
	 if ($align == 'left' || 'right') $style .= 'float:'.$align.';';
	 if ($align == 'center') $style .= 'margin:0px auto;';
	 $style .= '"';
	}
   return '<div class="cta" '.$style.'>' . do_shortcode($content) . '</div><div class="clear"></div>';
}
add_shortcode('callout', 'st_callout');



// Buttons
function st_button( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'link' => '',
		'size' => 'medium',
		'color' => '',
		'target' => '_self',
		'caption' => '',
		'align' => 'right'
    ), $atts));	
	$button;
	$button .= '<div class="button '.$size.' '. $align.'">';
	$button .= '<a target="'.$target.'" class="button '.$color.'" href="'.$link.'">';
	$button .= $content;
	if ($caption != '') {
	$button .= '<br /><span class="btn_caption">'.$caption.'</span>';
	};
	$button .= '</a></div>';
	return $button;
}
add_shortcode('button', 'st_button');


// Tabs
add_shortcode( 'tabgroup', 'st_tabgroup' );

function st_tabgroup( $atts, $content ){
	
$GLOBALS['tab_count'] = 0;
do_shortcode( $content );

if( is_array( $GLOBALS['tabs'] ) ){
	
foreach( $GLOBALS['tabs'] as $tab ){
$tabs[] = '<li><a href="#'.$tab['id'].'">'.$tab['title'].'</a></li>';
$panes[] = '<li id="'.$tab['id'].'Tab">'.$tab['content'].'</li>';
}
$return = "\n".'<!-- the tabs --><ul class="tabs">'.implode( "\n", $tabs ).'</ul>'."\n".'<!-- tab "panes" --><ul class="tabs-content">'.implode( "\n", $panes ).'</ul>'."\n";
}
return $return;

}

add_shortcode( 'tab', 'st_tab' );
function st_tab( $atts, $content ){
extract(shortcode_atts(array(
	'title' => '%d',
	'id' => '%d'
), $atts));

$x = $GLOBALS['tab_count'];
$GLOBALS['tabs'][$x] = array(
	'title' => sprintf( $title, $GLOBALS['tab_count'] ),
	'content' =>  do_shortcode($content),
	'id' =>  $id );

$GLOBALS['tab_count']++;
}


// Toggle
function st_toggle( $atts, $content = null ) {
	extract(shortcode_atts(array(
		 'title' => '',
		 'style' => 'list'
    ), $atts));
	output;
	$output .= '<div class="'.$style.'"><p class="trigger"><a href="#">' .$title. '</a></p>';
	$output .= '<div class="toggle_container"><div class="block">';
	$output .= do_shortcode($content);
	$output .= '</div></div></div>';

	return $output;
	}
add_shortcode('toggle', 'st_toggle');


/*-----------------------------------------------------------------------------------*/
// Latest Posts
// Example Use: [latest excerpt="true" thumbs="true" width="50" height="50" num="5" cat="8,10,11"]
/*-----------------------------------------------------------------------------------*/


function st_latest($atts, $content = null) {
	extract(shortcode_atts(array(
	"offset" => '',
	"num" => '5',
	"thumbs" => 'false',
	"excerpt" => 'false',
	"length" => '50',
	"morelink" => '',
	"width" => '100',
	"height" => '100',
	"type" => 'post',
	"parent" => '',
	"cat" => '',
	"orderby" => 'date',
	"order" => 'ASC'
	), $atts));
	global $post;
	
	$do_not_duplicate[] = $post->ID;
	$args = array(
	  'post__not_in' => $do_not_duplicate,
		'cat' => $cat,
		'post_type' => $type,
		'post_parent'	=> $parent,
		'showposts' => $num,
		'orderby' => $orderby,
		'offset' => $offset,
		'order' => $order
		);
	// query
	$myposts = new WP_Query($args);
	
	// container
	$result='<div id="category-'.$cat.'" class="latestposts">';

	while($myposts->have_posts()) : $myposts->the_post();
		// item
		$result.='<div class="latest-item clearfix">';
		// title
		if ($excerpt == 'true') {
			$result.='<h4><a href="'.get_permalink().'">'.the_title("","",false).'</a></h4>';
		} else {
			$result.='<div class="latest-title"><a href="'.get_permalink().'">'.the_title("","",false).'</a></div>';			
		}
		
		
		// thumbnail
		if (has_post_thumbnail() && $thumbs == 'true') {
			$result.= '<img alt="'.get_the_title().'" class="alignleft latest-img" src="'.get_bloginfo('template_directory').'/thumb.php?src='.get_image_path().'&amp;h='.$height.'&amp;w='.$width.'"/>';
		}

		// excerpt		
		if ($excerpt == 'true') {
			// allowed tags in excerpts
			$allowed_tags = '<a>,<i>,<em>,<b>,<strong>,<ul>,<ol>,<li>,<blockquote>,<img>,<span>,<p>';
		 	// filter the content
			$text = preg_replace('/\[.*\]/', '', strip_tags(get_the_excerpt(), $allowed_tags));
			// remove the more-link
			$pattern = '/(<a.*?class="more-link"[^>]*>)(.*?)(<\/a>)/';
			// display the new excerpt
			$content = preg_replace($pattern,"", $text);
			$result.= '<div class="latest-excerpt">'.st_limit_words($content,$length).'</div>';
		}
		
		// excerpt		
		if ($morelink) {
			$result.= '<a class="more-link" href="'.get_permalink().'">'.$morelink.'</a>';
		}
		
		// item close
		$result.='</div>';
  
	endwhile;
		wp_reset_postdata();
	
	// container close
	$result.='</div>';
	return $result;
}
add_shortcode("latest", "st_latest");

// Example Use: [latest excerpt="true" thumbs="true" width="50" height="50" num="5" cat="8,10,11"]

/*-----------------------------------------------------------------------------------*/
// Creates an additional hook to limit the excerpt
/*-----------------------------------------------------------------------------------*/

function st_limit_words($string, $word_limit) {
	// creates an array of words from $string (this will be our excerpt)
	// explode divides the excerpt up by using a space character
	$words = explode(' ', $string);
	// this next bit chops the $words array and sticks it back together
	// starting at the first word '0' and ending at the $word_limit
	// the $word_limit which is passed in the function will be the number
	// of words we want to use
	// implode glues the chopped up array back together using a space character
	return implode(' ', array_slice($words, 0, $word_limit));
}


// Related Posts - [related_posts]
add_shortcode('related_posts', 'st_related_posts');
function st_related_posts( $atts ) {
	extract(shortcode_atts(array(
	    'limit' => '5',
	), $atts));

	global $wpdb, $post, $table_prefix;

	if ($post->ID) {
		$retval = '<div class="st_relatedposts">';
		$retval .= '<h4>Related Posts</h4>';
		$retval .= '<ul>';
 		// Get tags
		$tags = wp_get_post_tags($post->ID);
		$tagsarray = array();
		foreach ($tags as $tag) {
			$tagsarray[] = $tag->term_id;
		}
		$tagslist = implode(',', $tagsarray);

		// Do the query
		$q = "SELECT p.*, count(tr.object_id) as count
			FROM $wpdb->term_taxonomy AS tt, $wpdb->term_relationships AS tr, $wpdb->posts AS p WHERE tt.taxonomy ='post_tag' AND tt.term_taxonomy_id = tr.term_taxonomy_id AND tr.object_id  = p.ID AND tt.term_id IN ($tagslist) AND p.ID != $post->ID
				AND p.post_status = 'publish'
				AND p.post_date_gmt < NOW()
 			GROUP BY tr.object_id
			ORDER BY count DESC, p.post_date_gmt DESC
			LIMIT $limit;";

		$related = $wpdb->get_results($q);
 		if ( $related ) {
			foreach($related as $r) {
				$retval .= '<li><a title="'.wptexturize($r->post_title).'" href="'.get_permalink($r->ID).'">'.wptexturize($r->post_title).'</a></li>';
			}
		} else {
			$retval .= '
	<li>No related posts found</li>';
		}
		$retval .= '</ul>';
		$retval .= '</div>';
		return $retval;
	}
	return;
}

// Break
function st_break( $atts, $content = null ) {
	return '<div class="clear"></div>';
}
add_shortcode('clear', 'st_break');


// Line Break

?>