var map;

function initialize() {
	var ebip = new google.maps.LatLng(49.5773518,3.0045753);
	var MY_MAPTYPE_ID = 'custom_style';

	var featureOpts = [
			{
				"featureType":"landscape.man_made",
				"elementType":"all",
				"stylers":[
					{"visibility":"off"}
				]
			},
			{
				"featureType":"landscape.natural",
				"elementType":"all",
				"stylers":[
					{"saturation":"-100"},
					{"gamma":2}
				]},
			{
				"featureType":"poi",
				"elementType":"all",
				"stylers":[
					{"saturation":"-100"},
					{"gamma":"1.5"}
				]
			},
			{
				"featureType":"road.highway",
				"elementType":"all",
				"stylers":[
					{"hue":"#F18854"}
				]
			},
			{
				"featureType":"road.arterial",
				"elementType":"all",
				"stylers":[
					{"hue":"#ff4d00"},
					{"visibility":"simplified"},
					
					{"gamma":0.9},
					{"saturation":27}
				]
			},
			{
				"featureType":"road.local",
				"elementType":"all",
				"stylers":[
				]
			},
			{
				"featureType":"transit",
				"elementType":"all",
				"stylers":[
				]
			},
			{
				"featureType":"water",
				"elementType":"all",
				"stylers":[
					{"hue":"#003bff"},
					{"gamma":1.45}
				]
			}
	];

	var mapOptions = {
		zoom: 15,
		center: ebip,
		scrollwheel:false,
		zoomControl: true,
		zoomControlOptions: {
			style: google.maps.ZoomControlStyle.SMALL,
			position: google.maps.ControlPosition.RIGHT_CENTER
		},
		disableDefaultUI: true,
		mapTypeControlOptions: {
			mapTypeIds: [google.maps.MapTypeId.ROADMAP, MY_MAPTYPE_ID]
		},
		mapTypeId: MY_MAPTYPE_ID
	};

	map = new google.maps.Map(document.getElementById('map-canvas'),
		mapOptions);

	var styledMapOptions = {
		name: 'Custom Style'
	};

	var customMapType = new google.maps.StyledMapType(featureOpts, styledMapOptions);

	map.mapTypes.set(MY_MAPTYPE_ID, customMapType);
	var myLatlng =  new google.maps.LatLng(49.578924,3.004586);

	var marker = new google.maps.Marker({
		position: myLatlng,
		map: map,
		title: 'Ebip'
	});

	google.maps.event.addDomListener(window, 'load', initialize);
}

function loadScript() {
	var script = document.createElement('script');
	script.type = 'text/javascript';
	script.src = 'https://maps.googleapis.com/maps/api/js?v=3.exp'+'&callback=initialize';
	document.body.appendChild(script);
}

window.onload = loadScript;