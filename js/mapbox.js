var Mapbox = function() {

	var map;
	var url = 'http://api.tiles.mapbox.com/v3/ghendetta.map-15nqlevx.jsonp';

	// map layers
	var layers = {};
	layers.battles = new L.LayerGroup();
	layers.specials = new L.LayerGroup();
	layers.regions = new L.LayerGroup();

	/**
	 * Add regions to the map and bind popups
	 */
	var addRegions = function(regions) {
		var region, coords, points, polygon, clan, html, max;
		var centerLon = 0, centerLat = 0,totalCoords = 0;

		for (i in regions) {
			region = regions[i];
			coords = region.coords;

			// create polygon points
			points = new Array();
			for (j in coords) {
				centerLon += parseFloat(coords[j].lon);
				centerLat += parseFloat(coords[j].lat);
				totalCoords++;

				points.push(new L.LatLng(coords[j].lon, coords[j].lat));
			}

			// create polygon
			polygon = new L.Polygon(points, {
				color: '#333333',
				opacity: 0.8,
				weight: 2,
				fillColor: '#' + ((region.clans[region.leader] && region.clans[region.leader].color) ? region.clans[region.leader].color : '666666'),
				fillOpacity: 0.35
			});

			// add to layer
			layers.regions.addLayer(polygon);

			// only show popup when occupied
			if(region.clans[region.leader]) {

				html = '<h1>' + region.name + '</h1><img src="' + region.clans[region.leader].icon + '" /><ul class="statistics">';
				max = region.clans[region.leader].possession;
				for (j in region.clans) {
					clan = region.clans[j];
					html += '<li class="' + clan.name + '"><span style="height:' + (clan.possession / max) * 100 + '%">' + clan.name + ' ' + clan.posession + '%</span></li>';
				}
				html += '</ul>';

				// bind popup
				polygon.bindPopup(html);
			}
		}

		// add polygons to map
		showLayer(layers.regions);

		// set map center
		map.setView(new L.LatLng(centerLon / totalCoords, centerLat / totalCoords), 12);
	}

	/**
	 * Add battle markers to the map
	 */
	var addBattles = function(battles) {
		var battle, marker;

		var battleIcon = L.Icon.extend({
		    iconUrl: static_url + 'img/ico_battle.svg',
		    iconSize: new L.Point(32, 44),
		    shadowUrl: null,
		    iconAnchor: new L.Point(14, 40),
		});

		for (i in battles) {
			battle = battles[i];

			marker = new L.Marker(new L.LatLng(battle.lat, battle.lon), {icon: new battleIcon()});
			
			// generate html
			html = '<h1>' + battle.name + '</h1><img src="' + static_url + 'img/ico_sword.svg" /><span class="points">+' + battle.points + '</span>';

			// bind popup
			//marker.bindPopup(html);
			
			// add to layer
			layers.battles.addLayer(marker);
		}

		// add battles to map
		showLayer(layers.battles);
	}

	/**
	 * Add venue specials to the map
	 */
	var addSpecials = function(venues) {
		var venue, marker, html;

		for (i in venues) {
			venue = venues[i];

			venueIcon = L.Icon.extend({
			    iconUrl: static_url + 'img/ico_arena.svg',
			    iconSize: new L.Point(32, 44),
			    shadowUrl: null,
			    iconAnchor: new L.Point(14, 40),
			});

			// create marker
			marker = new L.Marker(new L.LatLng(venue.lat, venue.lon), {icon: new venueIcon()});

			// generate html
			html = '<h1>' + venue.name + '</h1><img src="' + static_url + 'img/ico_tower.svg" /><span class="points">+' + venue.multiplier + '</span>';

			// bind popup
			marker.bindPopup(html);

			// add to layer to group
			layers.specials.addLayer(marker);
		}
		
		// add specials to map
		showLayer(layers.specials);
	}

	/**
	 * Toggle a layer
	 */
	var toggleLayer = function(layer) {
		if (layer.state === undefined) {
			showLayer(layer);
		} else {
			if(layer.state == 1) {
				hideLayer(layer);
			} else {
				showLayer(layer);
			}
		}
	}

	/**
	 * Show a layer
	 */
	var showLayer = function(layer) {
		layer.state = 1;
		map.addLayer(layer);
	}

	/**
	 * Hide a layer
	 */
	var hideLayer = function(layer) {
		layer.state = 0;
		map.removeLayer(layer);
	}

	/**
	 * Initialise the map
	 */
	var init = function(element) {

		// create map
		map = new L.Map(element, {
			minZoom: 10,
			zoom: 12
		});

		wax.tilejson(url, function(tilejson) {
			map.addLayer(new wax.leaf.connector(tilejson));

			// get regions
			$.getJSON(site_url + 'api/regions.json', {}, function(data) {
				if (data) {
					addRegions(data);
				}
			});

			// get user checkins
			$.getJSON(site_url + 'api/specials.json', {}, function(data) {
				if (data) {
					addSpecials(data);
				}
			});

			// get user checkins
			$.getJSON(site_url + 'api/users/' + user + '/battles.json', {}, function(data) {
				if (data) {
					addBattles(data);
				}
			});
		});
	}

	return {
		map : map,
		layers : layers,
		init : init,
		toggleLayer : toggleLayer,
		showLayer : showLayer,
		hideLayer : hideLayer
	}
}