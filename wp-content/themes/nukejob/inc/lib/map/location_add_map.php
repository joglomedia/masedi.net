<?php
$map_zoom = 15;
$map_lat = '-6.211544';
$map_lng = '106.84517200000005';
$map_type = 'ROADMAP';
?>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false&libraries=places"></script>
<script type="text/javascript">
/* <![CDATA[ */
var map;
var latlng;
var geocoder;
var address;
var lat;
var lng;
var centerChangedLast;
var reverseGeocodedLast;
var currentReverseGeocodeResponse;
var CITY_MAP_CENTER_LAT = <?php echo $map_lat;?>;	
var CITY_MAP_CENTER_LNG = <?php echo $map_lng;?>;	
var CITY_MAP_ZOOMING_FACT = <?php echo $map_zoom;?>;

function initialize() {
var latlng = new google.maps.LatLng(CITY_MAP_CENTER_LAT,CITY_MAP_CENTER_LNG);
var myOptions = {
	zoom: CITY_MAP_ZOOMING_FACT,
	center: latlng,
	mapTypeId: google.maps.MapTypeId.<?php echo $map_type;?>
};
map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
geocoder = new google.maps.Geocoder();
	google.maps.event.addListener(map, 'zoom_changed', function() {
			document.getElementById("zooming_factor").value = map.getZoom();
		});
	setupEvents();
   // centerChanged();
  }

  function setupEvents() {
reverseGeocodedLast = new Date();
centerChangedLast = new Date();
	
setInterval(function() {
  if((new Date()).getSeconds() - centerChangedLast.getSeconds() > 1) {
if(reverseGeocodedLast.getTime() < centerChangedLast.getTime())
  reverseGeocode();
  }
}, 1000);
google.maps.event.addListener(map, 'zoom_changed', function() {
			//document.getElementById("zooming_factor").value = map.getZoom();
		});
	}

  function getCenterLatLngText() {
return '(' + map.getCenter().lat() +', '+ map.getCenter().lng() +')';
  }

  function centerChanged() {
centerChangedLast = new Date();
var latlng = getCenterLatLngText();
//document.getElementById('latlng').innerHTML = latlng;
document.getElementById('address').innerHTML = '';
currentReverseGeocodeResponse = null;
  }

  function reverseGeocode() {
reverseGeocodedLast = new Date();
geocoder.geocode({latLng:map.getCenter()},reverseGeocodeResult);
  }

  function reverseGeocodeResult(results, status) {
currentReverseGeocodeResponse = results;
if(status == 'OK') {
  if(results.length == 0) {
document.getElementById('address').innerHTML = 'None';
  } else {
document.getElementById('address').innerHTML = results[0].formatted_address;
  }
} else {
  document.getElementById('address').innerHTML = 'Error';
}
  }


  function geocode() {
var address = document.getElementById("address").value;
if(address) {
		geocoder.geocode({
		'address': address,
		'partialmatch': true}, geocodeResult);
	 }
  }

  function geocodeResult(results, status) {
if (status == 'OK' && results.length > 0) {
  map.fitBounds(results[0].geometry.viewport);
	  map.setZoom(<?php echo $zooming_factor;?>);
	  addMarkerAtCenter();
	  
} else {
  alert("Geocode was not successful for the following reason: " + status);
}
	
}

  function addMarkerAtCenter() {
	var marker = new google.maps.Marker({
position: map.getCenter(),
		draggable: true,
map: map
});
	
	updateMarkerAddress('Dragging...');
	updateMarkerPosition(marker.getPosition());
	geocodePosition(marker.getPosition());

	google.maps.event.addListener(marker, 'dragstart', function() {
	updateMarkerAddress('Dragging...');
});
	
google.maps.event.addListener(marker, 'drag', function() {
	updateMarkerPosition(marker.getPosition());
});
	
google.maps.event.addListener(marker, 'dragend', function() {
	geocodePosition(marker.getPosition());
   });



var text = 'Lat/Lng: ' + getCenterLatLngText();
if(currentReverseGeocodeResponse) {
  var addr = '';
  if(currentReverseGeocodeResponse.size == 0) {
addr = 'None';
  } else {
addr = currentReverseGeocodeResponse[0].formatted_address;
  }
  text = text + '<br>' + 'address: <br>' + addr;
}

var infowindow = new google.maps.InfoWindow({ content: text });

google.maps.event.addListener(marker, 'click', function() {
  infowindow.open(map,marker);
});
}
  
function updateMarkerAddress(str) {
	//document.getElementById('address').value = str;
}
   
function updateMarkerStatus(str) {
	document.getElementById('markerStatus').innerHTML = str;
}
   
function updateMarkerPosition(latLng) {
	document.getElementById('geo_latitude').value = latLng.lat();
	document.getElementById('geo_longitude').value = latLng.lng();
}
 
var geocoder = new google.maps.Geocoder();

function geocodePosition(pos) {
	geocoder.geocode({
		latLng: pos
	}, function(responses) {
		if (responses && responses.length > 0) {
			updateMarkerAddress(responses[0].formatted_address);
		} else {
			updateMarkerAddress('Cannot determine address at this location.');
		}
	});
}

function changeMap() {
	var newlatlng = document.getElementById('geo_latitude').value;
	var newlong = document.getElementById('geo_longitude').value;
	var latlng = new google.maps.LatLng(newlatlng,newlong);
	var map = new google.maps.Map(document.getElementById('map_canvas'), {
		zoom: CITY_MAP_ZOOMING_FACT,
		center: latlng,
		mapTypeId: google.maps.MapTypeId.<?php echo $map_type;?>
	});
	
	var marker = new google.maps.Marker({
		position: latlng,
		title: 'Point A',
		map: map,
		draggable: true
	  });
		
	updateMarkerAddress('Dragging...');
	updateMarkerPosition(marker.getPosition());
	geocodePosition(marker.getPosition());

	google.maps.event.addListener(marker, 'dragstart', function() {
		updateMarkerAddress('Dragging...');
	});
		
	google.maps.event.addListener(marker, 'drag', function() {
		//updateMarkerStatus('Dragging...');
		updateMarkerPosition(marker.getPosition());
	});
		
	google.maps.event.addListener(marker, 'dragend', function() {
		//updateMarkerStatus('Drag ended');
		geocodePosition(marker.getPosition());
	});
}
	
	
google.maps.event.addDomListener(window, 'load', initialize);
<?php if(isset($_REQUEST['pid']) || isset($_REQUEST['post']) || isset($_REQUEST['backandedit'])|| isset($_REQUEST['renew'])):?>
	google.maps.event.addDomListener(window, 'load', changeMap);
<?php else: ?>
	google.maps.event.addDomListener(window, 'load', geocode);
<?php endif; ?>

/* ]]> */
</script>
<input type="button" class="btn_input_normal btn_spacer" value="<?php _e('Set Address on Map');?>" onclick="geocode();initialize();" />
<div id="map_canvas" style="height:358px;margin-left:195px;position:relative;width:410px;" class="form_row clearfix"></div>