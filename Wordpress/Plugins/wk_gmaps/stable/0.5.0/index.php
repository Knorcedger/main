<?php
/* 
 Plugin Name: wk_gmaps
 Plugin URI: http://o-some.com
 Description: Displays a google map with markers
 Version: 0.5.0
 Author: Achilleas Tsoumitas
 Author URI: http://knorcedger.com
 */
?>
<?php
/**
 * Displays a google map with markers
 * 
 * Example:
 * $name[3] = 'test';
 * $address[3] = 'Ειρήνης 109, Πέραμα|37.966768|23.559698';
 * $link[3] = 'http://test.gr';
 * wk_gmaps('ABQIAAAAikctV_dAl_j58zfmAO231RSEHXPjHPrfrzvJhdsUPc5PF7Gq_xQbyuPsjih0NI3ckHf8FOBLYXtTvQ', $name, $address, $link, '37.968831', '23.576631', '14', '"<strong>" + name + "</strong><br />" + address + "<br />" + "<a href=\'" + link + "\'>Περισσότερες Πληροφορίες</a>"', '0')
 * 
 * @return 
 * @param string $key
 * @param int $width
 * @param int $height
 * @param array $name
 * @param array $address
 * @param array $link
 * @param num $center_longitude
 * @param float $center_latitude
 * @param float $zoom
 * @param string $message
 * @param int $openBalloon[optional]
 */
function wk_gmaps($key, $width, $height, $name, $address, $link, $center_longitude, $center_latitude, $zoom, $message, $openBalloon = '0'){?>

<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=<?php echo $key; ?>" type="text/javascript"></script>
<script type="text/javascript">
	
	var map;
    var geocoder;

	function initialize() {
		map = new GMap2(document.getElementById("map_canvas"));
		map.addControl(new GSmallMapControl());
		map.setCenter(new GLatLng(<?php echo $center_longitude; ?>, <?php echo $center_latitude; ?>), <?php echo $zoom; ?>);

		//create object for address finding
		geocoder = new GClientGeocoder();
		var zoom = <?php echo $zoom; ?>;
		var openBalloon = <?php echo $openBalloon; ?>;
		<?php $i=0; foreach($name as $val){ ?>
			var id = '<?php echo $i; ?>';
			var name = '<?php echo $val; ?>';
			var link = '<?php echo $link[$i]; ?>';
			<?php
			//check if it is address or coordinates
			$temp = explode('|', $address[$i]);
			//if there no second var, its an address
			if($temp[1] == ''){ ?>
				var address = '<?php echo $address[$i]; ?>';
				showAddress(id, name, address, link, zoom, openBalloon);
			<?php
			}else{ ?>
				var address = '<?php echo $temp[0]; ?>';
				var longitude = '<?php echo $temp[1]; ?>';
				var latitude = '<?php echo $temp[2]; ?>';
				showCoordinates(id, name, address, longitude, latitude, link, zoom, openBalloon);
			<?php }
			?>
		<?php $i++; } ?>
		
		
	
		function showAddress(id, name, address, link, zoom, openBalloon) {
			geocoder.getLatLng(address,	function(point) {
				if (!point) {
					//document.write(address);
					//alert(address + " not found");
				} else {
					var marker = new GMarker(point);
					//add marker on map
					map.addOverlay(marker);
					//message to display in ballon
					var myHtml = <?php echo $message; ?>;
					//show ballon on click
					GEvent.addListener(marker, "click", function() {
						marker.openInfoWindowHtml(myHtml);
					});
					//show ballon on start
					if (openBalloon == '1') {
						marker.openInfoWindowHtml(myHtml);
					}
				}
			});
		}
		
		
		function showCoordinates(id, name, address, longitude, latitude, link, zoom, openBalloon){
			var point = new GLatLng(longitude, latitude);
			var marker = new GMarker(point);
			//add marker on map
			map.addOverlay(marker);
			//message to display in ballon
			var myHtml = <?php echo $message; ?>;
			//show ballon on click
			GEvent.addListener(marker, "click", function() {
				marker.openInfoWindowHtml(myHtml);
			});
			//show ballon on start
			if (openBalloon == '1') {
				marker.openInfoWindowHtml(myHtml);
			}
		}
	}
	
</script>
<div id="map_canvas" style="width:<?php echo $width; ?>px; height:<?php echo $height; ?>px"></div>
<?php } ?>
