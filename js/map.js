var map;
function initialize() {
	var mapOptions = {
		zoom: 11,
		center: new google.maps.LatLng(55.32998705651914, 37.718489537811266),
		disableDefaultUI: true
	};

	map = new google.maps.Map(document.getElementById('map-canvas'),mapOptions);

	// *******
	// function for tooltip
	// *******

	function createTooltip(marker, key) {
		//create a tooltip
		var tooltipOptions = {
			marker: marker,
			content: places[key].tooltip_html,
			icon: marker.icon,
			cssClass: 'tooltip' // name of a css class to apply to tooltip
		};
		var tooltip = new Tooltip(tooltipOptions);
	}

	// *******
	// add markers on map
	// *******

	for (var key in places) {
		var myPlace = places[key];

		if(myPlace.tooltip_html) {

			var marker = new google.maps.Marker({
				map: map,
				position: new google.maps.LatLng(myPlace.position.lat, myPlace.position.lng),
				icon: myPlace.icon,
				content: myPlace.tooltip_html,
				zIndex: myPlace.zIndex,
				animation: google.maps.Animation.DROP,
				id: myPlace.id
			});

			createTooltip(marker, key);

			if(myPlace.type == "route") {
				google.maps.event.addListener(marker, 'click', addRoute);
			}
			

		} else {

			var marker = new google.maps.Marker({
				map: map,
				position: new google.maps.LatLng(myPlace.position.lat, myPlace.position.lng),
				icon: myPlace.icon,
				zIndex: myPlace.zIndex,
				animation: google.maps.Animation.DROP,
			});
		}
	}
}

// add/remove route on map

function addRoute() {

	if(typeof route == "undefined") {

		var path = places[this.id]['coord_for_route'];

		route = new google.maps.Polyline({
			path: path,
			geodesic: true,
			strokeColor: '#36bdb5',
			strokeOpacity: 1.0,
			strokeWeight: 7
		});

		route.setMap(map);

	} else {

		route.setMap(null);
		route = undefined;

		var path = places[this.id]['coord_for_route'];

		route = new google.maps.Polyline({
			path: path,
			geodesic: true,
			strokeColor: '#36bdb5',
			strokeOpacity: 1.0,
			strokeWeight: 7
		});

		route.setMap(map);
	}
}
google.maps.event.addDomListener(window, 'load', initialize);