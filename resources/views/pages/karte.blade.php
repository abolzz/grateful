@extends('layouts.app')
        
@section('content')
    <h1>Karte</h1>
    <div id="address-map-container" style="width:100%;height:800px; ">
        <div style="width: 100%; height: 100%" id="address-map"></div>
    </div>
@endsection

@foreach ($shops as $shop)
	<?php $locations[]=array( 'title'=>$shop->name, 'address'=>$shop->address ); ?>
@endforeach

@section('scripts')
    <script type="application/javascript" src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&language=lv" async defer></script>
    <script type="application/javascript">
    	var locations = [
    	<?php for($i=0;$i<sizeof($locations);$i++)
        { ?>
			  ['<?php echo $locations[$i]['title']?>', '<?php echo $locations[$i]['address']?>'],
		<?php } ?>
		];

		var geocoder;
		var map;

		function initialize() {
		  var bounds = new google.maps.LatLngBounds();
		  map = new google.maps.Map(
		    document.getElementById("address-map-container"), {
		      center: new google.maps.LatLng(56.949559, 24.104823),
		      zoom: 12,
		      mapTypeId: google.maps.MapTypeId.ROADMAP
		    });
		  geocoder = new google.maps.Geocoder();

		  for (i = 0; i < locations.length; i++) {


		    geocodeAddress(locations, i);
		  }
		}
		var bounds = new google.maps.LatLngBounds();
		google.maps.event.addDomListener(window, "load", initialize);

		function geocodeAddress(locations, i) {
		  var title = locations[i][0];
		  var address = locations[i][1];
		  geocoder.geocode({
		      'address': locations[i][1]
		    },

		    function(results, status) {
		      if (status == google.maps.GeocoderStatus.OK) {
		        var marker = new google.maps.Marker({
		          icon: 'http://maps.google.com/mapfiles/ms/icons/green.png',
		          map: map,
		          position: results[0].geometry.location,
		          title: title,
		          animation: google.maps.Animation.DROP,
		          address: address
		        })
		        infoWindow(marker, map, title, address);
		        bounds.extend(marker.getPosition());
		        map.fitBounds(bounds);
		      } else {
		        alert("geocode of " + address + " failed:" + status);
		      }
		    });
		}

		function infoWindow(marker, map, title, address, url) {
		  google.maps.event.addListener(marker, 'click', function() {
		    var html = "<div><h3>" + title + "</h3><p>" + address + "</div></p>";
		    iw = new google.maps.InfoWindow({
		      content: html,
		      maxWidth: 350
		    });
		    iw.open(map, marker);
		  });
		}

		function createMarker(results) {
		  var marker = new google.maps.Marker({
		    icon: 'http://maps.google.com/mapfiles/ms/icons/blue.png',
		    map: map,
		    position: results[0].geometry.location,
		    title: title,
		    animation: google.maps.Animation.DROP,
		    address: address
		  })
		  bounds.extend(marker.getPosition());
		  map.fitBounds(bounds);
		  infoWindow(marker, map, title, address);
		  return marker;
		}
    </script>
@stop
