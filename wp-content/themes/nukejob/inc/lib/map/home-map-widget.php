<?php
function get_category_home()
{
	global $wpdb;

	$catsql = "select distinct c.term_id, c.* from $wpdb->terms c,$wpdb->term_taxonomy tt where tt.term_id=c.term_id and tt.taxonomy ='".CUSTOM_CATEGORY_TYPE1."' order by c.term_id,c.name";
	$catinfo = $wpdb->get_results($catsql);
	$cat_content_info = array();
	$cat_name_info = array();
	foreach ($catinfo as $catinfo_obj)
	{ 
		global $wpdb;
		$term_id = $catinfo_obj->term_id;
		$name = $catinfo_obj->name;
		$column_term = $wpdb->get_results("SELECT term_icon FROM $wpdb->terms");
		if(isset($catinfo_obj->term_icon) && $catinfo_obj->term_icon != '' && $column_term !=""){
		$term_icon = $catinfo_obj->term_icon;
		}
		$term_parent = $catinfo_obj->parent;
		if(!isset($term_icon))
		{
			$term_icon = get_bloginfo('template_directory').'/library/map/icons/pin.png';
		}
		if($term_id)
		{
			$content_data = array();
			$my_post_type = CUSTOM_POST_TYPE1;

			$sql = "select p.* from $wpdb->posts p where p.post_type = \"$my_post_type\" and p.post_status = 'publish' and p.ID in (select tr.object_id from $wpdb->term_relationships tr join $wpdb->term_taxonomy t on t.term_taxonomy_id=tr.term_taxonomy_id where t.term_id=\"$term_id\" )";
		
			$postinfo = $wpdb->get_results($sql);
		
			$data_arr = array();
			if($postinfo)
			{ 
				$srcharr = array("'");
				$replarr = array("\'");
				foreach($postinfo as $postinfo_obj)
				{
					$ID = $postinfo_obj->ID;
					$title = str_replace($srcharr,$replarr,($postinfo_obj->post_title));
					$plink = get_permalink($postinfo_obj->ID);
					$lat = get_post_meta($ID,'geo_latitude',true);
					$lng = get_post_meta($ID,'geo_longitude',true);
					$address = str_replace($srcharr,$replarr,(get_post_meta($ID,'address',true)));
					$contact = str_replace($srcharr,$replarr,(get_post_meta($ID,'contact',true)));
					$timing = str_replace($srcharr,$replarr,(get_post_meta($ID,'timing',true)));
					
					$pimgarr =  bdw_get_images_with_info($ID,'thumb');				
					$attachment_id = $pimgarr[0]['id'];
					$alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
					$attach_data = get_post($attachment_id);
					$ititle = str_replace($srcharr,$replarr,$attach_data->post_title);
					if($ititle ==''){ $ititle = str_replace($srcharr,$replarr,$postinfo_obj->post_title); }
					if($alt ==''){ $alt = str_replace($srcharr,$replarr,$postinfo_obj->post_title); }
	

					$post_img = bdw_get_images_with_info($postinfo_obj->ID,'thumb');
					$thumb = $post_img[0]['file'];
					$attachment_id = $post_img[0]['id'];
					$attach_data = get_post($attachment_id);
					$img_title = $attach_data->post_title;
					$img_alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
					if($img_title ==''){ $img_title = $postinfo_obj->post_title; }
					if($img_alt ==''){ $img_alt = $postinfo_obj->post_title; }
	  
					if($thumb ==''){
					$thumb = get_template_directory_uri()."/images/no-image.png";
					}

				 	$pimg = get_post_meta($ID,'company_logo',$single=true);
					if(!$pimg):
						$pimg = get_template_directory_uri()."/images/no-image.png";
					endif;	
					$more = VIEW_MORE_DETAILS_TEXT;
					$price = get_property_price($ID);

					if($lat && $lng)
					{ 
						$retstr ="{";
						$retstr .= "'name':'$title',";
						$retstr .= "'location': [$lat,$lng],";
						$retstr .= "'message':'<div class=\"forrent\"><img src=\"$pimg\" width=\"140\" height=\"140\" alt=\"\" />";
						$retstr .= "<h6><a href=\"$plink\" class=\"ptitle\" style=\"color:#444444;font-size:14px;\"><span>$title</span></a></h6>";
						if($address){$retstr .= "<span style=\"font-size:10px;\">$address</span>";}
						$retstr .= "<p class=\"link-style1\"><a href=\"$plink\" class=\"ptitle\">$more</a></p>";
						$retstr .= "',";
						$retstr .= "'icons':'$term_icon',";
						$retstr .= "'pid':'$ID'";
						$retstr .= "}";
						$content_data[] = $retstr;

					}
				}
				if($content_data)
				{
					$arrsrch = array("'");
					$arrrep = array('');
					$catname = strtolower(str_replace($arrsrch,$arrrep,$name));
					$cat_content_info[]= "'$catname':[".implode(',',$content_data)."]";
					$cat_name_info[] = array($name,$catname,$term_icon,$term_parent);
				}
			}			
		}		
	}
	if($cat_content_info)
	{
		return array($cat_name_info,implode(',',$cat_content_info),$term_parent);
		//return $term_parent;
	}
}

	$width = 947;
	$heigh = 425;
	$catarr = get_category_home();
	$catname_arr = $catarr[0];
	$catinfo_arr = $catarr[1];
	?>

<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/library/map/markermanager.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/library/map/markerclusterer_packed.js"></script>
<script type="text/javascript">
/* <![CDATA[ */
<?php
if(get_option('ptthemes_zoom_level')){
$mapzoom = 	get_option('ptthemes_zoom_level');
}
else
{
$mapzoom = 0;	
}
if(get_option('ptthemes_map_latitude')){
$ma_lat = get_option('ptthemes_map_latitude');
}else{
$ma_lat = 20;
}
if(get_option('ptthemes_map_longitude')){
$ma_long = get_option('ptthemes_map_longitude');
}else{
$ma_long = 0;
}
?>
var CITY_MAP_CENTER_LAT= '<?php echo $ma_lat; ?>';
var CITY_MAP_CENTER_LNG= '<?php echo $ma_long; ?>';
var CITY_MAP_ZOOMING_FACT= <?php echo $mapzoom; ?>;
<?php if(get_option('pttthemes_maptype') != '') { 
$maptype = get_option('pttthemes_maptype');
} else { 
$maptype = 'ROADMAP';
}
if(get_option('ptthemes_map_display') == 'Fit all available listing') { 
$fmaptype = 1;
} else { 
$fmaptype = 0;
} ?>
var zoom_option = '<?php echo $fmaptype; ?>';
var infowindow;
<?php if($fmaptype == 1) { ?>
 var multimarkerdata = new Array();
<?php } ?>
/**
 * Data for the markers consisting of a name, a LatLng and a pin image, message box content for
 * the order in which these markers should display on top of each
 * other.
 */
var markers = {<?php echo $catinfo_arr;?>};

var map = null;
var mgr = null;
var mc = null;
var markerClusterer = null;
var showMarketManager = false;

if(CITY_MAP_CENTER_LAT=='')
{
	var CITY_MAP_CENTER_LAT = 34;	
}
if(CITY_MAP_CENTER_LNG=='')
{
	var CITY_MAP_CENTER_LNG = 0;	
}
if(CITY_MAP_CENTER_LAT!='' && CITY_MAP_CENTER_LNG!='' && CITY_MAP_ZOOMING_FACT =='')
{
	var CITY_MAP_ZOOMING_FACT = 13;
}else if(CITY_MAP_ZOOMING_FACT == '')
{
	var CITY_MAP_ZOOMING_FACT = 3;
} 
var PIN_POINT_ICON_HEIGHT = 32;
var PIN_POINT_ICON_WIDTH = 20;

if(MAP_DISABLE_SCROLL_WHEEL_FLAG)
{
	var MAP_DISABLE_SCROLL_WHEEL_FLAG = 'No';	
}


function setCategoryVisiblity( category, visible ) {
   var i;
   if ( mgr && category in markers ) {
      for( i = 0; i < markers[category].length; i += 1 ) {
         if ( visible ) {
            mgr.addMarker( markers[category][i], 0 );
         } else {
            mgr.removeMarker( markers[category][i], 0 );
         }
      }
      mgr.refresh();
   }
}

function initialize() {
  var myOptions = {
    zoom: CITY_MAP_ZOOMING_FACT,
    center: new google.maps.LatLng(CITY_MAP_CENTER_LAT, CITY_MAP_CENTER_LNG),
    mapTypeId: google.maps.MapTypeId.<?php echo $maptype;?>
  }
   map = new google.maps.Map(document.getElementById("map_canvas"),myOptions);
   mgr = new MarkerManager( map );
   google.maps.event.addListener(mgr, 'loaded', function() {
      if (markers) {
         for (var level in markers) {
            google.maps.event.addDomListener( document.getElementById( level ), 'click', function() {
               setCategoryVisiblity( this.id, this.checked );
            });
            for (var i = 0; i < markers[level].length; i++) {
		
               var details = markers[level][i];
               var image = new google.maps.MarkerImage(details.icons,new google.maps.Size(PIN_POINT_ICON_WIDTH, PIN_POINT_ICON_HEIGHT));
               var myLatLng = new google.maps.LatLng(details.location[0], details.location[1]);
			   <?php if($fmaptype == 1) { ?>
			     multimarkerdata[i]  = new google.maps.LatLng(details.location[0], details.location[1]);
			   <?php } ?>
               markers[level][i] = new google.maps.Marker({
                  title: details.name,
                  position: myLatLng,
                  icon: image,
                  clickable: true,
                  draggable: false,
                  flat: true
               });
               
            attachMessage(markers[level][i], details.message);
            }
            mgr.addMarkers( markers[level], 0 );
         }
		  <?php if($fmaptype == 1) { ?>
			 var latlngbounds = new google.maps.LatLngBounds();
			for ( var j = 0; j < multimarkerdata.length; j++ )
			    {
				 latlngbounds.extend( multimarkerdata[ j ] );
			    }
			   map.fitBounds( latlngbounds );
		  <?php } ?>
         mgr.refresh();
      }
   });
   
	// but that message is not within the marker's instance data 
	function attachMessage(marker, msg) {
	  var myEventListener = google.maps.event.addListener(marker, 'click', function() {
		 if (infowindow) infowindow.close();
		infowindow = new google.maps.InfoWindow(
		  { content: String(msg) 
		  });
         infowindow.open(map,marker);
      });
	}
	
}

google.maps.event.addDomListener(window, 'load', initialize);
/* ]]> */
</script>
<div class="top_banner_section_in clearfix">
        <div id="map_canvas" style="width: 100%; height:<?php echo $heigh;?>px" class="map_canvas"></div>
        <?php if($catname_arr){  ?>
        <div class="map_category" id="toggleID">
        <?php for($c=0;$c<count($catname_arr);$c++){ ?>
         <label><input type="checkbox" value="<?php echo str_replace("&",'&amp;',$catname_arr[$c][1]);?>" checked="checked" id="<?php echo str_replace("&",'&amp;',$catname_arr[$c][1]);?>" name="<?php echo str_replace("&",'&amp;',$catname_arr[$c][1]);?>"><img height="14" width="8" alt="" src="<?php echo $catname_arr[$c][2];?>"> <?php echo $catname_arr[$c][0];?></label>
 
		<?php }?>
        </div>
		<div id="toggle" class="toggleoff" onclick="toggle();"></div>
        <?php }?>
</div>
