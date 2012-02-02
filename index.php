<!DOCTYPE html>
<html>
  <head>
  	<title>Creating a custom Tooltip in Google Maps JavaScript API V3</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <link href="css/style.css" rel="stylesheet" type="text/css" >
    <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=true"></script>
    <script type="text/javascript" src="js/tooltip.js"></script>
    <script type="text/javascript" src="js/places.js"></script>
    <script type="text/javascript">
// Used to keep track of the open InfoWindow, so when 
// a new one is about to be open, we close the old one.
var lastOpenInfoWin = null;
// Create map on DOM load
// I'm using an array of places(places.js) to populate the markers
function createMap() {
	var mapDiv = document.getElementById("map_canvas");
 	if(places.length){
		var map;
		// Set chicago
		var latlng =new google.maps.LatLng(41.881944, -87.627778);
		var myOptions = {
			zoom: 10,
			center:  latlng,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		}
		map = new google.maps.Map(mapDiv, myOptions);
		for (var key in places){
			var myPlace = places[key];
			if (myPlace.position) {
				var marker = new google.maps.Marker({
					map: map,
					position: new google.maps.LatLng(myPlace.position.lat, myPlace.position.lng)
				});
			createInfoWindow(marker, key);
			createTooltip(marker, key);
										
		}
	} 
		
	function createInfoWindow(marker, key) {
			//create an infowindow for this marker
			var infowindow = new google.maps.InfoWindow({
			  content: places[key].infowin_html,
			  maxWidth:250
			});
			//open infowindo on click event on marker.
			google.maps.event.addListener(marker, 'click', function() {
				if(lastOpenInfoWin) lastOpenInfoWin.close();
				lastOpenInfoWin = infowindow;
			  infowindow.open(marker.get('map'), marker);
			});
			
	}
	// Here is where we create a tooltip for each marker,
	// with content set to plcaes[placeindex].tooltip_html 
	function createTooltip(marker, key) {
			//create a tooltip 
			var tooltipOptions={
				marker:marker,
				content:places[key].tooltip_html,
				class:'tooltip' // name of a css class to apply to tooltip
			};
			var tooltip = new Tooltip(tooltipOptions);
			//show tooltip pn mouseover event.
			google.maps.event.addListener(marker, 'mouseover', function() {
				tooltip.show();
			});
			//hide tooltip on mouseout event.
			google.maps.event.addListener(marker, 'mouseout', function() {
				tooltip.hide();
			});
		}
	}
}




  
	</script>
    
</head>
<body onload="createMap();">
<div id="map_canvas"></div>
</body>
</html>