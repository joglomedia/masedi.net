<?php
if(!function_exists('preview_address_google_map'))
{
    function preview_address_google_map($latitute,$longitute,$address)
    {
	$term_icon = get_bloginfo('template_directory').'/library/map/icons/pin.png';
    ?>
    <script src="http://maps.googleapis.com/maps/api/js?sensor=false" type="text/javascript"></script>
    <script type="text/javascript">
	/* <![CDATA[ */
	function initialize() {	
    var map = null;
    var geocoder = null;
	
    var lat = <?php echo $latitute;?>;
    var lng = <?php echo $longitute;?>;
	var latLng = new google.maps.LatLng(<?php echo $latitute;?>, <?php echo $longitute;?>);
	var myOptions = {
      zoom: 13,
      mapTypeId: google.maps.MapTypeId.ROADMAP,
      center: latLng 
    };
    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
         
   
	var myLatLng = new google.maps.LatLng(<?php echo $latitute;?>, <?php echo $longitute;?>);
	var Marker = new google.maps.Marker({
	  position: latLng,
	  map: map
	});
	var content = '<?php echo $address;?>';
	infowindow = new google.maps.InfoWindow({
	  content: content
	});
	
	google.maps.event.addListener(Marker, 'click', function() {
      infowindow.open(map,Marker);
    });

 }
	window.onload = function () {initialize();}
	/* ]]> */
    </script>
    <div class="map" id="map_canvas" style="width:100%; height:358px;" ></div>
    <?php
    }
}
?>