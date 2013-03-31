<?php
/**
 * Preview Google Map
 */
if(!function_exists('wpnuke_preview_google_map')) {
	function wpnuke_preview_google_map($map_lat, $map_lng, $address, $map_zoom = 15, $map_type = 'ROADMAP') {
		$term_icon = get_bloginfo('template_directory').'/lib/map/icons/pin.png';
		?>
		<script type="text/javascript">
			/* <![CDATA[ */
			jQuery( document ).ready( function (){
			//function initialize() {
				var map = null;
				var geocoder = null;
				var lat = <?php echo $map_lat;?>;
				var lng = <?php echo $map_lng;?>;
				var latLng = new window.google.maps.LatLng(<?php echo $map_lat;?>,<?php echo $map_lng;?>);
				var myOptions = {
					zoom: <?php echo $map_zoom; ?>,
					center: latLng,
					mapTypeId: window.google.maps.MapTypeId.<?php echo $map_type; ?>
				};
				
				map = new window.google.maps.Map( jQuery( '.map-canvas' )[0], myOptions);
			   
				var myLatLng = new window.google.maps.LatLng(<?php echo $map_lat;?>,<?php echo $map_lng;?>);
				var marker = new window.google.maps.Marker({
					position: latLng,
					map: map,
					draggable: true
				});
				var content = '<?php echo $address; ?>';
				infowindow = new window.google.maps.InfoWindow({
					content: content
				});
				
				window.google.maps.event.addListener(marker, 'click', function() {
					infowindow.open(map, marker);
				});
			//}
			});
			
			//window.onload = function () {initialize();}
			/* ]]> */
		</script>
		<div class="map-canvas" id="map-canvas" style="width:100%; height:358px;"></div>
    <?php
    }
}
?>