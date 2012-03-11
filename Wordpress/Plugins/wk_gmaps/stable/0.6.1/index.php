<?php
/* 
 Plugin Name: wk_gmaps
 Plugin URI: http://knorcedger.com
 Description: Displays a google map with markers Google Maps API V3
 Version: 0.6.1
 Author: Achilleas Tsoumitas
 Author URI: http://knorcedger.com
 */
?>
<?php
/**
 * Displays a google map with markers
 * 
 * Example:
 * wk_gmaps('600', '325', $addresses, $titles, $texts, $coordinates, 'http://www.mcdonalds.gr/wp-content/themes/mcdonalds-orange/images/pin.png', 'last', '37.968831', '23.576631', '8');
 * 
 * @return 
 * @param int $width
 * @param int $height
 * @param array $addresses
 * @param array $titles Displayed on marker hover
 * @param array $texts The text inside the bubble
 * @param array $coordinates The coordinates of each marker, or empty value. Coordinates are prefered compared to address
 * @param string $icon The icon of the marker
 * @param string $center_to_marker To which marker to center the map. Values 0, last, an integer
 * @param float $center_longitude
 * @param float $center_latitude
 * @param int $zoom
 */
function wk_gmaps($width, $height, $addresses, $titles, $texts, $coordinates, $icon, $center_to_marker, $center_longitude, $center_latitude, $zoom){
?>

	<div id="map_canvas" style="width:<?php echo $width; ?>px; height:<?php echo $height; ?>px"></div>

	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
	<script type="text/javascript">
		var geocoder;
		var map;
		var image = '<?php echo $icon; ?>';
		//var infowindow;

		function initialize() {
			geocoder = new google.maps.Geocoder();
			var latlng = new google.maps.LatLng(<?php	echo $center_longitude; ?>, <?php echo $center_latitude; ?>);
			var myOptions = {
				zoom: <?php	echo $zoom; ?>,
				center: latlng,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			};
			map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
			//
			google.maps.event.addListener(map, 'click', function() {
				closeInfoWindows();
				
			});
			//
			<?php
			$i = 0;
			foreach($addresses as $val){
				//check if we need to center to any marker
				if($center_to_marker == '0'){
					$gocenter = '0';
				}elseif($center_to_marker == 'last'){
					if(sizeof($addresses) == $i+1){
						$gocenter = '1';
					}
				}else{
					if($center_to_marker == $i+1){
						$gocenter = '1';
					}
				}
			?>
				codeAddress("<?php echo $val; ?>", "<?php	echo $titles[$i]; ?>", "<?php	echo $texts[$i]; ?>", "<?php echo $coordinates[$i]; ?>", "<?php echo $gocenter; ?>");
			<?php
				$i++;
			}
			?>
			//
		
		}
	
		function codeAddress(address, title, text, coordinates, gocenter) {
			//var address = document.getElementById("address").value;
			if(coordinates == ''){
				if (geocoder) {
					geocoder.geocode( { 'address': address}, function(results, status) {
						if (status == google.maps.GeocoderStatus.OK) {
							//check if we center the mar on this marker
							if(gocenter == '1'){
								map.setCenter(results[0].geometry.location);
							}
							var marker = new google.maps.Marker({
								map: map, 
								position: results[0].geometry.location,
								title: title,
								icon: image
							});
							//
							addMessage(marker, text);
						} else {
							//alert("Geocode was not successful for the following reason: " + status);
						}
					});
				}
			}else{
				//alert("f="+coordinates+"e"+title);
				var c = coordinates.split(',');
				var lat = parseFloat(c[0]);
				var lon = parseFloat(c[1]);
				var myLatlng = new google.maps.LatLng(lat,lon);
				//check if we center the mar on this marker
				if(gocenter == '1'){
					map.setCenter(myLatlng);
				}
				var marker = new google.maps.Marker({
					map: map, 
					position: myLatlng,
					title: title,
					icon: image
				});
				//
				addMessage(marker, text);
			}
		}

		function addMessage(marker, text) {
			//var message = ["This","is","the","secret","message"];
			var infowindow = new google.maps.InfoWindow(
				{ content: text//,
					//maxWidth: 50
				});
			google.maps.event.addListener(marker, 'click', function() {
				infowindow.open(map,marker);
			});
		}

		function closeInfoWIndows(){
			infowindow.close();
		}


	</script>
<?php
}
?>
